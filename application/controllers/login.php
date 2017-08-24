<?php
class Login extends CI_Controller{
	public function __construct (){
		parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library('session');
	}
	function index(){
		//判断用户是否登录 如果登录直接跳转到后台首页
		/*@ob_clean() ;
		@session_start();				
		$data = array() ; 
		$data = decode_data() ; 
		if(isset($data['username']) && $data['username'] != ""){
			header("Location:".site_url("admin/index"));
		}*/
             $this->load->view('CBS/view_login','');

	}
	function dologin()
    {
		$condition = array();
        //获取用户名
        $login_no = $this->input->get_post("login_no");
        if(!empty($login_no)){
            $condition['LOGIN_NO'] = $login_no;
        }
        //获取密码
        $password = $this->input->get_post("password");
        if(!empty($password)){
            $condition['PASSWORD'] = $password;
        }
        $data=  $this->user_model->get_list1($condition,'','');
        if($data){
            $this->session->set_userdata($data);
         $this->load->view('CBS/index','');
}else{
            $this->load->view('CBS/view_login','');
        }
    }

		//退出
	public function login_out(){
	    if(isset($_SESSION['LOGIN_NO']) && $_SESSION['LOGIN_NO'] ) {
            session_destroy();
            $this->load->view('CBS/view_login','');
        }
	}


}