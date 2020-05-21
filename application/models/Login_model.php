<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/* Author: scott
 * Description: Login model class
 */
class Login_model extends My_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validate()
    {
        $name = $this->security->xss_clean($this->input->post('name'));
        $password = $this->security->xss_clean($this->input->post('password'));

        // check password
        if (DB_SUCCESS == $this->getByName("users", $name, $user_data)) {
            if ($user_data['password'] == $password) {
                $this->setSession($name);
                return true;
            }
        }
        return false;
    }

    public function setSession($name)
    {

        if (DB_SUCCESS == $this->getByName("users", $name, $user_data)) {
            $user_data["validated"] = true;
            $this->session->set_userdata($user_data);
        }
    }

    public function signupValidate()
    {
        $name = $this->security->xss_clean($this->input->post('name'));
        $email = $this->security->xss_clean($this->input->post('email'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $confirm = $this->security->xss_clean($this->input->post('confirm'));

        if ($name == "" || $email == "" || $password == "" || $confirm == "") {
            return "Please fill all the fields.";
        }

        if ($password != $confirm) {
            return "The cofirm password is not the same as the password.";
        }

        if (DB_SUCCESS == $this->getByName("users", $name, $user_data)) {
            return $name . " is already registed.";
        }

        $data = array(
            'name' => $name,
            'email' => $email,
            'password' => $password,
        );

        $this->db->insert('users', $data);

        $this->setSession($name);
        return "";
    }
}