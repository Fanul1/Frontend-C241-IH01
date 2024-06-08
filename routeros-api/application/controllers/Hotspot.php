<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Hotspot extends CI_Controller
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

	public function users()
	{
		$API = $this->connectAPI();
		$hotspotuser = $API->comm('/ip/hotspot/user/print');
		$hotspotprofile = $API->comm('/ip/hotspot/user/profile/print');
	
		// Create a mapping of profiles by name
		$profilesMap = [];
		foreach ($hotspotprofile as $profile) {
			$profilesMap[$profile['name']] = $profile;
		}
	
		// Add validity, timelimit, datalimit, price, and additional on-login data to each user
		foreach ($hotspotuser as &$user) {
			$profileName = isset($user['profile']) ? $user['profile'] : '';
	
			// Initialize default values if profile does not exist
			$user['validity'] = isset($profilesMap[$profileName]['validity']) ? $profilesMap[$profileName]['validity'] : '';
			$user['timelimit'] = isset($user['limit-uptime']) ? $user['limit-uptime'] : '';
			$user['datalimit'] = isset($user['limit-bytes-total']) ? $user['limit-bytes-total'] : '';
			$user['price'] = isset($profilesMap[$profileName]['price']) ? $profilesMap[$profileName]['price'] : '';
	
			// Parse on-login string for additional data
			if (isset($profilesMap[$profileName]['on-login'])) {
				$onLoginData = $this->parseOnLogin($profilesMap[$profileName]['on-login']);
				$user = array_merge($user, $onLoginData);
			}
		}
	
		$data = [
			'title' => 'Users Hotspot',
			'totalhotspotuser' => count($hotspotuser),
			'hotspotuser' => $hotspotuser,
			'server' => $API->comm('/ip/hotspot/print'),
			'profile' => $hotspotprofile,
		];
	
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/users', $data);
		$this->load->view('template/footer');
	}	
	
	public function addUser()
	{
		$post = $this->input->post(null, true);
		$API = $this->connectAPI();

		$timelimit = empty($post['timelimit']) ? '0' : $this->formatTimeLimit($post['timelimit']);
		$datalimit = empty($post['datalimit']) ? '0' : $this->formatDataLimit($post['datalimit']);
		$API->comm('/ip/hotspot/user/add', [
			'name' => $post['user'],
			'password' => $post['password'],
			'server' => $post['server'],
			'profile' => $post['profile'],
			'limit-uptime' => $timelimit,
			'limit-bytes-total' => $datalimit,
			'comment' => $post['comment'],
		]);
		redirect('hotspot/users');
	}

	public function generateUsers()
	{
		$post = $this->input->post(null, true);
		$API = $this->connectAPI();

		$qty = $post['qty'];
		$server = $post['server'];
		$userMode = $post['user_mode'];
		$nameLength = $post['name_length'];
		$prefix = $post['prefix'];
		$character = $post['character'];
		$profile = $post['profile'];
		$timeLimit = empty($post['time_limit']) ? '0' : $this->formatTimeLimit($post['time_limit']);
		$dataLimit = empty($post['data_limit']) ? '0' : $this->formatDataLimit($post['data_limit']);
		$comment = $post['comment'];

		for ($i = 0; $i < $qty; $i++) {
			$username = $this->generateUsername($nameLength, $prefix, $character);
			$password = ($userMode == 'same') ? $username : $this->generatePassword($nameLength, $character);

			$params = [
				'name' => $username,
				'password' => $password,
				'server' => $server,
				'profile' => $profile,
				'limit-uptime' => $timeLimit,
				'limit-bytes-total' => $dataLimit,
				'comment' => $comment,
			];

			$API->comm('/ip/hotspot/user/add', $params);
		}

		$this->session->set_flashdata('success', 'Users generated successfully.');
		redirect('hotspot/users');
	}

	private function formatTimeLimit($timeLimit)
	{
		$validity = strtoupper(substr($timeLimit, -1));
		$value = (int) substr($timeLimit, 0, -1);

		switch ($validity) {
			case 'D':
				return $value * 86400; // Convert days to seconds
			case 'H':
				return $value * 3600; // Convert hours to seconds
			case 'W':
				return $value * 604800; // Convert weeks to seconds
			case 'M':
				return $value * 2592000; // Convert months to seconds
			default:
				return 0;
		}
	}

	private function formatDataLimit($dataLimit)
	{
		$unit = strtoupper(substr($dataLimit, -1));
		$value = (int) substr($dataLimit, 0, -1);

		switch ($unit) {
			case 'G':
				return $value * 1073741824; // Convert GB to bytes
			case 'M':
				return $value * 1048576; // Convert MB to bytes
			default:
				return 0;
		}
	}

	private function generateUsername($length, $prefix, $characterType)
	{
		$characters = $this->getCharacters($characterType);
		$username = $prefix;
		for ($i = 0; $i < $length; $i++) {
			$username .= $characters[rand(0, strlen($characters) - 1)];
		}

		return $username;
	}

	private function generatePassword($length, $characterType)
	{
		$characters = $this->getCharacters($characterType);
		$password = '';
		for ($i = 0; $i < $length; $i++) {
			$password .= $characters[rand(0, strlen($characters) - 1)];
		}

		return $password;
	}

	private function getCharacters($characterType)
	{
		switch ($characterType) {
			case 'alphanumeric':
				return '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			case 'numeric':
				return '0123456789';
			case 'alphabet':
				return 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			default:
				return '';
		}
	}

	public function editUser($id)
	{
		$API = $this->connectAPI();
		$data = [
			'title' => 'Edit User',
			'user' => $API->comm('/ip/hotspot/user/print', ["?.id" => '*' . $id])[0],
			'server' => $API->comm('/ip/hotspot/print'),
			'profile' => $API->comm('/ip/hotspot/user/profile/print'),
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/edit-user', $data);
		$this->load->view('template/footer');
	}

	public function saveEditUser()
	{
		$post = $this->input->post(null, true);
		$API = $this->connectAPI();

		$timelimit = empty($post['timelimit']) ? '0' : $post['timelimit'];

		$API->comm('/ip/hotspot/user/set', [
			'.id' => $post['id'],
			'name' => $post['user'],
			'password' => $post['password'],
			'server' => $post['server'],
			'profile' => $post['profile'],
			'limit-uptime' => $timelimit,
			'comment' => $post['comment'],
		]);
		redirect('hotspot/users');
	}

	public function delUser($id)
	{
		$API = $this->connectAPI();
		$API->comm("/ip/hotspot/user/remove", [".id" => '*' . $id]);
		redirect('hotspot/users');
	}

	public function active()
	{
		$API = $this->connectAPI();
		$data = [
			'title' => 'Users Active',
			'totalhotspotactive' => count($hotspotactive = $API->comm('/ip/hotspot/active/print')),
			'hotspotactive' => $hotspotactive,
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/active', $data);
		$this->load->view('template/footer');
	}

	public function delUserActive($id)
	{
		$API = $this->connectAPI();
		$API->comm("/ip/hotspot/active/remove", [".id" => '*' . $id]);
		redirect('hotspot/active');
	}

	public function profile()
	{
		$API = $this->connectAPI();
		$address_pools = $this->getAddressPools();
		$parent_queues = $this->getParentQueues();

		// Mengambil data profil dari MikroTik
		$hotspotprofile = $API->comm('/ip/hotspot/user/profile/print');

		foreach ($hotspotprofile as &$profile) {
			// Parsing data dari kolom "On Login"
			if (isset($profile['on-login'])) {
				$onLoginData = $this->parseOnLogin($profile['on-login']);
				$profile = array_merge($profile, $onLoginData);
			}
		}

		$data = [
			'title' => 'Users Profile',
			'totalhotspotprofile' => count($hotspotprofile),
			'hotspotprofile' => $hotspotprofile,
			'address_pools' => $address_pools,
			'parent_queues' => $parent_queues,
		];

		$this->load->view('template/main', $data);
		$this->load->view('hotspot/profile', $data);
		$this->load->view('template/footer');
	}

	private function parseOnLogin($onLogin)
	{
		// Inisialisasi nilai default
		$data = [
			'expired-mode' => 'None',
			'price' => '0',
			'validity' => '-',
			'selling-price' => '0',
			'lock-user' => 'Disable'
		];

		// Regex untuk memecah data on-login
		if (preg_match('/:put \(",(.*?),(.*?),(.*?),(.*?),(.*?),(.*?)"\)/', $onLogin, $matches)) {
			$data['expired-mode'] = $this->getExpiredMode($matches[1]);
			$data['price'] = $matches[2];
			$data['validity'] = $matches[3];
			$data['selling-price'] = $matches[4];
			$data['lock-user'] = $matches[6] == 'Enable' ? 'Enable' : 'Disable';
		}

		return $data;
	}

	private function getExpiredMode($code)
	{
		$modes = [
			'rem' => 'Remove',
			'ntf' => 'Notice',
			'remc' => 'Remove & Record',
			'ntfc' => 'Notice & Record'
		];
		return isset($modes[$code]) ? $modes[$code] : 'None';
	}

	public function getParentQueues()
	{
		$API = $this->connectAPI();
		$queues = $API->comm('/queue/simple/print');

		return $queues;
	}
	public function getAddressPools()
	{
		$API = $this->connectAPI();
		$pools = $API->comm('/ip/pool/print');

		return $pools;
	}

	public function addUserProfile()
{
    $post = $this->input->post(null, true);
    $API = $this->connectAPI();

    $name = preg_replace('/\s+/', '-', $post['name']);
    $sharedUsers = $post['shared_users'];
    $rateLimit = $post['rate_limit'];
    $expiredMode = $post['expired_mode'];
    $validity = isset($post['validity']) ? $post['validity'] : '';
    $price = !empty($post['price_rp']) ? $post['price_rp'] : '0';
    $sellingPrice = !empty($post['selling_price_rp']) ? $post['selling_price_rp'] : '0';
    $addressPool = $post['address_pool'];
    $lockUser = $post['lock_user'] == 'Enable' ? '; [:local mac $"mac-address"; /ip hotspot user set mac-address=$mac [find where name=$user]]' : '';
    $parentQueue = $post['parent_queue'];
    
    $randStartTime = "0" . rand(1, 5) . ":" . rand(10, 59) . ":" . rand(10, 59);
    $randInterval = "00:02:" . rand(10, 59);

	
    $onLogin = ':put (",'.$expiredMode.',' . $price . ',' . $validity . ',' . $sellingPrice . ',,' . $lockUser . ',"); 
    {:local comment [ /ip hotspot user get [/ip hotspot user find where name="$user"] comment];
    :local ucode [:pic $comment 0 2]; 
    :if ($ucode = "vc" or $ucode = "up" or $comment = "") do={ 
    :local date [ /system clock get date ]; 
    :local year [ :pick $date 7 11 ]; 
    :local month [ :pick $date 0 3 ]; 
    /sys sch add name="$user" disable=no start-date=$date interval="' . $validity . '"; 
    :delay 5s; 
    :local exp [ /sys sch get [ /sys sch find where name="$user" ] next-run];
    :local getxp [len $exp]; 
    :if ($getxp = 15) do={ 
    :local d [:pic $exp 0 6]; 
    :local t [:pic $exp 7 16]; 
    :local s ("/"); 
    :local exp ("$d$s$year $t"); 
    /ip hotspot user set comment="$exp" [find where name="$user"];
    };
    :if ($getxp = 8) do={ 
    /ip hotspot user set comment="$date $exp" [find where name="$user"]; 
    };
    :if ($getxp > 15) do={ 
    /ip hotspot user set comment="$exp" [find where name="$user"];
    }; 
    :delay 5s; 
    /sys sch remove [find where name="$user"];
    :local mac $"mac-address"; 
    :local time [/system clock get time ]; 
   	/tool fetch url="http://your-server-ip/firestore/add-data" http-method=post http-data="{
    \"date\":\"$date\",
    \"time\":\"$time\",
    \"user\":\"$user\",
    \"price\":\"$price\",
    \"address\":\"$address\",
    \"mac\":\"$mac\",
    \"validity\":\"$validity\",
    \"name\":\"$name\",
    \"comment\":\"$comment\"
	}" http-header-field="Content-Type: application/json"
	/system script add name="$date-|-$time-|-$user-|-'.$price.'-|-$address-|-$mac-|-'.$validity.'-|-'.$name.'-|-$comment" owner="$month$year" source="$date" comment="mikhmon"';

    if ($expiredMode == 'Remove' || $expiredMode == 'Notice') {
        $onLogin = $onLogin . $lockUser . "}}";
    }

    $API->comm("/ip/hotspot/user/profile/add", array(
        "name" => $name,
        "address-pool" => $addressPool,
        "rate-limit" => $rateLimit,
        "shared-users" => $sharedUsers,
        "status-autorefresh" => "1m",
        "on-login" => $onLogin,
        "parent-queue" => $parentQueue,
    ));
	$bgservice = ':local dateint do={:local montharray ( "jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec" );:local days [ :pick $d 4 6 ];:local month [ :pick $d 0 3 ];:local year [ :pick $d 7 11 ];:local monthint ([ :find $montharray $month]);:local month ($monthint + 1);:if ( [len $month] = 1) do={:local zero ("0");:return [:tonum ("$year$zero$month$days")];} else={:return [:tonum ("$year$month$days")];}}; :local timeint do={ :local hours [ :pick $t 0 2 ]; :local minutes [ :pick $t 3 5 ]; :return ($hours * 60 + $minutes) ; }; :local date [ /system clock get date ]; :local time [ /system clock get time ]; :local today [$dateint d=$date] ; :local curtime [$timeint t=$time] ; :foreach i in [ /ip hotspot user find where profile="'.$name.'" ] do={ :local comment [ /ip hotspot user get $i comment]; :local name [ /ip hotspot user get $i name]; :local gettime [:pic $comment 12 20]; :if ([:pic $comment 3] = "/" and [:pic $comment 6] = "/") do={:local expd [$dateint d=$comment] ; :local expt [$timeint t=$gettime] ; :if (($expd < $today and $expt < $curtime) or ($expd < $today and $expt > $curtime) or ($expd = $today and $expt < $curtime)) do={ [ /ip hotspot user '.$mode.' $i ]; [ /ip hotspot active remove [find where user=$name] ];}}}';

    if ($expiredMode != "None") {
        $API->comm("/system/scheduler/add", array(
            "name" => $name,
            "start-time" => $randStartTime,
            "interval" => $randInterval,
            "on-event" => $bgservice,
            "disabled" => "no",
            "comment" => "Monitor Profile $name",
        ));
    }


    redirect('hotspot/profile');
}

	public function delProfile($id)
	{
		$API = $this->connectAPI();
		$API->comm("/ip/hotspot/user/profile/remove", [".id" => '*' . $id]);
		redirect('hotspot/profile');
	}

	public function binding()
	{
		$API = $this->connectAPI();
		$data = [
			'title' => 'Users Binding',
			'totalhotspotbinding' => count($hotspotbinding = $API->comm('/ip/hotspot/ip-binding/print')),
			'hotspotbinding' => $hotspotbinding
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/binding', $data);
		$this->load->view('template/footer');
	}

	public function addBinding()
	{
		$post = $this->input->post(null, true);
		$API = $this->connectAPI();

		$address = empty($post['address']) ? '0.0.0.0' : $post['address'];
		$toaddress = empty($post['toaddress']) ? '0.0.0.0' : $post['toaddress'];

		$API->comm('/ip/hotspot/ip-binding/add', [
			'mac-address' => $post['macaddress'],
			'address' => $address,
			'to-address' => $toaddress,
			'type' => $post['type'],
			'comment' => $post['comment'],
		]);
		redirect('hotspot/binding');
	}

	public function delBinding($id)
	{
		$API = $this->connectAPI();
		$API->comm("/ip/hotspot/ip-binding/remove", [".id" => '*' . $id]);
		redirect('hotspot/binding');
	}

	public function host()
	{
		$API = $this->connectAPI();
		$data = [
			'title' => 'Users Host',
			'totalhotspothost' => count($hotspothost = $API->comm('/ip/hotspot/host/print')),
			'hotspothost' => $hotspothost
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/host', $data);
		$this->load->view('template/footer');
	}

	public function delHost($id)
	{
		$API = $this->connectAPI();
		$API->comm("/ip/hotspot/host/remove", [".id" => '*' . $id]);
		redirect('hotspot/host');
	}

	public function cookies()
	{
		$API = $this->connectAPI();
		$data = [
			'title' => 'Users Cookies',
			'totalhotspotcookies' => count($hotspotcookies = $API->comm('/ip/hotspot/cookie/print')),
			'hotspotcookies' => $hotspotcookies
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/cookies', $data);
		$this->load->view('template/footer');
	}

	public function delCookies($id)
	{
		$API = $this->connectAPI();
		$API->comm("/ip/hotspot/cookie/remove", [".id" => '*' . $id]);
		redirect('hotspot/cookies');
	}
}
