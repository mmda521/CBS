<?php
class Location extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('location_model');
    }

     public function index()
     {
         $this->load->helper('url');
         $data['info'] = $this->location_model->get();
         $this->load->view('CBS/location', $data);
         echo "123";

//          $query = $this->location_model->get();
//          //$query = $this->db->query('SELECT * from  CON_FREIGHTLOT');
// foreach ($data['info'] as $row)
// {
//     echo $row['GOODSSITE_NO'];
//     echo $row['STATUS'];

// }

//echo json_encode($data['info']);
//print_r($data['info']);
     }





public function view($page = 'location')
{
    if ( ! file_exists(APPPATH.'/views/CBS/'.$page.'.php'))
    {
        // Whoops, we don't have a page for that!
        show_404();
    }

    $data['title'] = ucfirst($page); // Capitalize the first letter
echo 123456;
    $this->load->view('CBS/'.$page, $data);

}


public function error($page = 'index')
{
    show_404();
}

}
