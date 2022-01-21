<?php

class User extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        // Fetch all user
        $this->data['users']=$this->User_m->get();

        // Load view
        $this->data['subview']='admin/user/index';
        $this->load->view('admin/_layout_main',$this->data);

    }

    public function edit ($id=null)
    {

        // Fetch a user or  set a new one
        if($id)
        {
            $this->data['user']=$this->User_m->get($id);
            count($this->data['user']) || $this->data['errors'][]='User could not be found';
        }else{
            $this->data['user']=$this->User_m->get_new($id);
        }

        // Set up form
        $rules=$this->User_m->rules_admin;

        $id || $rules['password']['rules'].='|required';

        $this->form_validation->set_rules($rules);


        //Process the form
        if ($this->form_validation->run() == true){
            $data=$this->User_m->array_from_post(array('name','email','password'));
            $data['password'].=$this->User_m->hash($data['password']);
            $this->User_m->save($data,$id);
            redirect('admin/user');

        }
        //Load view
        $this->data['subview']='admin/user/edit';
        $this->load->view('admin/_layout_main',$this->data);

    }

    public function delete($id)
    {
        $this->User_m->delete($id);
        redirect('admin/user');

    }

    public function login()
    {
        // Redirect a user if he `s already logged in
        $dashboard='admin/dashboard';
        $this->User_m->loggedin() ==FALSE || redirect($dashboard);
        // Set form
        $rules=$this->User_m->rules;
        $this->form_validation->set_rules($rules);


        // Process form
        if ($this->form_validation->run() == true){
            //We can login and redirect
           if ($this->User_m->login()==true)
           {
               redirect($dashboard);
           }
           else
           {
               $this->session->set_flashdata('error', 'That email/password combination does not exist');
               redirect('admin/user/login','refresh');
           }

        }
        // Load view
        $this->data['subview']='admin/user/login';
        $this->load->view('admin/_layout_model',$this->data);
    }

    public function logout()
    {
        $this->User_m->logout();
        redirect('admin/user/login');
    }

    public function _unique_email($str)
    {
        //Do NOT validation if email already exists
        //UNLESS it`s the email for the current user
        $id=$this->uri->segment(4);
        $this->db->where('email',$this->input->post('email'));
        !$id ||$this->db->where('id !=',$id);
        $user=$this->User_m->get();


        if (count($user))
        {
            $this->form_validation->set_message('_unique_email','%s should be unique');
            return false;
        }
        return true;

    }

}