<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/* Author:
 * Description: Admin model class
 */
class Admin_model extends My_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    ///////////////
    public function getUserData()
    {
        $user_id = $this->security->xss_clean($this->input->post('user_id'));
        if ($user_id != null) {
            $this->db->where('id', $user_id);
        }
        $this->db->order_by("id", "desc");
        $query = $this->db->get('users');
        $rows = $query->result_array();
        $userDatas = [];
        for ($i = 0; $i < count($rows); $i++) {
            $row_item = $rows[$i];

            if ($row_item['level'] == USER_TYPE_ADMIN) {
                continue;
            }
            
            $userData = array(
                'id' => $row_item['id'],
                'name' => $row_item['name'],
                'userid' => $row_item['userid'],
                'sex' => $row_item['sex'],
                'birthday' => $row_item['birthday'],
                'age' => $row_item['age'],
            );
            
            $userDatas[] = $userData;
        }
        return $userDatas;
    }

    public function addUser()
    {
        $name = $this->security->xss_clean($this->input->post('name'));
        $userid = $this->security->xss_clean($this->input->post('userid'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $sex = $this->security->xss_clean($this->input->post('sex'));
        $birthday = $this->security->xss_clean($this->input->post('birthday'));
        $age = $this->security->xss_clean($this->input->post('age'));
        
        if ($name == "" || $userid == "" || $password == "" || $sex == "" || $birthday == "" || $age == "") {
            return "Name:" . $name . ", User ID:" . $userid . "Please fill all the fields.";
        }
        // check username
        $this->db->where('name', $name);
        $query = $this->db->get('users');
        if ($query->num_rows() == 1) {
            return "name is not available.";
        }
        
        // Prep the query
        $data = array(
            'name' => $name,
            'userid' => $userid,
            'password' => $password,
            'sex' => $sex,
            'birthday' => $birthday,
            'age' => $age,
            'level' => 1,
        );
        $this->db->insert('users', $data);
        return "success";
    }

    public function updateUser()
    {
        $name = $this->security->xss_clean($this->input->post('name'));
        $userid = $this->security->xss_clean($this->input->post('userid'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $sex = $this->security->xss_clean($this->input->post('sex'));
        $age = $this->security->xss_clean($this->input->post('age'));
        $birthday = $this->security->xss_clean($this->input->post('birthday'));

        if ($name == "" || $userid == "") {
            return "Name:" . $name . "User ID:" . $userid . "Please fill all the fields.";
        }
        // check username
        $this->db->where('userid', $userid);
        $query = $this->db->get('users');
        if ($query->num_rows() == 0) {
            return "name is not available.";
        }

        $data = array(
            'name' => $name,
            'sex' => $sex,
            'age' => $age,
            'birthday' => $birthday,
        );
        if ($password != null && $password != "") {
            $data['password'] = $password;
        }
        $this->db->where('userid', $userid);
        $this->db->update('users', $data);
        return "success";
    }

    public function delUser()
    {
        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        $this->db->where('id', $user_id);
        $query = $this->db->get("users");
        if ($query->num_rows() == 1) {
            $row = $query->row();
            if ($row->level == USER_TYPE_ADMIN) {
                return "Admin user cannot be deleted.";
            }
        }

        $this->db->where('id', $user_id);
        $this->db->delete('users');
        return "success";
    }

    private function convertDateStr($string)
    {
        $matches = array();
        $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
        if (!preg_match($pattern, $string, $matches)) {
            return null;
        }
        $date = DateTime::createFromFormat('d/m/Y', $string);
        $date->format('Y-m-d');
        return $date->format('Y-m-d');
    }

}
