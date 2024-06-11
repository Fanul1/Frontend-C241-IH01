<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

        // Create a DateTime object and convert to GMT+7
        $dateTime = new DateTime('now', new DateTimeZone('UTC'));
        $dateTime->setTimezone(new DateTimeZone('Asia/Jakarta')); // GMT+7

        // Format time to H:i:s
        $time = $dateTime->format('H:i:s');

        // Store data in a session for now (in a real-world scenario, you might store it in a database)
        $_SESSION['traffic_data'][] = ['rx' => $rx, 'tx' => $tx, 'time' => $time]; // Use time from Mikrotik

        // Only keep the last 10 data points
        if (count($_SESSION['traffic_data']) > 10) {
            array_shift($_SESSION['traffic_data']);
        }

        $data = [
            'traffic_data' => $_SESSION['traffic_data'],
        ];

        echo json_encode($data); // Return data as JSON
    }

    private function getDashboardData($API)
    {
        $hotspotuser = $API->comm('/ip/hotspot/user/print');
        $hotspotactive = $API->comm('/ip/hotspot/active/print');
        $resource = $API->comm('/system/resource/print');
        $interface = $API->comm('/interface/print');
        $routerboard = $API->comm('/system/routerboard/print');
        $routerOSVersion = $API->comm('/system/package/print');

        $board = $routerboard['0']['model'];
        $routerOS = $routerOSVersion[0]['version'];
        $this->session->set_userdata('board', $board);
        $this->session->set_userdata('routerOS', $routerOS);

        return [
            'title' => 'Dashboard PotCher',
            'hotspotuser' => count($hotspotuser),
            'hotspotactive' => count($hotspotactive),
            'cpu' => $resource[0]['cpu-load'],
            'uptime' => $resource[0]['uptime'],
            'interface' => $interface,
            'board' => $board,
            'routerOS' => $routerOS,
        ];
    }

    private function handleError($message)
    {
        $this->session->set_flashdata('error', $message);
        redirect('auth');
    }
}
