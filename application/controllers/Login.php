<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->template = "template/login";
    }

    public function index($msg = null)
    {
        if ($this->session->userdata('validated') == false) {
            $data['msg'] = $msg;
            $this->load_view('login/login_view', $data, 'login/signin.js');
        } else {
            if ($this->session->userdata('level') == USER_TYPE_ADMIN) {
                redirect('admin/userlist');
            } else {
                redirect('admin/welcome');
            }
        }
    }

    public function process()
    {
        $this->load->model('login_model');
        $result = $this->login_model->validate();
        if (!$result) {
            $msg = 'Username and/or password is invalid.';
            $this->index($msg);
        } else {
            if ($this->session->userdata('level') == USER_TYPE_ADMIN) {
                redirect('admin/userlist');
            } else {
                redirect('admin/welcome');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata("validated");
        redirect('login');
    }

    public function signup($msg = null)
    {
        $data['msg'] = $msg;
        $this->load_view('login/signup_view', $data, 'login/signup.js');
    }

    public function signupprocess()
    {
        // Load the model
        $this->load->model('login_model');
        // Validate the user can login
        $result = $this->login_model->signupValidate();
        // Now we verify the result
        if ("" != $result) {

            // If user did not validate, then show them login page again
            $msg = $result;
            $this->signup($msg);
        } else {
            // If user did validate,
            // Send them to members area
            $this->index("Signup is success. please login.");
        }
    }
}
