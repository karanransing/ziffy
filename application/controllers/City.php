<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class City extends CI_Controller 
{
	public $createdBy;
	public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in') && !$this->session->userdata('user_id'))
        {    
            redirect('/');
        }
        $this->load->model('City_model');
        $this->createdBy = $this->session->userdata('user_id');
    }
    
    /* function to view state master */
    public function cityManagement()
    {   $state_master = $this->City_model->getStateMaster();
        $this->load->view('includes/header');
        $this->load->view('admin/citymanagement',['state_master'=>$state_master]);
        $this->load->view('alert'); 
    }

    /* function to get the state data */
    public function getCityData()
    {   
        $postdata = $this->input->post();
        $state_id = (!empty($postdata['state_id'])) ? $postdata['state_id'] : 0;
        $citydata=$this->City_model->getCityData(0,$state_id);
        $srno=$_POST['start']+1;
        $data=array();
        foreach($citydata->result() as $row) 
        {  
            $editaction = base_url('admin/city_edit/'.$row->id);
            $actionHtml="<a href=".$editaction." class='btn btn-info'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a onclick='deleteCity(".$row->id.")' class='deleteCity btn btn-sm btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></a>";

           $data[] =[
                $srno,
                $row->state,
                $row->city,
                $actionHtml
            ]; // End Data Array
        
            $srno++;
        }
        $dataCount=count($citydata->result());
        $output =[
            "draw"              =>  intval($_POST['draw']),  
            "recordsTotal"      =>  $dataCount,  
            "recordsFiltered"   =>  $dataCount,  
            "data"              =>  $data  
        ]; // End Output Array
        echo json_encode($output);
    }

    /* function to the add State */
    public function addCity()
    {   
        $city_data = array();
        $state_master = $this->City_model->getStateMaster();
        $this->load->view('includes/header');
        $this->load->view('admin/addcity',['city_data'=>$city_data,'state_master'=>$state_master]);
        $this->load->view('alert');
    }

    public function saveCity()
    {   
       $this->form_validation->set_rules('state_id', 'State', 'required',array('required' => 'Please Select State')); 
       $this->form_validation->set_rules('city', 'City', 'required|callback_unique_city[0]',array('unique_city' => 'This %s Already Exist!'));

        if ($this->form_validation->run() == FALSE)
        {
            $this->addCity();
        }
        else
        { 
            $postdata = $this->input->post();
            $insertFlag = $this->City_model->saveCity($postdata,$this->createdBy,0);
            if($insertFlag)
            {
                $this->session->set_flashdata('success','New City Added!');
                $redirect_dashboard = base_url('admin/city_management');
                redirect($redirect_dashboard,'refresh');
            }
            else
            {
                $this->session->set_flashdata('error','Unable to Add New City Something Went Wrong Please Try Again!');
                $redirect_add = base_url('admin/city_add');
                redirect($redirect_add,'refresh');
            }
        }
    }

    public function unique_city($city_name,$city_id)
    {   
        $data = $this->input->post();
        if(!empty($data['state_id']) && !empty($city_name))
        {
            $is_unique = $this->City_model->isuniqueCity($data['state_id'],$city_name,$city_id);
            return $is_unique;
        }
        else
        {
            return true;
        }
    }

    public function editCity($city_id)
    {
        $city_data = $this->City_model->getCityData($city_id,0);
        $state_master = $this->City_model->getStateMaster();
        $this->load->view('includes/header');
        $this->load->view('admin/addcity',['city_data'=>$city_data,'state_master'=>$state_master]);
        $this->load->view('alert');
    }


    public function updateCity($city_id)
    {   
        if($city_id)
        {   
            $this->form_validation->set_rules('state_id', 'State', 'required',array('required' => 'Please Select State')); 
            $this->form_validation->set_rules('city', 'City', 'required|callback_unique_city['.$city_id.']',array('uniquestate' => 'This %s Already Exist!'));

            if ($this->form_validation->run() == FALSE)
            {
                $this->editCity($city_id);
            }
            else
            { 
                $postdata = $this->input->post();
                $insertFlag = $this->City_model->saveCity($postdata,$this->createdBy,$city_id);
                if($insertFlag)
                {
                    $this->session->set_flashdata('success','City Details Updated!');
                    $redirect_dashboard = base_url('admin/city_management');
                    redirect($redirect_dashboard,'refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Unable to Update State Name Something Went Wrong Please Try Again!');
                    $redirect_add = base_url('admin/city_edit/'.$city_id);
                    redirect($redirect_add,'refresh');
                }
            }
        }
        else
        {
            $this->session->set_flashdata('error','City Id Blank!');
            $redirect_dashboard = base_url('admin/city_management');
            redirect($redirect_dashboard,'refresh');
        }
    }

    public function deleteCity($city_id)
    {   
        $result = array();
        if($city_id)
        {
            $delete_flag = $this->City_model->deleteCity($city_id);
            if($delete_flag)
            {
                $result = array('status'=>true,'msg'=>'City Deleted Successfully');
            }
            else
            {
                $result = array('status'=>false,'msg'=>'Something Went Wrong Unable to Delete City!');
            }
        }
        else
        {
            $result = array('status'=>false,'msg'=>'Empty City Id');
        }
        echo json_encode($result);
    }
}
?>