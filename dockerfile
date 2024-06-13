# Gunakan base image Python yang telah disediakan oleh Docker Hub
FROM python:3.8

# Set working directory di dalam container
WORKDIR /app

# Copy requirements.txt ke dalam container
COPY requirements.txt .

# Install dependencies
RUN pip install -r requirements.txt

# Copy seluruh kode aplikasi Flask ke dalam container
COPY . .

# Expose port yang digunakan oleh Flask
EXPOSE 5000

# Command untuk menjalankan aplikasi Flask
CMD ["python", "tes.py"]
