<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	public $createdBy;
	public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in') && !$this->session->userdata('user_id'))
        {    
            redirect('/');
        }
        $this->load->model('Admin_model');
        $this->createdBy = $this->session->userdata('user_id');
    }
    
    /* function to load the admin landing(dashboard) page */
    public function loadDashboard()
    {   
        $countdata = $this->Admin_model->getDashboardCount();
        $this->load->view('includes/header');
        $this->load->view('admin/dashboard',['countdata'=>$countdata]);
        $this->load->view('alert');
    }

    /* function to view state master */
    public function stateManagement()
    {
        $this->load->view('includes/header');
        $this->load->view('admin/statemanagement');
        $this->load->view('alert'); 
    }

    /* function to get the state data */
    public function getStateData()
    {
        $statedata=$this->Admin_model->getStateData(0);
        $srno=$_POST['start']+1;
        $data=array();
        foreach($statedata->result() as $row) 
        {  
            $editaction = base_url('admin/state_edit/'.$row->id);
            $actionHtml="<a href=".$editaction." class='btn btn-info'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a onclick='deleteState(".$row->id.")' class='deleteState btn btn-sm btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></a>";

           $data[] =[
                $srno,
                $row->state,
                $actionHtml
            ]; // End Data Array
        
            $srno++;
        }
        $dataCount=count($statedata->result());
        $output =[
            "draw"              =>  intval($_POST['draw']),  
            "recordsTotal"      =>  $dataCount,  
            "recordsFiltered"   =>  $dataCount,  
            "data"              =>  $data  
        ]; // End Output Array
        echo json_encode($output);
    }

    /* function to the add State */
    public function addState()
    {   
        $state_data = array();
        $this->load->view('includes/header');
        $this->load->view('admin/addstate',['state_data'=>$state_data]);
        $this->load->view('alert');
    }

    public function saveState()
    {
       $this->form_validation->set_rules('state', 'State', 'required|is_unique[mst_state.state]',array('is_unique' => 'This %s Alrady Exist!'));

        if ($this->form_validation->run() == FALSE)
        {
            $this->addState();
        }
        else
        { 
            $postdata = $this->input->post();
            $insertFlag = $this->Admin_model->saveState($postdata,$this->createdBy,0);
            if($insertFlag)
            {
                $this->session->set_flashdata('success','New State Added!');
                $redirect_dashboard = base_url('admin/state_management');
                redirect($redirect_dashboard,'refresh');
            }
            else
            {
                $this->session->set_flashdata('error','Unable to Add New State Something Went Wrong Please Try Again!');
                $redirect_add = base_url('admin/state_add');
                redirect($redirect_add,'refresh');
            }
        }
    }

    public function editState($state_id)
    {
        $state_data = $this->Admin_model->getStateData($state_id);
        $this->load->view('includes/header');
        $this->load->view('admin/addstate',['state_data'=>$state_data]);
        $this->load->view('alert');
    }


    public function updateState($state_id)
    {   
        if($state_id)
        {
           $this->form_validation->set_rules('state', 'State', 'required|callback_uniquestate['.$state_id.']',array('uniquestate' => 'This %s Alrady Exist!'));

            if ($this->form_validation->run() == FALSE)
            {
                $this->editState($state_id);
            }
            else
            { 
                $postdata = $this->input->post();
                $insertFlag = $this->Admin_model->saveState($postdata,$this->createdBy,$state_id);
                if($insertFlag)
                {
                    $this->session->set_flashdata('success','State Name Updated!');
                    $redirect_dashboard = base_url('admin/state_management');
                    redirect($redirect_dashboard,'refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Unable to Update State Name Something Went Wrong Please Try Again!');
                    $redirect_add = base_url('admin/state_edit/'.$state_id);
                    redirect($redirect_add,'refresh');
                }
            }
        }
        else
        {
            $this->session->set_flashdata('error','State Id Blank!');
            $redirect_dashboard = base_url('admin/state_management');
            redirect($redirect_dashboard,'refresh');
        }
    }

    public function uniquestate($state_name,$state_id)
    {
        if(!empty($state_name) && $state_id)
        {
            $validation_flag = $this->Admin_model->isUniqueState($state_name,$state_id);
            return $validation_flag;
        }
        else
        {
            return true;
        }
    }

    public function deleteState($state_id)
    {   
        $result = array();
        if($state_id)
        {
            $delete_flag = $this->Admin_model->deleteState($state_id);
            if($delete_flag)
            {
                $result = array('status'=>true,'msg'=>'State Deleted Successfully');
            }
            else
            {
                $result = array('status'=>false,'msg'=>'Something Went Wrong Unable to Delete State!');
            }
        }
        else
        {
            $result = array('status'=>false,'msg'=>'Empty State Id');
        }
        echo json_encode($result);
    }
}
?>