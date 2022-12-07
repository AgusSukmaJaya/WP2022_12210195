<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Controller
{
    public function index()
    {
        $data['login'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('temp/header', $data);
        $this->load->view('temp/sidebar', $data);
        $this->load->view('temp/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('temp/footer',);
    }
}
