<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/* Author: scott
 * Description: Login model class
 */
class User_model extends My_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserInfo(&$user_data)
    {
        $user_id = $this->security->xss_clean($this->input->post('user_id'));
        if (DB_SUCCESS != $this->getById("users", $user_id, $user_data)) {
            return "user is not exist";
        }
        // picture path
        $picture = $user_data['picture'];
        if ($picture == "") {
            $picture = "default_picture.png";
        } else {
            $picture = "picture/" . $picture;
        }
        $picture_path = base_url() . "data/user/" . $picture;

        // status string
        if ($user_data["status"] == USER_STATUS_REQUEST) {
            $status_str = "<span class='text-warning'>" . USER_STATUS_STR_REQUEST . "</span>";
        } elseif ($user_data["status"] == USER_STATUS_ACTIVED) {
            $status_str = "<span class='text-success'>" . USER_STATUS_STR_ACTIVED . "</span>";
        } elseif ($user_data["status"] == USER_STATUS_BLOCKED) {
            $status_str = "<span class='text-danger'>" . USER_STATUS_STR_BLOCKED . "</span>";
        }
        // set data
        $user_data['picture_path'] = $picture_path;
        $user_data['status_str'] = $status_str;
        return "success";
    }

    public function updatePassword()
    {
        $user_id = $this->security->xss_clean($this->input->post('user_id'));
        $pre_password = $this->security->xss_clean($this->input->post('pre_password'));
        $new_password = $this->security->xss_clean($this->input->post('new_password'));

        if ($pre_password == "" || $new_password == "") {
            return "please fill input fields";
        }
        // check prepassword
        if (DB_SUCCESS != $this->getById("users", $user_id, $user_data, ["password"])) {
            return "user is not exist";
        }

        if ($user_data['password'] != $pre_password) {
            return "password is wrong";
        }

        // update password
        $this->db->where("id", $user_id);
        $data = array(
            "password" => $new_password,
        );
        $this->db->update("users", $data);
        if ($user_id == $this->session->userdata('id')) {
            $this->resetSession();
        }

        return "success";
    }

    public function updateUser()
    {
        $user_id = $this->security->xss_clean($this->input->post('user_id'));
        $email = $this->security->xss_clean($this->input->post('email'));
        $city = $this->security->xss_clean($this->input->post('city'));
        $picture = $this->input->post('picture');
        $thumb = $this->input->post('thumb');

        if ($email == "" || $city = "") {
            return "please fill input fields";
        }

        // update user info
        $user_id = $this->session->userdata('id');

        $this->db->where("id", $user_id);
        $data = array(
            "email" => $email,
        );
        if (isset($city)) {
            $data["city"] = $city;
        }
        // update picture
        // get_userdata
        if (isset($picture) && isset($thumb)) {
            if (DB_SUCCESS != $this->getById("users", $user_id, $user_data, ["name", "picture"])) {
                return "user is not exist";
            }
            if ($user_data["picture"] != "") {
                $this->removeFile("data/user/picture/" . $user_data["picture"]);
                $this->removeFile("data/user/thumb/" . $user_data["picture"]);
            }

            $user_name = $user_data["name"];
            $picture_name = $this->createImage("data/user/picture/", $user_name, $picture);
            if ($picture_name != "") {
                $thumb_name = $this->createImage("data/user/thumb/", $user_name, $thumb, $picture_name);
                $data['picture'] = $picture_name;
            }
        }

        //
        $this->db->update("users", $data);
        // reset session
        $this->resetSession();

        return "success";
    }

}