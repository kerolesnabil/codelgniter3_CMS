<?php

class Page extends Admin_Controller
{

	public function __construct(){
		parent::__construct();
		$this->load->model('Page_m');
	}

    public function index()
    {
        // Fetch all user
        $this->data['pages']=$this->Page_m->get_with_parent();

        // Load view

        $this->data['subview']='admin/page/index';
        $this->load->view('admin/_layout_main',$this->data);

    }
    public function order()
    {
        $this->data['sortable']=true;
        $this->data['subview']='admin/page/order';
        $this->load->view('admin/_layout_main',$this->data);
    }

    public function order_ajax()
    {
        if (isset($_POST['sortable'])){
            $this->Page_m->save_order($_POST['sortable']);
        }


        $this->data['pages']=$this->Page_m->get_nested();

        $this->load->view('admin/page/order_ajax',$this->data);
    }

    public function edit ($id=null)
    {
        // Fetch a user or  set a new one
        if($id)
        {
            $this->data['page']=$this->Page_m->get($id);
            count($this->data['page']) || $this->data['errors'][]='Page could not be found';
        }else{
            $this->data['page']=$this->Page_m->get_new();
        }

        //Page for dropdown
        $this->data['pages_no_parents']=$this->Page_m->get_no_parents();

        //Set up the form
        $rules=$this->Page_m->rules;
        $this->form_validation->set_rules($rules);


        //Process the form
        if ($this->form_validation->run() == true){
            $data=$this->Page_m->array_from_post(array(
                'title',
                'slug',
                'body',
                'parent_id',
                'template'
            ));
            $this->Page_m->save($data,$id);
            redirect('admin/page');

        }
        //Load view
        $this->data['subview']='admin/page/edit';
        $this->load->view('admin/_layout_main',$this->data);

    }

    public function delete($id)
    {
        $this->Page_m->delete_pages($id);
        redirect('admin/page');

    }

    public function _unique_slug($str)
    {
        //Do NOT validation if slug already exists
        //UNLESS it`s the slug for the current user
        $id=$this->uri->segment(4);
        $this->db->where('slug',$this->input->post('slug'));
        !$id ||$this->db->where('id !=',$id);
        $page=$this->Page_m->get();

        if (count($page))
        {
            $this->form_validation->set_message('_unique_slug','%s should be unique');
            return false;
        }
        return true;

    }


}
