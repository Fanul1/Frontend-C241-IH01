<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ppp extends CI_Controller
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
	public function secret()
	{
		$API = $this->connectAPI();
		$secret = $API->comm('/ppp/secret/print');
		$profile = $API->comm('/ppp/profile/print');
		$data = [
			'title' => 'PPP Secret',
			'totalsecret' => count($secret),
			'secret' => $secret,
			'profile' => $profile,
		];
		$this->load->view('template/main', $data);
		$this->load->view('ppp/secret', $data);
		$this->load->view('template/footer');
	}

	public function addpppsecret()
	{
		// Ambil data dari post
		$post = $this->input->post(null, true);
		$API = $this->connectAPI();

		// Tambahkan ppp secret
		$response = $API->comm(
			"/ppp/secret/add",
			array(
				"name" => $post['name'],
				"password" => $post['password'],
				"service" => $post['service'],
				"profile" => $post['profile']
			)
		);
		// Tutup koneksi ke MikroTik
		$API->disconnect();
	}

	public function delSecret($id)
	{
		$API = $this->connectAPI();
		$API->comm(
			"/ppp/secret/remove",
			array(
				".id" => '*' . $id,
			)
		);
		redirect("ppp/secret");
	}

	public function editpppsecret()
	{
		// Ambil data dari post
		$post = $this->input->post(null, true);


		if ($API = $this->connectAPI()) {
			// Pengecualian untuk localaddress dan remoteaddress
			$localaddress = !empty($post['localaddress']) ? $post['localaddress'] : "0.0.0.0";
			$remoteaddress = !empty($post['remoteaddress']) ? $post['remoteaddress'] : "0.0.0.0";

			// Update ppp secret
			$API->comm(
				'/ppp/secret/set',
				array(
					'.id' => $post['id'],
					'name' => $post['user'],
					'password' => $post['password'],
					'service' => $post['service'],
					'profile' => $post['profile'],
					'local-address' => $localaddress,
					'remote-address' => $remoteaddress,
					'comment' => $post['comment'],
				)
			);

			// Disconnect dari MikroTik
			$API->disconnect();
		}

		// Redirect setelah update
		redirect('ppp/secret');
	}

	public function profile()
	{
		if ($API = $this->connectAPI()) {
			$profiles = $API->comm("/ppp/profile/print");
			$pools = $API->comm("/ip/pool/print");
			$bridges = $API->comm("/interface/bridge/print");

			$data = [
				'title' => 'PPP Profile',
				'profiles' => $profiles,
				'pools' => $pools,
				'bridges' => $bridges
			];

			$this->load->view('template/main', $data);
			$this->load->view('ppp/profile', $data);
			$this->load->view('template/footer');
		} else {
			// Handle connection failure
			$data = [
				'title' => 'PPP Profile',
				'profiles' => [],
				'pools' => [],
				'bridges' => [],
			];

			$this->load->view('template/main', $data);
			$this->load->view('ppp/profile', $data);
			$this->load->view('template/footer');
		}
	}

	public function addProfile()
	{
		$name = $this->input->post('name');
		$localAddress = $this->input->post('local-address');
		$remoteAddressPool = $this->input->post('remote-address-pool');
		$remoteAddressManual = $this->input->post('remote-address-manual');
		$bridge = $this->input->post('bridge');
		$onlyOne = $this->input->post('only-one');
		$rateLimit = $this->input->post('rate-limit');

		// Pilih remote address yang digunakan
		$remoteAddress = !empty($remoteAddressManual) ? $remoteAddressManual : $remoteAddressPool;
		// Stop further execution for debugging purposes

		if ($API = $this->connectAPI()) {
			$response = $API->comm("/ppp/profile/add", [
				"name" => $name,
				"local-address" => $localAddress,
				"remote-address" => $remoteAddress,
				"bridge" => $bridge,
				"only-one" => $onlyOne,
				"rate-limit" => $rateLimit
			]);
			redirect('ppp/profile');
		} else {
			// Handle connection failure
			show_error('Unable to connect to the router.');
		}
	}

	public function editProfile()
	{

		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$localAddress = $this->input->post('local-address');
		$remoteAddressPool = $this->input->post('remote-address-pool');
		$remoteAddressManual = $this->input->post('remote-address-manual');
		$bridge = $this->input->post('bridge');
		$onlyOne = $this->input->post('only-one');
		$rateLimit = $this->input->post('rate-limit');

		// Choose the remote address to use
		$remoteAddress = !empty($remoteAddressManual) ? $remoteAddressManual : $remoteAddressPool;

		if ($API = $this->connectAPI()) {
			$response = $API->comm("/ppp/profile/set", [
				".id" => $id,
				"name" => $name,
				"local-address" => $localAddress,
				"remote-address" => $remoteAddress,
				"bridge" => $bridge,
				"only-one" => $onlyOne,
				"rate-limit" => $rateLimit
			]);

			// Check response from MikroTik
			if (isset($response['!trap'])) {
				// Response contains error message
				$error_message = $response['!trap'][0]['message'];
				echo "Error from MikroTik: " . $error_message;
			} else {
				// No error message, process successful
				redirect('ppp/profile');
			}
		} else {
			// Handle connection failure
			show_error('Unable to connect to the router.');
		}
	}

	public function deleteProfile($id)
	{
		$API = $this->connectAPI();
		$API->comm("/ppp/profile/remove", [".id" => '*' . $id]);
		redirect('ppp/profile');
	}

	public function pppoe()
	{
		$API = $this->connectAPI();
		$pppoe_servers = $API->comm("/interface/pppoe-server/server/print");
		$interfaces = $API->comm("/interface/print");
		$profiles = $API->comm("/ppp/profile/print");

		$data = [
			'title' => 'PPPoE Servers',
			'pppoe_servers' => $pppoe_servers,
			'interfaces' => $interfaces,
			'profiles' => $profiles
		];

		$this->load->view('template/main', $data);
		$this->load->view('ppp/pppoe', $data);
		$this->load->view('template/footer');
	}

	public function addPppoeServer()
	{
		$API = $this->connectAPI();

		$serviceName = $this->input->post('service-name');
		$interface = $this->input->post('interface');
		$defaultProfile = $this->input->post('default-profile');

		$params = [
			"service-name" => $serviceName,
			"interface" => $interface,
			"default-profile" => $defaultProfile
		];

		$optionalFields = ['max-mtu', 'max-mru', 'mrru', 'authentication'];

		foreach ($optionalFields as $field) {
			$value = $this->input->post($field);
			if (!empty($value)) {
				$params[$field] = $value;
			}
		}

		$response = $API->comm("/interface/pppoe-server/server/add", $params);

		redirect('ppp/pppoe');
	}

	public function editPppoeServer()
	{
		$API = $this->connectAPI();

		$id = $this->input->post('id');
		$serviceName = $this->input->post('service-name');
		$interface = $this->input->post('interface');
		$defaultProfile = $this->input->post('default-profile');

		$params = [
			".id" => $id,
			"service-name" => $serviceName,
			"interface" => $interface,
			"default-profile" => $defaultProfile
		];

		$optionalFields = ['max-mtu', 'max-mru', 'mrru', 'authentication'];

		foreach ($optionalFields as $field) {
			$value = $this->input->post($field);
			if (!empty($value)) {
				$params[$field] = $value;
			}
		}

		$response = $API->comm("/interface/pppoe-server/server/set", $params);

		redirect('ppp/pppoe');
	}

	public function deletePppoeServer($id)
	{
		$API = $this->connectAPI();
		$API->comm("/interface/pppoe-server/server/remove", [".id" => '*' . $id]);
		redirect('ppp/pppoe');
	}

	public function active()
	{
		$API = $this->connectAPI();
		$active_connections = $API->comm("/ppp/active/print");

		$data = [
			'title' => 'Active Connection',
			'active_connections' => $active_connections
		];

		$this->load->view('template/main', $data);
		$this->load->view('ppp/active', $data);
		$this->load->view('template/footer');
	}

	public function deleteActiveConnection($id)
	{
		$API = $this->connectAPI();
		$API->comm("/ppp/active/remove", [".id" => '*' . $id]);
		redirect('ppp/active');
	}

}