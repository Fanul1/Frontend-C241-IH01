<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        }
        return $API;
    }
    public function logHotspot() {
        $API = $this->connectAPI();
        $data = [
            'title' => 'Log Hotspot',
        ];
        $this->load->view('template/main', $data);
        $this->load->view('log/hotspot', $data);
        $this->load->view('template/footer');
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