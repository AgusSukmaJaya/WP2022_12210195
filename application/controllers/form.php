<?php
defined('BASEPATH') or exit('No direct script access allowed');

class form extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('temp/form_header');
            $this->load->view('form/login');
            $this->load->view('temp/form_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $login = $this->db->get_where('login', ['email' => $email])->row_array();

        if ($login) {
            if ($login['is_active'] == 1) {
                if (password_verify($password, $login['password'])) {
                    $data = [
                        'email' => $login['email'],
                        'role_id' => $login['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($login['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">wrong password!</div>');
                    redirect('form');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">has been activated!</div>');
                redirect('form');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">not register!</div>');
            redirect('form');
        }
    }

    public function register()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[login.email]');
        $this->form_validation->set_rules(
            'password1',
            'password',
            'required|trim|min_length[3]|matches[password2]',
            ['matches' => 'password dont matches!', 'min_length[3]' => 'password too short']
        );
        $this->form_validation->set_rules('password2', 'password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            $this->load->view('temp/form_header');
            $this->load->view('form/register');
            $this->load->view('temp/form_footer');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('login', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! your account has been created!</div>');
            redirect('form');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">you has been logout!</div>');
        redirect('form');
    }
}
