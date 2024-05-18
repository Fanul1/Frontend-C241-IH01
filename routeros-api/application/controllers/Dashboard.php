<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('MIK_API');
        $this->load->helper('url');
    }

    public function index()
    {
        $ip = $this->session->userdata('ip');
        $user = $this->session->userdata('user');
        $password = $this->session->userdata('password');

        if (empty($ip) || empty($user) || empty($password)) {
            redirect('auth');
        }

        $API = new MIK_API();
        if ($API->connect($ip, $user, $password)) {
            $hotspotuser = $API->comm('/ip/hotspot/user/print');
            $hotspotactive = $API->comm('/ip/hotspot/active/print');
            $resource = $API->comm('/system/resource/print');
            $interface = $API->comm('/interface/print');

            $data = [
                'title' => 'Dashboard PotCher',
                'hotspotuser' => count($hotspotuser),
                'hotspotactive' => count($hotspotactive),
                'cpu' => $resource[0]['cpu-load'],
                'uptime' => $resource[0]['uptime'],
                'interface' => $interface,
            ];
            $this->load->view('template/main', $data);
            $this->load->view('dashboard', $data);
            $this->load->view('template/footer');
        } else {
            // Handle connection error
            $this->session->set_flashdata('error', 'Connection failed. Please check your credentials.');
            redirect('auth');
        }
    }
    public function traffic() 
    {
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

        $API = new MIK_API();
		$API->connect($ip, $user, $password);
        $getInterfacetraffic = $API->comm('/interface/monitor-traffic', array(
            'interface' => 'ether1 - ISP1',
            'once' => '',
        ));

        $rx = $getInterfacetraffic[0]['rx-bits-per-second'];
        $tx = $getInterfacetraffic[0]['tx-bits-per-second'];

        $data = [
            'tx' => $tx,
            'rx' => $rx,
        ];
        $this->load->view('traffic', $data);
    }
}