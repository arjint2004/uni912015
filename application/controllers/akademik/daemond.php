<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Daemond extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
        }
        
        public function md($token=''){

			if($this->auth($token)==true){
				$sms=$this->db->query("SELECT id,no_hp,pesan,SenderID FROM ak_sms  GROUP BY pesan,no_hp LIMIT 10")->result_array();
				$encrypted = base64_encode(serialize($sms));
				echo $encrypted;
				foreach($sms as $dtdell){
					$iddel[]=$dtdell['id'];
					$this->db->query("DELETE FROM `ak_sms` WHERE pesan='".mysql_real_escape_string($dtdell['pesan'])."' AND no_hp='".mysql_real_escape_string($dtdell['no_hp'])."'");
				}
				//$this->db->query("DELETE FROM ak_sms WHERE id IN(".implode(",",$iddel).")");
				//echo $this->db->last_query();
			}
		}
        public function mdupdate($token='',$id=''){
			if($this->auth($token)==true){
				//$this->db->query("DELETE FROM ak_sms WHERE id IN(".base64_decode($id).")");
				//echo $this->db->last_query();
			}			
		}
		function auth($token='')
		{
			//YToyOntzOjg6InVzZXJuYW1lIjtzOjI6InNiIjtzOjg6InBhc3N3b3JkIjtzOjE5OiJzdHVkZW50Ym9vayEqJCVeJiMkIjt9
			//$token= base64_encode(serialize(array('username'=>'sb','password'=>'studentbook!*$%^&#$')));
			$tokendec=unserialize(base64_decode($token));
			//pr($tokendec);
			if(!empty($tokendec) && $tokendec['username']=='sb' && $tokendec['password']=='studentbook!*$%^&#$'){
				return true;
			}else{
				return false;
			}
		}
	
    }
?>