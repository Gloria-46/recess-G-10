import os
import logging
import pandas as pd
import numpy as np
from sqlalchemy import create_engine
import mysql.connector
from datetime import timedelta
from dotenv import load_dotenv
from sklearn.preprocessing import StandardScaler
from sklearn.cluster import KMeans

# Load environment variables from a .env file (if present)
load_dotenv()

# Configure logging
logging.basicConfig(
    filename='rfm_segmentation.log',
    level=logging.INFO,
    format='%(asctime)s %(levelname)s:%(message)s'
)

def get_db_connection():
    try:
        conn = mysql.connector.connect(
            host=os.getenv('DB_HOST', '127.0.0.1'),
            port=int(os.getenv('DB_PORT', 3306)),
            user=os.getenv('DB_USERNAME', 'root'),
            password=os.getenv('DB_PASSWORD', ''),
            database=os.getenv('DB_DATABASE', 'vendor_dashboard')
        )
        return conn
    except Exception as e:
        logging.error(f"Database connection failed: {e}")
        raise

def get_sqlalchemy_engine():
    db_user = os.getenv('DB_USERNAME', 'root')
    db_pass = os.getenv('DB_PASSWORD', '')
    db_host = os.getenv('DB_HOST', '127.0.0.1')
    db_port = os.getenv('DB_PORT', '3306')
    db_name = os.getenv('DB_DATABASE', 'vendor_dashboard')
    return create_engine(f"mysql+pymysql://{db_user}:{db_pass}@{db_host}:{db_port}/{db_name}")

def fetch_order_data(engine):
    query = """
    SELECT user_id, order_number, created_at, total_amount
    FROM orders
    WHERE user_id IS NOT NULL
    """
    try:
        df = pd.read_sql(query, engine)
        return df
    except Exception as e:
        logging.error(f"Failed to fetch order data: {e}")
        raise

def perform_rfm(df):
    df['created_at'] = pd.to_datetime(df['created_at'])
    snapshot_date = df['created_at'].max() + timedelta(days=1)
    rfm = df.groupby('user_id').agg({
        'created_at': lambda x: (snapshot_date - x.max()).days,
        'order_number': 'nunique',
        'total_amount': 'sum'
    })
    rfm.rename(columns={
        'created_at': 'Recency',
        'order_number': 'Frequency',
        'total_amount': 'Monetary'
    }, inplace=True)
    rfm = rfm.reset_index()
    return rfm

def cluster_rfm(rfm):
    # Standardize RFM features
    features = rfm[['Recency', 'Frequency', 'Monetary']].fillna(0)
    scaler = StandardScaler()
    rfm_scaled = scaler.fit_transform(features)
    # Number of clusters from env or default to 4
    n_clusters = int(os.getenv('RFM_CLUSTERS', 4))
    kmeans = KMeans(n_clusters=n_clusters, random_state=42)
    rfm['Segment'] = kmeans.fit_predict(rfm_scaled)
    return rfm

def update_segments_in_db(rfm):
    try:
        conn = get_db_connection()
        cursor = conn.cursor()
        for _, row in rfm.iterrows():
            print(f"Updating user_id={row['user_id']} with segment={row['Segment']}")
            cursor.execute(
                "UPDATE users SET segment=%s WHERE id=%s",
                (str(row['Segment']), int(row['user_id']))
            )
        conn.commit()
        print(f"Committed updates for {len(rfm)} users.")
        cursor.close()
        conn.close()
        logging.info(f"Updated segments for {len(rfm)} users in the database.")
    except Exception as e:
        logging.error(f"Failed to update segments in DB: {e}")

def main():
    logging.info("Starting RFM segmentation process.")
    try:
        engine = get_sqlalchemy_engine()
        df = fetch_order_data(engine)
        print("Fetched orders DataFrame:")
        print(df.head())
        print("Fetched orders count:", len(df))
        if df.empty:
            logging.warning("No order data found.")
            print("No order data found.")
            return
        rfm = perform_rfm(df)
        print("RFM DataFrame:")
        print(rfm.head())
        print("RFM user_ids:", rfm['user_id'].tolist())
        rfm = cluster_rfm(rfm)
        rfm.to_csv('rfm_segments.csv', index=False)
        update_segments_in_db(rfm)
        logging.info(f"RFM segmentation and DB update completed. {len(rfm)} customers processed.")
    except Exception as e:
        logging.error(f"RFM segmentation failed: {e}")

if __name__ == "__main__":
    main()
    print("RFM segmentation completed.")