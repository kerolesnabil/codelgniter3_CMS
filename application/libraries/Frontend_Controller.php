<?php

class Frontend_Controller extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        $this->data['meta_title']=config_item('site_name');
        $this->load->helper('form');
        $this->load->library('form_validation');


        $this->load->model('Page_m'); //load stuff
        $this->load->model('Page_m');
        $this->load->model('Article_m');


        //Fetch navigation

        $this->data['menu']=$this->Page_m->get_nested();
        $this->data['news_archive_link']=$this->Page_m->get_archive_link();
        $this->data['meta_title']=config_item('site_name');






    }


}