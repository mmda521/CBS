<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * 让ci继承自己的类库 
 * ######################################
 * 这个类里面写权限代码
 *###################################
 */

class MY_Controller extends CI_Controller{
	public    $need_login = false;  
  
        public function __construct()  
        {  
            parent::__construct(); 
			$this->load->helper('url');
$this->load->library('session');			
            $this->check_login();  
        }  
private function check_login(){ 
            if($this->need_login){  
                $session_data = $this->session->userdata('LOGIN_NO');  
                if(!$session_data){  
              redirect('CBS/view');
                }  
            }  

        }  
}