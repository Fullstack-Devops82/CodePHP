<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->title = "";
        $this->template = "template/dashboard";
        $this->check_isvalidated();
        $this->load->model('user_model');
        if ($this->session->userdata('level') != USER_TYPE_ADMIN) {
            redirect('login');
        }
    }

    // ajax
    public function ajaxgetUserInfo()
    {
        header('Content-Type: application/json');
        $data['msg'] = $this->user_model->getUserInfo($user_data);
        $data['user_data'] = $user_data;
        echo json_encode($data);
    }
    public function ajaxUpdateUser()
    {
        header('Content-Type: application/json');
        $data['msg'] = $this->user_model->updateUser();
        echo json_encode($data);
    }
    public function ajaxUpdatePassword()
    {
        header('Content-Type: application/json');
        $data['msg'] = $this->user_model->updatePassword();
        echo json_encode($data);
    }
}