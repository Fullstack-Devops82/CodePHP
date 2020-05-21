<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->template = "";
        $this->title = "";
        
    }
    
    public function load_view($view_path, $data, $js_path = null) {
        $data['title'] = $this->title;
        $data['view_content'] = $this->load->view($view_path, $data, true);
        $data['js_path'] = $js_path;
        $this->load->view($this->template, $data);
    }

    public function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }
}