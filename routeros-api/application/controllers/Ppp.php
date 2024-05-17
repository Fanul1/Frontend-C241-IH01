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
		$secret = $API->comm('ppp/secret/print');
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
}