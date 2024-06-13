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

        // Fetch and set dashboard data
        $dashboardData = $this->getDashboardData($API);

        // Set session data for board and routerOS
        $this->session->set_userdata('board', $dashboardData['board']);
        $this->session->set_userdata('routerOS', $dashboardData['routerOS']);

        // Assuming $data['user'] is the API username used to connect
        $loggedInUser = $data['user'];
        $this->session->set_userdata('loggedInUser', $loggedInUser);

        // Merge voucher data with dashboard data
        $viewData = array_merge($dashboardData, [
            'voucherData' => $this->jumlahVoucher($API),
            'loggedInUser' => $loggedInUser,
        ]);

        $this->load->view('template/main', $viewData);
        $this->load->view('dashboard', $viewData);
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

    private function jumlahVoucher($API)
    {
        $getData = $API->comm("/system/script/print", array("?owner" => "jun2024"));
        $dataReport = [];
        $profileCounts = ['HARIAN' => 0, 'MINGGUAN' => 0, 'BULANAN' => 0];

        date_default_timezone_set('Asia/Jakarta');
        // Get today's date in the expected format (e.g., jun/12/2024)
        $today = strtolower(date('M/d/Y'));

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

            // Add to $dataReport if the date matches today's date
            if (strtolower($entry['date']) == $today) {
                $dataReport[] = $entry;
                if (isset($profileCounts[$entry['profile']])) {
                    $profileCounts[$entry['profile']]++;
                }
            }
        }

        return $profileCounts;
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
?>