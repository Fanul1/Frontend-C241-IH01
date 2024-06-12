<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Google\Cloud\Firestore\FirestoreClient;

class Report extends CI_Controller 
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
        }
        return $API;
    }

    public function index() {
        $API = $this->connectAPI();
        $getData = $API->comm("/system/script/print", array("?owner"=>"jun2024"));
        $dataReport = [];
        $TotalReg = count($getData);
        foreach ($getData as $record) {
            $details = explode("-|-", $record['name']);
            $entry = [
                'date' => $details[0],      // Example: jun/01/2024
                'time' => $details[1],      // Example: 09:57:22
                'username' => $details[2],  // Example: ta5YA
                'price' => $details[3],     // Example: 3000
                'profile' => $details[7],   // Example: HARIAN
                'comment' => $details[8]    // Example: vc-773-06.01.24-testing
            ];
            $dataReport[] = $entry;
        }
        $data = [
            'title' => 'Report',
            'dataDump' => $dataReport
        ];
        $this->load->view('template/main', $data);
        $this->load->view('report/index', $data);
        $this->load->view('template/footer');
    }

    public function export_to_firestore() {
        require_once FCPATH . '/vendor/autoload.php';
	// Hubungkan ke API
        $API = $this->connectAPI();
        // Ambil data dari API Mikrotik
        $getData = $API->comm("/system/script/print", array("?owner" => "jun2024"));
        $dataReport = [];
        // Proses data
        foreach ($getData as $record) {
            $details = explode("-|-", $record['name']);
            $entry = [
                'date' => $details[0],
                'time' => $details[1],
                'username' => $details[2],
                'price' => $details[3],
                'profile' => $details[7],
                'comment' => $details[8]
            ];
            $dataReport[] = $entry;
        }
        // Kirim data ke Firestore
		$this->sendDataToFirestore($dataReport);
        $this->session->set_flashdata('success', 'Data berhasil diexport.');
	redirect('report');
   }
   public function export_to_csv()
    {
        // Koneksi ke API Mikrotik
        $API = $this->connectAPI();
        // Ambil data dari API Mikrotik
        $getData = $API->comm("/system/script/print", array("?owner" => "jun2024"));
        
        // Proses data
        $dataReport = [];
        foreach ($getData as $record) {
            $details = explode("-|-", $record['name']);
            $entry = [
                'date' => $details[0],
                'time' => $details[1],
                'username' => $details[2],
                'price' => $details[3],
                'profile' => $details[7],
                'comment' => $details[8]
            ];
            $dataReport[] = $entry;
        }

        // Buat konten CSV dari data
        $csvContent = $this->generateCSVContent($dataReport);

        // Definisikan nama file CSV
        $filename = 'report.csv';

        // Set header untuk respon HTTP
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Output file CSV untuk diunduh
        echo $csvContent;
    }
    public function sendDataToFirestore($data) {
        // Inisialisasi FirestoreClient dengan kredensial dari file JSON
        $jsonUrl = 'https://storage.googleapis.com/potcher-storage/potcher-7c1b96fe11b2.json';

    	// Inisialisasi FirestoreClient dengan kredensial dari file JSON yang diakses secara online
    	$firestore = new FirestoreClient([
        'keyFile' => json_decode(file_get_contents($jsonUrl), true)
    	]);
        // Mengambil referensi koleksi "reports"
        $reportsCollection = $firestore->collection('reports');
        // Mengirim data ke Firestore
         foreach ($data as $entry) {
        // Gunakan tanggal sebagai nama dokumen
        $docName = $entry['date']; // Menggunakan tanggal dari $entry['date']

        // Data yang akan disimpan dalam dokumen Firestore
        $docData = [
            'date' => $entry['date'],
            'time' => $entry['time'],
            'username' => $entry['username'],
            'price' => $entry['price'],
            'profile' => $entry['profile'],
            'comment' => $entry['comment']
        ];

        // Tambahkan dokumen ke Firestore dengan nama yang ditentukan
        $reportsCollection->document($docName)->set($docData);
        }
    }
    private function generateCSVContent($data)
    {
        $output = fopen('php://output', 'w');

        // Tulis baris header
        fputcsv($output, array('Date', 'Time', 'Username', 'Price', 'Profile', 'Comment'));

        // Tulis data
        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
    }
}
