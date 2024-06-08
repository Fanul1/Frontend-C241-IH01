<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ppp extends CI_Controller 
{
    public function secret()
    {
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

        $API = new MIK_API();
		$API->connect($ip, $user, $password);
		$secret = $API->comm('/ppp/secret/print');
        // var_dump($secret);
        // die;
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

	public function addpppsecret(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

        $API = new MIK_API();
		$API->connect($ip, $user, $password);


		//PENGECUALIAN
		if ($post['localaddress'] == "") {
			$localaddress = "0.0.0.0";
		}else{
			$localaddress = $post['$localaddress'];
		}
		if ($post['remoteaddress'] == "") {
			$remoteaddress = "0.0.0.0";
		}else{
			$remoteaddress = $post['$remoteaddress'];
		}


		$API->comm('/ppp/secret/add', array(
			'name' => $post['user'],
			'password' => $post['password'],
			'service' => $post['service'],
			'profile' => $post['profile'],
			'local-address' => $localaddress,
			'remote-address' => $remoteaddress,
			'comment' => $post['comment'],
		));
		redirect('ppp/secret');
	}

    public function delSecret($id){
        $ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

        $API = new MIK_API();
		$API->connect($ip, $user, $password);
		$API->comm("/ppp/secret/remove", array(
			".id" => '*' . $id,
		));
		redirect("ppp/secret");
    }

	public function editpppsecret(){
		$post = $this->input->post(null, true);
		$ip = $this->session->userdata('ip');
		$user = $this->session->userdata('user');
		$password = $this->session->userdata('password');

        $API = new MIK_API();
		$API->connect($ip, $user, $password);


		//PENGECUALIAN
		if ($post['localaddress'] == "") {
			$localaddress = "0.0.0.0";
		}else{
			$localaddress = $post['$localaddress'];
		}
		if ($post['remoteaddress'] == "") {
			$remoteaddress = "0.0.0.0";
		}else{
			$remoteaddress = $post['$remoteaddress'];
		}


		$API->comm('/ppp/secret/set', array(
			'.id' => $post['id'],
			'name' => $post['user'],
			'password' => $post['password'],
			'service' => $post['service'],
			'profile' => $post['profile'],
			'local-address' => $localaddress,
			'remote-address' => $remoteaddress,
			'comment' => $post['comment'],
		));
		redirect('ppp/secret');
	}
	
    public function profile()
    {
        $ip = $this->session->userdata('ip');
        $user = $this->session->userdata('user');
        $password = $this->session->userdata('password');

        $API = new MIK_API();
        $API->connect($ip, $user, $password);
        $profiles = $API->comm("/ppp/profile/print");

        $data = [
            'title' => 'PPP Profile',
            'profiles' => $profiles
        ];

        $this->load->view('template/main', $data);
        $this->load->view('ppp/profile', $data);
        $this->load->view('template/footer');
    }

    public function pppoe()
    {
        $ip = $this->session->userdata('ip');
        $user = $this->session->userdata('user');
        $password = $this->session->userdata('password');

        $API = new MIK_API();
        $API->connect($ip, $user, $password);
        $pppoe_servers = $API->comm("/interface/pppoe-server/server/print");

        $data = [
            'title' => 'PPPoE Servers',
            'pppoe_servers' => $pppoe_servers
        ];

        $this->load->view('template/main', $data);
        $this->load->view('ppp/pppoe', $data);
        $this->load->view('template/footer');
    }
	
    public function active()
    {
        $ip = $this->session->userdata('ip');
        $user = $this->session->userdata('user');
        $password = $this->session->userdata('password');

        $API = new MIK_API();
        $API->connect($ip, $user, $password);
        $active_connections = $API->comm("/ppp/active/print");

        $data = [
            'title' => 'Active Connection',
            'active_connections' => $active_connections
        ];

        $this->load->view('template/main', $data);
        $this->load->view('ppp/active', $data);
        $this->load->view('template/footer');
    }
}