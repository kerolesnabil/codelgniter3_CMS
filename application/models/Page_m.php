<?php

class Page_m extends MY_Model{

    protected $_table_name='pages';
    protected $_order_by='parent_id,order';
    public $rules=array(
        'parent_id'=>array(
            'field'=>'parent_id',
            'label'=>'Parent',
            'rules'=>'trim|intval'
        ),
        'title'=>array(
            'field'=>'title',
            'label'=>'Title',
            'rules'=>'trim|required|max_length[100]|xss_clean'
        ),
        'template'=>array(
            'field'=>'template',
            'label'=>'Template',
            'rules'=>'trim|required|xss_clean'
        ),
        'slug'=>array(
            'field'=>'slug',
            'label'=>'Slug',
            'rules'=>'trim|required|callback__unique_slug|xss_clean'
        ),
        'body'=>array(
            'field'=>'body',
            'label'=>'Body',
            'rules'=>'trim'
        ),
    );

    public function get_new(){

        $page =new stdClass();
        $page->title='';
        $page->slug='';
        $page->body='';
        $page->template='page';
        $page->parent_id=0;
        return $page;
    }
    public function get_no_parents()
    {
        //Fetch pages without parents
        $this->db->select('id, title');
        $this->db->where('parent_id',0);
        $pages=parent::get();

        //Return key => value pair array
        $array=array( 0 =>'No parent');

        if (count($pages)){
            foreach ($pages as $page){
                $array[$page->id]= $page->title;
            }
        }

        return $array;

    }

    public function get_with_parent($id=null,$single=false)
    {
        $this->db->select('pages.*,p.slug as parent_slug,p.title as parent_title');
        $this->db->join('pages as p','pages.parent_id=p.id','left');

        return parent::get($id,$single);
    }
    // use in order_ajax
    public function get_nested()
    {

        $pages=$this->db->get('pages')->result_array();

        $array=array();
        foreach ($pages as $page)
        {
            if(!$page['parent_id'])
            {
                $array[$page['id']]=$page;

            }
            else{
                $array [$page['parent_id']]['children'][]=$page;

            }
        }
        return $array;

    }

    public function save_order($pages)
    {
        if (count($pages)){
            foreach ($pages as $order=>$page){
                if ($page['item_id'] != '') {
                    $data = array(
                        'parent_id' => (int)$page['parent_id'],
                        'order' => $order
                    );

                    $this->db->set($data)->
                    where($this->_primary_key,$page['item_id'])->
                    update($this->_table_name);
                }
            }
        }
    }

    public function get_archive_link(){
        $page=parent::get_by(array('template' => 'news_archive' ),TRUE );
        return isset($page->slug) ? $page->slug : '';
    }

    public function delete_pages($id)
    {
        //Delete  page
        parent::delete($id);

        //Rest parent ID for its children
        $this->db->set(array('parent_id' =>0))->where('parent_id',$id)->update($this->_table_name);
    }


}