<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
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

    public function index()
    {
        $API = $this->connectAPI();
        if ($API) {
            $profiles = $API->comm("/ip/hotspot/user/profile/print");

            // Adding 'all' profile manually
            $allProfile = ['name' => 'all', 'user_count' => 0];
            foreach ($profiles as &$profile) {
                $profile['user_count'] = $API->comm("/ip/hotspot/user/print", [
                    "?profile" => $profile['name']
                ]);
                $profile['user_count'] = count($profile['user_count']);
                $allProfile['user_count'] += $profile['user_count'];
            }
            array_unshift($profiles, $allProfile);

            $data = [
                'title' => 'Voucher',
                'profiles' => $profiles,
            ];

            $this->load->view('template/main', $data);
            $this->load->view('voucher/index', $data);
            $this->load->view('template/footer');
        }
    }
}