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
		$data = [
			'title' => 'Users Hotspot',
			'totalhotspotuser' => count($hotspotuser = $API->comm('/ip/hotspot/user/print')),
			'hotspotuser' => $hotspotuser,
			'server' => $API->comm('/ip/hotspot/print'),
			'profile' => $API->comm('/ip/hotspot/user/profile/print'),
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/users', $data);
		$this->load->view('template/footer');
	}

	public function addUser()
	{
		$post = $this->input->post(null, true);
		$API = $this->connectAPI();

		$timelimit = empty($post['timelimit']) ? '0' : $post['timelimit'];

		$API->comm('/ip/hotspot/user/add', [
			'name' => $post['user'],
			'password' => $post['password'],
			'server' => $post['server'],
			'profile' => $post['profile'],
			'limit-uptime' => $timelimit,
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
	
		// Mengambil data tambahan dari kolom "On Login"
		foreach ($hotspotprofile as &$profile) {
			$user = $API->comm('/ip/hotspot/user/print', ['?name' => $profile['name']]);
			if (!empty($user)) {
				if (isset($user[0]['on-login'])) {
					$profile['on-login'] = $user[0]['on-login'];
				} else {
					$profile['on-login'] = '-';
				}
			} else {
				$profile['on-login'] = '-';
			}
		}
		$data = [
			'title' => 'Users Profile',
			'totalhotspotprofile' => count($hotspotprofile),
			'hotspotprofile' => $hotspotprofile,
			'address_pools' => $address_pools,
			'parent_queues' => $parent_queues
		];
		$this->load->view('template/main', $data);
		$this->load->view('hotspot/profile', $data);
		$this->load->view('template/footer');
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
	
		$name = $post['name'];
		$addressPool = $post['address_pool'];
		$sharedUsers = $post['shared_users'];
		$rateLimit = $post['rate_limit'];
		$expiredMode = $post['expired_mode'];
		$priceRp = $post['price_rp'];
		$sellingPriceRp = $post['selling_price_rp'];
		$lockUser = $post['lock_user'];
		$parentQueue = $post['parent_queue'];
	
		// Mengatur nilai-nilai yang akan dikirim ke MikroTik API
		$params = [
			'name' => $name,
			'address-pool' => $addressPool,
			'shared-users' => $sharedUsers,
			'rate-limit' => $rateLimit,
			'expired-mode' => $expiredMode,
			'price' => $priceRp,
			'selling-price' => $sellingPriceRp,
			'lock-user' => $lockUser,
			'parent' => $parentQueue,
		];
	
		// Mengirimkan request API untuk menambahkan profil baru
		$API->comm('/ip/hotspot/user/profile/add', $params);
	
		// Ambil ID user terbaru untuk script on-login
		$userID = $API->comm('/ip/hotspot/user/print', ['?name' => $name])[0]['.id'];
	
		// Script on-login
		$script = ":put (\",{$expiredMode},{$priceRp},{$sharedUsers},{$sellingPriceRp},{$lockUser},\"); " .
				  "{ " .
				  "   /ip hotspot user set on-login=\"{$expiredMode},{$priceRp},{$sharedUsers},{$sellingPriceRp},{$lockUser}\" [find where name=\"{$name}\"]; " .
				  "}";
	
		// Tambahkan script on-login
		$API->comm('/system/script/add', ['name' => "profile_on_login_{$userID}", 'owner' => 'admin', 'source' => $script]);
	
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
