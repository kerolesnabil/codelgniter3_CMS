<?php

class Article extends Frontend_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->data['recent_news']=$this->Article_m->get_recent();
        $this->load->model('Article_m');
    }
    public function index($id,$slug){
        //Fetch the article

        $this->data['article']=$this->Article_m->get($id);

        //Return 404 if not found
        count($this->data['article']) || show_404(uri_string());

        //Redirect if slug was incorrect


        $requestes_slug=$this->uri->segment(3);
        $set_slug = $this->data['article']->slug;
        if ($requestes_slug !=$set_slug){
            redirect('article/'.$this->data['article']->id.'/'.$this->data['article']->slug,'location','301');
        }



        add_meta_title($this->data['article']->title);

        //load view
        $this->data['subview']='article';
        $this->load->view('_main_layout',$this->data);

    }
}