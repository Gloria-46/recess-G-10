import os
import logging
import pandas as pd
import mysql.connector
from dotenv import load_dotenv
from prophet import Prophet
import matplotlib.pyplot as plt
import numpy as np


# Load environment variables
load_dotenv()

# Configure logging
logging.basicConfig(
    filename='sales_forecast.log',
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
    SELECT created_at, quantity, product_id
    FROM order_items
    WHERE quantity IS NOT NULL
    """
    try:
        df = pd.read_sql(query, conn)
        return df
    except Exception as e:
        logging.error(f"Failed to fetch order item data: {e}")
        raise

def aggregate_weekly_demand(df):
    df['created_at'] = pd.to_datetime(df['created_at'])
    df.set_index('created_at', inplace=True)
    weekly_demand = df['quantity'].resample('W').sum().reset_index()
    weekly_demand.columns = ['ds', 'y']  # Prophet expects 'ds' and 'y'
    return weekly_demand

def aggregate_weekly_demand_per_product(df):
    df['created_at'] = pd.to_datetime(df['created_at'])
    results = {}
    for product_id, group in df.groupby('product_id'):
        group = group.set_index('created_at')
        weekly = group['quantity'].resample('W').sum().reset_index()
        weekly.columns = ['ds', 'y']
        results[product_id] = weekly
    return results

def forecast_demand(weekly_demand, periods=12):
    m = Prophet()
    m.fit(weekly_demand)
    future = m.make_future_dataframe(periods=periods, freq='W')
    forecast = m.predict(future)
    return m, forecast

def write_forecast_to_db(forecast, product_id=None):
    try:
        conn = get_db_connection()
        cursor = conn.cursor()
        # Only clear previous forecasts if not per product
        if product_id is None:
            cursor.execute("DELETE FROM sales_forecasts WHERE product_id IS NULL OR product_id = ''")
        for _, row in forecast.iterrows():
            cursor.execute(
                "INSERT INTO sales_forecasts (forecast_date, predicted_sales, lower_bound, upper_bound, product_id, created_at, updated_at) VALUES (%s, %s, %s, %s, %s, NOW(), NOW())",
                (row['ds'].date(), float(row['yhat']), float(row['yhat_lower']), float(row['yhat_upper']), product_id)
            )
        conn.commit()
        cursor.close()
        conn.close()
        logging.info(f"Forecast written to sales_forecasts table for product_id={product_id} ({len(forecast)} rows).")
    except Exception as e:
        logging.error(f"Failed to write forecast to DB for product_id={product_id}: {e}")

def main():
    logging.info("Starting weekly demand forecasting process (overall and per product).")
    try:
        conn = get_db_connection()
        df = fetch_order_item_data(conn)
        conn.close()
        if df.empty:
            logging.warning("No order item data found.")
            return
        # Overall demand
        weekly_demand = aggregate_weekly_demand(df)
        m, forecast = forecast_demand(weekly_demand, periods=12)
        forecast[['ds', 'yhat', 'yhat_lower', 'yhat_upper']].to_csv('demand_forecast.csv', index=False)
        fig = m.plot(forecast)
        plt.title('Weekly Demand Forecast (Next 12 Weeks)')
        plt.xlabel('Week Ending')
        plt.ylabel('Units Sold')
        plt.tight_layout()
        plt.savefig('demand_forecast.png')
        plt.close(fig)
        write_forecast_to_db(forecast[['ds', 'yhat', 'yhat_lower', 'yhat_upper']], product_id=None)

        # Split data: last 20% for testing
        split_idx = int(len(df) * 0.8)
        train_df = df.iloc[:split_idx]
        test_df = df.iloc[split_idx:]

        # Train Prophet on train set
        model = Prophet()
        model.fit(train_df)

        # Forecast for the test period
        test_future = test_df[['ds']]
        forecast = model.predict(test_future)

        # Calculate MAPE and accuracy
        y_true = test_df['y'].values
        y_pred = forecast['yhat'].values
        mape = np.mean(np.abs((y_true - y_pred) / y_true)) * 100
        accuracy = 100 - mape
        print(f"MAPE: {mape:.2f}%")
        print(f"Forecast Accuracy: {accuracy:.2f}%")

        # Per product demand
        weekly_per_product = aggregate_weekly_demand_per_product(df)
        for product_id, weekly in weekly_per_product.items():
            if len(weekly) < 4:  # Not enough data to forecast
                continue
            m_p, forecast_p = forecast_demand(weekly, periods=12)
            forecast_p[['ds', 'yhat', 'yhat_lower', 'yhat_upper']].to_csv(f'demand_forecast_product_{product_id}.csv', index=False)
            fig_p = m_p.plot(forecast_p)
            plt.title(f'Weekly Demand Forecast for Product {product_id} (Next 12 Weeks)')
            plt.xlabel('Week Ending')
            plt.ylabel('Units Sold')
            plt.tight_layout()
            plt.savefig(f'demand_forecast_product_{product_id}.png')
            plt.close(fig_p)
            write_forecast_to_db(forecast_p[['ds', 'yhat', 'yhat_lower', 'yhat_upper']], product_id=product_id)
        logging.info("Weekly demand forecasting (overall and per product) completed and results saved.")
    except Exception as e:
        logging.error(f"Demand forecasting failed: {e}")

if __name__ == "__main__":
    main() 