<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome_model extends CI_Model {

  /* function to validate login details and based on that return the result */
  public function validateLogin($arrayData)
  {
    if(!empty($arrayData) && isset($arrayData['mobile']) && isset($arrayData['password']))
    {
      $mobile = $arrayData['mobile'];
      $password = $arrayData['password'];
      $result = $this->db->query("SELECT `id`,`name` FROM mst_users WHERE contact_no='".$mobile."' AND password='".MD5($password)."'");
      $resultArray = $result->result();
      if(!empty($resultArray))
      {
        return $resultArray;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }


	public function keepLoginLog($arrData)
	{  
        if(!empty($arrData))
        {
            $data = array(
             'emp_id'=>(!empty($arrData['employee_id'])) ? $arrData['employee_id'] : 0,
             'mobile_no'=>$arrData['mobile'],
             'logged_at'=>date("Y-m-d H:i:s")
            );
            $flag = $this->db->insert('mst_login_log',$data);
            if($flag)
            {
              return true;
            }
            else
            {
              return flase;
            }
        }
        else
        {
          return flase;
        }
  }

  public function getUserDetails($mobile,$roleid)
  { 
    $result = array();
    if(!empty($mobile))
    {
        $resultData = $this->db->query("SELECT `id`,`user_name`,`mobile_no`, `employee_id`,`role_id`,email FROM mst_users WHERE mobile_no='".$mobile."'");
        $resultArray = $resultData->result_array();
        if(!empty($resultArray) && !empty($resultArray[0]['role_id']))
        {
          if($resultArray[0]['role_id']==1)
          {
            $result['url']=base_url('backend/dashboard');
            $result['data']=$resultArray[0];
            $result['exist_flag']=1;
          }
          else if($resultArray[0]['role_id']==2)
          {
            $result['url']=base_url('employee/addlead');
            $result['data']=$resultArray[0];
            $result['exist_flag']=1;
          }
          else if($resultArray[0]['role_id']==3)
          {
            $result['url']=base_url('customer/addlead');
            $result['data']=$resultArray[0];
            $result['exist_flag']=1;
          }
          else
          {
            $result['url']='';
            $result['data']='';
            $result['exist_flag']=0;
          }
        }
        else
        {
            $result['url']=base_url('updateuser?role_id='.$roleid.'&mobile='.$mobile);
            $result['data']='';
            $result['exist_flag']=0;
        }
    }
    else
    {
      $result['url']='';
      $result['data']='';
      $result['exist_flag']=0;
    }
    
    return $result;
  }
}