<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
	{
        $this->load->view('auth/login');
	}

    public function login()
	{
        $data = $this->input->post();
        if (empty($data['ip']) || empty($data['user']) || empty($data['password'])) {
            $this->handleError('All fields are required.');
        }
        
        $this->session->set_userdata($data);
        redirect('dashboard');
	}

    public function logout()
    {
        $this->session->unset_userdata(['ip', 'user', 'password']);
        redirect('auth');
    }

    private function handleError($message)
    {
        $this->session->set_flashdata('error', $message);
        redirect('auth');
    }
}