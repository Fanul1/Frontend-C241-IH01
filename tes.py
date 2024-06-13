from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
import tensorflow as tf
from datetime import datetime

# Initialize Flask application
app = Flask(__name__)

# Load the CSV data
file_path = 'Updated_DataFrame_with_Date_Column.csv'
data = pd.read_csv(file_path)

data['date'] = pd.to_datetime(data['date'])

# Aggregate the number of users per day
user_counts_per_day = data.groupby('date').size().reset_index(name='user_count')

data['datetime'] = pd.to_datetime(data['datetime'])

# Extract the date and hour from the datetime
data['date'] = data['datetime'].dt.date
data['hour'] = data['datetime'].dt.hour

# Aggregate data to get the number of users per hour
user_count_per_hour = data.groupby(['date', 'hour']).size().reset_index(name='user_count')

# Pivot the data to have hours as columns and dates as rows
pivot_data = user_count_per_hour.pivot(index='date', columns='hour', values='user_count').fillna(0)

data_array = pivot_data.to_numpy()
mean = np.mean(data_array, axis=0)
std = np.std(data_array, axis=0)

time_step = 1

# Load the trained LSTM model
model = tf.keras.models.load_model('lstm_user_prediction_model.keras')

# Function to prepare the input sequence for a given date
def prepare_input_sequence(date, time_step, mean, std):
    date = pd.to_datetime(date).date()
    date_idx = pivot_data.index.get_loc(date) if date in pivot_data.index else len(pivot_data) - 1
    input_sequence = pivot_data.iloc[date_idx - time_step:date_idx].values
    input_sequence = (input_sequence - mean) / std
    # Reshape input to be 3-dimensional (1 sample, time_step, features)
    input_sequence = input_sequence.reshape(1, time_step, input_sequence.shape[1])
    return input_sequence

# Function to predict the number of users for a specific date
def predict_for_date(date, model, pivot_data, time_step, mean, std):
    input_sequence = prepare_input_sequence(date, time_step, mean, std)
    next_day_predict = model.predict(input_sequence)
    next_day_predict = next_day_predict * std + mean
    next_day_predict = np.round(next_day_predict).astype(int)  # Round to nearest integer
    return next_day_predict

# Define API endpoint for predicting users
@app.route('/predict_users', methods=['POST'])
def predict_users():
    data = request.get_json()
    user_input_date = data['date']

    # Ensure the date is valid
    try:
        datetime.strptime(user_input_date, '%Y-%m-%d')
    except ValueError:
        return jsonify({'error': 'Incorrect date format. Please enter the date in YYYY-MM-DD format.'}), 400

    # Predict the number of users for the given date
    predicted_users = predict_for_date(user_input_date, model, pivot_data, time_step, mean, std)

    # Prepare response JSON
    response = {
        'date': user_input_date,
        'predicted_users': predicted_users[0].tolist(),  # Convert numpy array to list
        'total_users': int(np.sum(predicted_users))  # Convert total_users to integer
    }

    return jsonify(response)

# Run the Flask app
if __name__ == '__main__':
    app.run(debug=True)
