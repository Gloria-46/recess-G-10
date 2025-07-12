import os
import logging
import pandas as pd
import mysql.connector
from dotenv import load_dotenv
from surprise import Dataset, Reader, SVD
from surprise.model_selection import train_test_split

# Load environment variables
load_dotenv()

# Configure logging
logging.basicConfig(
    filename='ml_recommend.log',
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

def fetch_order_item_data(conn):
    query = """
    SELECT user_id, product_id, SUM(quantity) as total_quantity
    FROM orders
    JOIN order_items ON orders.id = order_items.order_id
    WHERE user_id IS NOT NULL
    GROUP BY user_id, product_id
    """
    try:
        df = pd.read_sql(query, conn)
        return df
    except Exception as e:
        logging.error(f"Failed to fetch order item data: {e}")
        raise

def write_recommendations_to_db(recommendations):
    try:
        conn = get_db_connection()
        cursor = conn.cursor()
        cursor.execute("DELETE FROM user_recommendations")
        for user_id, recs in recommendations.items():
            for product_id, score in recs:
                cursor.execute(
                    "INSERT INTO user_recommendations (user_id, product_id, score, created_at, updated_at) VALUES (%s, %s, %s, NOW(), NOW())",
                    (int(user_id), int(product_id), float(score))
                )
        conn.commit()
        cursor.close()
        conn.close()
        logging.info(f"Wrote recommendations for {len(recommendations)} users.")
    except Exception as e:
        logging.error(f"Failed to write recommendations to DB: {e}")

def main():
    logging.info("Starting ML-based recommendation generation.")
    try:
        conn = get_db_connection()
        df = fetch_order_item_data(conn)
        conn.close()
        if df.empty:
            logging.warning("No order item data found.")
            return
        # Prepare data for Surprise
        reader = Reader(rating_scale=(1, df['total_quantity'].max()))
        data = Dataset.load_from_df(df[['user_id', 'product_id', 'total_quantity']], reader)
        trainset = data.build_full_trainset()
        algo = SVD()
        algo.fit(trainset)
        # Generate top-N recommendations for each user
        all_users = df['user_id'].unique()
        all_products = df['product_id'].unique()
        recommendations = {}
        N = 5  # Top-N recommendations per user
        for user_id in all_users:
            user_recs = []
            user_products = set(df[df['user_id'] == user_id]['product_id'])
            for product_id in all_products:
                if product_id in user_products:
                    continue  # Skip already purchased
                pred = algo.predict(user_id, product_id)
                user_recs.append((product_id, pred.est))
            # Sort by predicted score and take top N
            top_recs = sorted(user_recs, key=lambda x: x[1], reverse=True)[:N]
            recommendations[user_id] = top_recs
        write_recommendations_to_db(recommendations)
        logging.info("ML-based recommendations generated and saved.")
    except Exception as e:
        logging.error(f"Recommendation generation failed: {e}")

if __name__ == "__main__":
    main() 