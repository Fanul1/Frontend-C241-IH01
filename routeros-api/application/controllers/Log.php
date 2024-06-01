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
    
    public function logUser() {
        $API = $this->connectAPI();
        $data = [
            'title' => 'Log User',
        ];
        $this->load->view('template/main', $data);
        $this->load->view('log/user', $data);
        $this->load->view('template/footer');
    }
}
