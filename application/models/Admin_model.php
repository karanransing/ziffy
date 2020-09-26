<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    

    public function getDashboardCount()
    {
        $countData = array();
        $countData['city'] =  $this->db->from("mst_city")->count_all_results();
        $countData['state'] =  $this->db->from("mst_state")->count_all_results();
        return $countData;
    }
    /*
        functioin to get the questions list and related answers
        param int question id
        return array question list
    */
    public function getStateData($state_id)
    {   
        if($state_id)
        {
            $response = array();
            $this->db->select('mst_state.*');
            $this->db->from('mst_state');
            $this->db->where('mst_state.id',$state_id);
            $resultData = $this->db->get();
            $this->db->limit(1);
            $resultArray = $resultData->result_array();
            return (!empty($resultArray[0])) ? $resultArray[0]:$resultArray;
        }
        else
        {
            $this->db->select('mst_state.id,mst_state.state');
            $this->db->from('mst_state');
            $this->db->order_by('mst_state.id','desc');
            $resultData = $this->db->get();
            return $resultData;
        }
    }

    public function saveState($postdata,$createdBy,$state_id)
    {   
        if($state_id)
        {
            $updateData = array(
            'state'=>$postdata['state'],
            'updated_at'=>date('Y-m-d h:i:s'),
            'updated_by'=>$createdBy
            );
            $this->db->where('mst_state.id',$state_id);
            $flag = $this->db->update('mst_state',$updateData);
        }
        else
        {
            $inputData = array(
            'state'=>$postdata['state'],
            'created_at'=>date('Y-m-d h:i:s'),
            'created_by'=>$createdBy,
            'updated_at'=>date('Y-m-d h:i:s'),
            'updated_by'=>$createdBy
            );
            $flag = $this->db->insert('mst_state',$inputData);
        }
        return $flag;
    }

    public function isUniqueState($state_name,$state_id)
    {
        $this->db->select('mst_state.id');
        $this->db->from('mst_state');
        $this->db->where('mst_state.id !=',$state_id);
        $this->db->where('mst_state.state',$state_name);
        $query = $this->db->get();
        $resultData = $query->result_array();  
        return (!empty($resultData[0]['id'])) ? false:true;
    }

    public function deleteState($state_id)
    {
        $delete_flag = $this->db->delete('mst_state', array('id' => $state_id));
        return $delete_flag;
    }
}
?>