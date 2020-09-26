<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Welcome_model');
    }
	
	public function customerLanding()
	{   
		if ($this->session->userdata('logged_in') && $this->session->userdata('user_id'))
        {    
        	$redirect = base_url('admin/dashboard');
            redirect($redirect,'refresh');
        }
		else
		{
	    	$this->load->view('includes/header');
        	$this->load->view('custlanding');
        	$this->load->view('alert');
        }
	}

	public function validateLogin()
	{
		$result = array();
		$data = $this->input->post();
		if(!empty($data['mobile']) && !empty($data['password']))
		{
	        $result = $this->Welcome_model->validateLogin($data);
    		if(!empty($result) && $result!=false)
    		{
    			$sessiondata = array(
		        	'user_name'  => (isset($result[0]->name))? $result[0]->name : '',
		        	'logged_in' => TRUE,
		        	'user_id'=>(isset($result[0]->id))? $result[0]->id : '',
				);
    			$this->session->set_userdata($sessiondata);
    			$redirect = base_url('admin/dashboard');
				 $result = array('status'=>true,'msg'=>'Welcome '.$result[0]->name,'redirect'=>$redirect);
			}
			else
			{
				$result = array('status'=>false,'msg'=>'This Credentials are not Matching With Our Records!');
			}
	    }
	    else
	    {
	    	$result = array('status'=>false,'msg'=>'Empty or Invalid Mobile No or Password');
	    }
	    echo json_encode($result);
	}

	public function doLogout()
	{
	    $this->session->unset_userdata('user_name');
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('mobile');
		$this->session->unset_userdata('role_id');
		$this->session->sess_destroy();
		$url = base_url('custlanding');
		redirect($url,'refresh');
	}
}
