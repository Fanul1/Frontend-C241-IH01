<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller 
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

    public function uploadLogo() {
        $API = $this->connectAPI();
        $data = [
            'title' => 'Upload Logo',
        ];
        $this->load->view('template/main', $data);
        $this->load->view('setting/uploadlogo', $data);
        $this->load->view('template/footer');
    }

    public function editVoucher() {
        $API = $this->connectAPI();
        // Load the current template content
        $templatePath = APPPATH . '../templatevoucher/template.html';
        if (file_exists($templatePath)) {
            $template = file_get_contents($templatePath);
        } else {
            $template = '';
        }

        $data = [
            'title' => 'Edit Template Voucher',
            'template' => $template,
        ];
        $this->load->view('template/main', $data);
        $this->load->view('setting/edittemplate', $data);
        $this->load->view('template/footer');
    }

    public function saveTemplate()  
    {
        $template = $this->input->post('template');
        // Save the template content to a file
        $templatePath = APPPATH . '../templatevoucher/template.html';
        file_put_contents($templatePath, $template);
        $this->session->set_flashdata('success', 'Template saved successfully.');
        redirect('settings/editVoucher');
    }
}