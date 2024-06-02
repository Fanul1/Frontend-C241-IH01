<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
}