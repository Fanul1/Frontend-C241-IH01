<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('MIK_API');
    }

    private function connectAPI()
    {
        $ip = $this->session->userdata('ip');
        $user = $this->session->userdata('user');
        $password = $this->session->userdata('password');

        $API = new MIK_API();
        if (!$API->connect($ip, $user, $password)) {
            $this->session->set_flashdata('error', 'Connection failed. Please check your credentials.');
            redirect('auth');
            return null;
        }
        return $API;
    }

    public function logHotspot()
    {
        $API = $this->connectAPI();
        if ($API) {
            $getlog = $API->comm("/log/print", array(
                "?topics" => "hotspot,info,debug"
            ));
            $log = array_reverse($getlog);
            $totalReg = count($getlog);

            $data = [
                'title' => 'Log Hotspot',
                'log' => $log,
                'totalReg' => $totalReg,
                '_time' => 'Time',
                '_users' => 'Users',
                '_messages' => 'Messages',
                '_hotspot_log' => 'Hotspot Log',
            ];

            $this->load->view('template/main', $data);
            $this->load->view('log/hotspot', $data);
            $this->load->view('template/footer');
        }
    }

    public function logUser()
    {
        // Connect to MikroTik API
        $API = $this->connectAPI();

        if (!$API) {
            // Handle connection error
            $data['error'] = 'Failed to connect to MikroTik API.';
            $this->load->view('template/main', $data);
            $this->load->view('template/footer');
            return;
        }

        // Get log data from MikroTik API
        $logData = [];
        $logScript = $API->comm('/system/script/print');
        foreach ($logScript as $script) {
            $scriptData = explode('-|-', $script['name']);
            $logEntry = [
                'Date' => $scriptData[0],
                'Time' => $scriptData[1],
                'Username' => $scriptData[2],
                'Address' => $scriptData[4],
                'MacAddress' => $scriptData[5],
                'Validity' => $scriptData[6]
            ];
            $logData[] = $logEntry;
        }

        // Prepare data to be passed to the view
        $data = [
            'title' => 'Log User',
            'logData' => $logData
        ];

        // Load views
        $this->load->view('template/main', $data);
        $this->load->view('log/user', $data);
        $this->load->view('template/footer');
    }

    public function export_to_csv_user()
    {
        // Koneksi ke API Mikrotik
        $API = $this->connectAPI();
        
        // Ambil data dari API Mikrotik
        $scriptData = $API->comm("/system/script/print");

        // Proses data
        $dataReport = [];
        foreach ($scriptData as $record) {
            $details = explode("-|-", $record['name']);
            $entry = [
                'Date' => $details[0],
                'Time' => $details[1],
                'Username' => $details[2],
                'Address' => $details[4],
                'MacAddress' => $details[5],
                'Validity' => $details[6]
            ];
            $dataReport[] = $entry;
        }

        // Buat konten CSV dari data
        $csvContent = $this->generateCSVContentUser($dataReport);

        // Definisikan nama file CSV
        $filename = 'logUser.csv';

        // Set header untuk respon HTTP
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Output file CSV untuk diunduh
        echo $csvContent;
        exit; // Penting: keluar dari script setelah mengirim file CSV
    }

    public function export_to_csv_hotspot()
    {
    // Connect to MikroTik API
    $API = $this->connectAPI();
    
    // Retrieve data from MikroTik API
    $getlog = $API->comm("/log/print", array(
        "?topics" => "hotspot,info,debug"
    ));

    $log = array_reverse($getlog);

    // Generate CSV content from data
    $csvContent = $this->generateCSVContentHotspot($log);

    // Define CSV file name
    $filename = 'logHotspot.csv';

    // Set headers for HTTP response
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Output CSV file for download
    echo $csvContent;
    exit; // Important: exit script after sending CSV file
    }

    private function generateCSVContentUser($data)
    {
        $output = fopen('php://output', 'w');

        // Tulis baris header
        fputcsv($output, array('Date', 'Time', 'Username', 'Address', 'MacAddress', 'Validity'));

        // Tulis data
        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
    }

    private function generateCSVContentHotspot($data)
    {
    ob_start(); // Start output buffering

    $output = fopen('php://output', 'w');

    // Write header row
    fputcsv($output, array('Time', 'Username', 'Message'));

    // Write data rows
    foreach ($data as $row) {
        // Extract username and message from message string
        preg_match('/->: (.*) \((.*)\): (.*)/', $row['message'], $matches);

        if (count($matches) == 4) {
            // Format data for CSV row
            $rowData = array(
                $row['time'],
                $matches[1] . ' (' . $matches[2] . ')',
                $matches[3]
            );
            fputcsv($output, $rowData);
        } else {
            // Log or handle errors for incorrect message format
            error_log('Format message tidak sesuai: ' . $row['message']);
        }
    }

    fclose($output);

    // Get buffered output
    $csvContent = ob_get_clean();

    return $csvContent;
    }
}

