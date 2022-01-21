<?php

class Admin_Controller extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        $this->data['meta_title']='My awesome CMS';
        $this->load->helper('form');
        $this->load->library('form_validation',$this->data);
        $this->load->library('session');
        $this->load->model('User_m');
        $this->load->helper('security');


        //Login check
        $exception_uris =array(
            'admin/User/login',
            'admin/user/logout'
        );


        if(in_array(uri_string() ,$exception_uris) == FALSE)
        {
            if ($this->User_m->loggedin()==FALSE){
                redirect('admin/User/login');
            }
        }

    }


}
