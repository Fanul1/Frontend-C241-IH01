<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'MIK_API']);
        $this->load->helper('url');
    }

    public function index()
    {
        $data = $this->session->userdata();
        if (empty($data['ip']) || empty($data['user']) || empty($data['password'])) {
            $this->handleError('Unauthorized access.');
        }

        $API = new MIK_API();
        if (!$API->connect($data['ip'], $data['user'], $data['password'])) {
            $this->handleError('Connection failed. Please check your credentials.');
        }

        $this->load->view('template/main', $this->getDashboardData($API));
        $this->load->view('dashboard');
        $this->load->view('template/footer');
    }

    public function traffic() 
    {
        $data = $this->session->userdata();
        $API = new MIK_API();
        $API->connect($data['ip'], $data['user'], $data['password']);
    
        $interface = $this->input->post('interface'); // Get selected interface from POST
    
        $trafficData = $API->comm('/interface/monitor-traffic', [
            'interface' => $interface,
            'once' => '',
        ]);
    
        $rx = isset($trafficData[0]['rx-bits-per-second']) ? $trafficData[0]['rx-bits-per-second'] : 0;
        $tx = isset($trafficData[0]['tx-bits-per-second']) ? $trafficData[0]['tx-bits-per-second'] : 0;
    
        $data = [
            'rx' => $rx,
            'tx' => $tx,
        ];
    
        $this->load->view('traffic', $data);
    }

    private function getDashboardData($API)
    {
        $hotspotuser = $API->comm('/ip/hotspot/user/print');
        $hotspotactive = $API->comm('/ip/hotspot/active/print');
        $resource = $API->comm('/system/resource/print');
        $interface = $API->comm('/interface/print');

        return [
            'title' => 'Dashboard PotCher',
            'hotspotuser' => count($hotspotuser),
            'hotspotactive' => count($hotspotactive),
            'cpu' => $resource[0]['cpu-load'],
            'uptime' => $resource[0]['uptime'],
            'interface' => $interface,
        ];
    }

    private function handleError($message)
    {
        $this->session->set_flashdata('error', $message);
        redirect('auth');
    }
}