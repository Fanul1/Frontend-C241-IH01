<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller 
{

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
        $data = [
            'title' => 'About',
        ];
        $this->load->view('template/main', $data);
        $this->load->view('about', $data);
        $this->load->view('template/footer');
    }

}