import re
import csv

def preprocess_log_line(line):
    pattern_1 = r'^(\w{3}/\d{2}/\d{4}) (\d{2}:\d{2}:\d{2}) hotspot,account,info,debug ->: (.*?): (.*)$'
    pattern_2 = r'^(\w{3}/\d{2}/\d{4}) (\d{2}:\d{2}:\d{2}) hotspot,account,info,debug adminReset: (.*?): (.*)$'
    pattern_3 = r'^(\w{3}/\d{2}/\d{4}) (\d{2}:\d{2}:\d{2}) hotspot,info,debug ->: (.*?): (.*?): (.*)$'
    pattern_4 = r'^(\w{3}/\d{2}/\d{4}) (\d{2}:\d{2}:\d{2}) hotspot,info,debug adminReset: (.*?): (.*?): (.*)$'

    match_1 = re.match(pattern_1, line)
    match_2 = re.match(pattern_2, line)
    match_3 = re.match(pattern_3, line)
    match_4 = re.match(pattern_4, line)

    if match_1:
        groups = match_1.groups()
        return {
            'date': groups[0],
            'time': groups[1],
            'hotspot': groups[2],
            'account': "Null",
            'info': groups[3],
            'debug': "Null"
        }
    elif match_2:
        groups = match_2.groups()
        return {
            'date': groups[0],
            'time': groups[1],
            'hotspot': groups[2],
            'account': "Null",
            'info': groups[3],
            'debugAdmin': "Null"
        }
    elif match_3:
        groups = match_3.groups()
        return {
            'date': groups[0],
            'time': groups[1],
            'hotspot': groups[2],
            'account': "Null",
            'info': groups[3],
            'debug': groups[4]
        }
    elif match_4:
        groups = match_4.groups()
        return {
            'date': groups[0],
            'time': groups[1],
            'hotspot': groups[2],
            'account': "Null",
            'info': groups[3],
            'debug': groups[4]
        }
    else:
        return None

def main():
    log_file_path = 'log1.txt'  # Ganti dengan jalur file log Anda
    csv_output_path = 'file.csv'  # Ganti dengan jalur file CSV output Anda

    with open(log_file_path, 'r') as file:
        with open(csv_output_path, 'w', newline='') as csv_file:
            fieldnames = ['date', 'time', 'hotspot', 'account', 'info', 'debug', 'debugAdmin']
            writer = csv.DictWriter(csv_file, fieldnames=fieldnames)
            writer.writeheader()

            for line in file:
                log_data = preprocess_log_line(line.strip())
                if log_data:
                    writer.writerow(log_data)

if __name__ == "__main__":
    main()
