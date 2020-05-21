<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->title = "";
        $this->template = "template/dashboard";
        $this->check_isvalidated();
        $this->load->model('admin_model');
        // if ($this->session->userdata('level') != USER_TYPE_ADMIN) {
        //     redirect('login');
        // }
    }

    public function userlist()
    {
        $this->title = "User List";
        $data['data'] = $this->session->userdata();
        $data['tag'] = array("table");
        $data['msg'] = null;
        $this->load_view('dashboard/userlist_view', $data, 'dashboard/userlist.js');
    }

    public function welcome()
    {
        $this->title = "Welcome";
        $data['data'] = $this->session->userdata();
        $data['tag'] = array("table");
        $data['msg'] = null;
        $this->load_view('dashboard/welcome_view', $data, 'dashboard/userlist.js');
    }

    public function ajaxGetMessage()
    {
        header('Content-Type: application/json');
        $data = $this->admin_model->getMessageInfo();
        echo json_encode($data);
    }

    public function ajaxGetUserdata()
    {
        header('Content-Type: application/json');
        $userData = $this->admin_model->getUserData();
        $result = [];
        for ($i = 0; $i < count($userData); $i++) {

            $result[] = array(
                'id' => $userData[$i]["id"],
                'name' => $userData[$i]["name"],
                'userid' => $userData[$i]["userid"],
                'sex' => $userData[$i]["sex"],
                'birthday' => $userData[$i]["birthday"],
                'age' => $userData[$i]["age"],
            );
        }
        echo json_encode($result);
    }

    public function ajaxUserAdd()
    {
        header('Content-Type: application/json');
        $data['msg'] = $this->admin_model->addUser();
        echo json_encode($data);
    }

    public function ajaxUserDel()
    {
        header('Content-Type: application/json');
        $data['msg'] = $this->admin_model->delUser();
        echo json_encode($data);
    }

    public function ajaxUserUpdate()
    {
        header('Content-Type: application/json');
        $data['msg'] = $this->admin_model->updateUser();
        echo json_encode($data);
    }
}
