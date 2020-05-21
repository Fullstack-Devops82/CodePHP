<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */
class RestApi extends CI_Controller
{
    private $result = null;
    private $errMsg = null;
    private $iv = 'fedcba9876543210';
    public function __construct()
    {
        parent::__construct();
        $this->result = array(
            "rsp_code" => "00",
            "msg" => "success",
            "data" => array(),
        );
        $this->initMsg();
        $this->load->model('rest_model');
        session_destroy();
    }

    public function getInfo()
    {
        $box_id = $this->security->xss_clean($this->input->get('box_id'));
        $this->result["rsp_code"] = $this->rest_model->getInfo($box_id, $this->result["data"]);
        $this->result["msg"] = $this->getMsg($this->result["rsp_code"]);

        if ($this->result["rsp_code"] != RSP_FAIL) {
            $box_ver = $this->security->xss_clean($this->input->get('ver'));
            $box_ver = str_replace('.', '', $box_ver);
            $this->rest_model->updatePrevAndGroupId($box_id, $box_ver);
        }
        echo $this->makeResponse($box_id);
    }

    public function makeResponse($box_id)
    {
        // $_SERVER['REMOTE_ADDR']
        if ($this->result["rsp_code"] != RSP_FAIL) {
            $version = $this->security->xss_clean($this->input->get('ver'));
            $user_ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
            $this->rest_model->setAccessInfo($box_id, $user_ip, $version);
        }

        $msg = $this->rest_model->getMessageInfo();
        if ($this->result["rsp_code"] == RSP_FAIL || $this->result["rsp_code"] == RSP_USER_BLOCK) {
            $msg = $msg[$this->result["rsp_code"]];
            $msg = str_replace("$(box_id)", $box_id, $msg);
            $this->result["msg"] = $msg;
        }

        return json_encode($this->result, true);
        // return $this->encrypt($box_id, json_encode($this->result, true));
    }

    public function login()
    {
        header('Content-Type: application/json');

        $this->load->model('rest_model');
        $this->result = $this->rest_model->validate($this->result);
        echo json_encode($this->result, true);
    }

    // error msg
    private function initMsg()
    {
        $this->errMsg = array();
        $this->errMsg[RSP_SUCCESS] = "success";
        $this->errMsg[RSP_FAIL] = "fail";
        $this->errMsg[RSP_USER_BLOCK] = "block";
    }
    private function getMsg($rsp_code)
    {
        return $this->errMsg[$rsp_code];
    }

}
