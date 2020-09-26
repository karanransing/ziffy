<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City_model extends CI_Model 
{
	public function getCityData($city_id,$state_id)
    {   
        if($city_id)
        {
            $response = array();
            $this->db->select('mst_city.*');
            $this->db->from('mst_city');
            $this->db->where('mst_city.id',$city_id);
            $this->db->limit(1);
            $resultData = $this->db->get();
            $resultArray = $resultData->result_array();
            return (!empty($resultArray[0])) ? $resultArray[0]:$resultArray;
        }
        else
        {
            $this->db->select('mst_city.id,mst_city.city,mst_city.state_id,mst_state.state');
            $this->db->from('mst_city');
            $this->db->join('mst_state','mst_state.id=mst_city.state_id','inner join');
            if($state_id)
            {
            	$this->db->where('mst_city.state_id',$state_id);

            }
            $this->db->order_by('mst_city.id','desc');
            $resultData = $this->db->get();
            return $resultData;
        }
    }

    public function getStateMaster()
    {
    	$this->db->select('mst_state.id,state');
        $this->db->from('mst_state');
        $resultData = $this->db->get();
        $resultArray = $resultData->result_array();
        return $resultArray;
    }

    public function saveCity($postdata,$createdBy,$city_id)
    {   
        if($city_id)
        {
            $updateData = array(
            'city'=>$postdata['city'],
            'state_id'=>$postdata['state_id'],
            'updated_at'=>date('Y-m-d h:i:s'),
            'updated_by'=>$createdBy
            );
            $this->db->where('mst_city.id',$city_id);
            $flag = $this->db->update('mst_city',$updateData);
        }
        else
        {
            $inputData = array(
            'city'=>$postdata['city'],
            'state_id'=>$postdata['state_id'],
            'created_at'=>date('Y-m-d h:i:s'),
            'created_by'=>$createdBy,
            'updated_at'=>date('Y-m-d h:i:s'),
            'updated_by'=>$createdBy
            );
            $flag = $this->db->insert('mst_city',$inputData);
        }
        return $flag;
    }

    public function isuniqueCity($state_id,$city_name,$city_id)
    {	
    	$this->db->select('mst_city.id');
        $this->db->from('mst_city');
        if($city_id)
		{
        	$this->db->where('mst_city.id !=',$city_id);
        }
        $this->db->where('mst_city.city',$city_name);
        $this->db->where('mst_city.state_id',$state_id);
        $query = $this->db->get();
        $resultData = $query->result_array();
	    return (!empty($resultData[0]['id'])) ? false:true;
    }

    public function deleteCity($city_id)
    {
        $delete_flag = $this->db->delete('mst_city', array('id' => $city_id));
        return $delete_flag;
    }
}
?>