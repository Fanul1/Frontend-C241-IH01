<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $data = [
            'title' => 'Users Profile',
            'totalhotspotprofile' => count($hotspotprofile = $API->comm('/ip/hotspot/user/profile/print')),
            'hotspotprofile' => $hotspotprofile
        ];
        $this->load->view('template/main', $data);
        $this->load->view('hotspot/profile', $data);
        $this->load->view('template/footer');
    }

    public function addUserProfile()
    {
        $post = $this->input->post(null, true);
        $API = $this->connectAPI();

        $API->comm('/ip/hotspot/user/profile/add', [
            'name' => $post['user'],
            'rate-limit' => $post['rate_limit'],
            'shared-users' => $post['shared_user'],
        ]);
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
