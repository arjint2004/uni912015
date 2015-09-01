<?php
class smsprivate {
	protected $to;
	protected $text;
	public $key='81f6cf2706d2302a33782a6126b16469';
	public $phone='2rajasms';
	public $startid;
	public $countid;
	public $notran;

	public function setTo($to) {
		$this->to = $to;
	}

	public function setText($text) {
		$this->text = $text;
	}

	public function send() {
		if (!$this->to) {
			trigger_error('Error: Phone to required!');
			exit();		
		}

		if (!$this->text)  {
			trigger_error('Error: Text Message required!');
			exit();				
		}
		$nohp  = $this->to;
		$pesan = urlencode($this->text);
		$curlHandle = curl_init();
		$curlHandle = curl_init();
		$url="http://raja-sms.com/api/smssendprivate.php?nohp=".$nohp."&pesan=".$pesan."&phone=".$this->phone."&key=".$this->key;
		curl_setopt($curlHandle, CURLOPT_URL,$url);
		curl_setopt($curlHandle, CURLOPT_HEADER, 0);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlHandle, CURLOPT_TIMEOUT,120);
		$hasil = curl_exec($curlHandle);
		curl_close($curlHandle);		
		$err=explode('=',$hasil);
		if ($err[0]==0)  {
			$hasil=$hasil;
		} elseif ($err[0]==1 ){
			$hasil='Saldo Token SMS Habis';
		} elseif ($err[0]==2 ){
			$hasil='Masa Aktif Sudah Lewat';
		} elseif ($err[0]==3 ){
			$hasil='Domain Tidak Terdaftar/Salah';
		} elseif ($err[0]==4 ){
			$hasil='Key Tidak Terdaftar/Salah';
		} elseif ($err[0]==5 ){
			$hasil='Format Http Api SMS Salah';		
		} elseif ($err[0]==6 ){
			$hasil='Maksimum SMS PerHp PerHari';		
		} elseif ($err[0]==7 ){
			$hasil='Penulisan Nomor HP Salah';					
		} else {
			$hasil='Error';
		}	
		return $hasil;
	}
	public function saldo() {
		$curlHandle = curl_init();
		$url="http://raja-sms.com/api/smssaldoprivate.php?phone=".$this->phone."&key=".$this->key;
		curl_setopt($curlHandle, CURLOPT_URL,$url);
		curl_setopt($curlHandle, CURLOPT_HEADER, 0);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlHandle, CURLOPT_TIMEOUT,120);
		$hasil = curl_exec($curlHandle);
		curl_close($curlHandle);		
		$err=explode('=',$hasil);
		if ($err[0]==-1 ){
			$hasil='user name and password failed';
		} elseif ($err[0]==-3 ){
			$hasil='Processing Error';
		} else {
			$hasil=$hasil;
		}
		return $hasil;	
	}
	public function smsreport() {
		$curlHandle = curl_init();
		$url="http://raja-sms.com/api/smsreportprivate.php?notran=".$this->notran."&key=".$this->key;
		curl_setopt($curlHandle, CURLOPT_URL,$url);
		curl_setopt($curlHandle, CURLOPT_HEADER, 0);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlHandle, CURLOPT_TIMEOUT,120);
		$hasil = curl_exec($curlHandle);
		curl_close($curlHandle);
		return $hasil;	
	}	
	public function smsinbox() {
		$dataxml =simplexml_load_file(urlencode('http://raja-sms.com/api/smsgetinboxprivate.php?startid='.$this->startid.'&countid='.$this->countid.'&phone='.$this->phone.'&key='.$this->key));
		return $dataxml;
	}	
	public function send_by_kelas($id_kelas=0,$pesan='',$jenis='',$id_jenis=0) {
		$CI = & get_instance();
		//get mapel
		$pel=0;
		switch($jenis){
			case "materi":
				$table='ak_materi_pelajaran';
				$pel=1;
			break;
			case "pr":
				$table='ak_pr';
				$pel=1;
			break;
			case "tugas":
				$table='ak_tugas';
				$pel=1;
			break;
			case "harian":
				$table='ak_harian';
				$pel=1;
			break;
			case "uas":
				$table='ak_uas';
				$pel=1;
			break;
			case "uts":
				$table='ak_uts';
				$pel=1;
			break;
			
		}
		if($pel==1){
			$querypel=$CI->db->query('SELECT p.nama FROM '.$table.' t JOIN ak_pelajaran p ON t.id_pelajaran=p.id
										WHERE t.id=?
										',array($id_jenis));
			$pel=$querypel->result_array();
			$pesan=strtoupper($jenis).' '.$pel[0]['nama'].'# '.$pesan;
		}
		//sms ke guru
		$querysmsg=$CI->db->query('SELECT hp,id as id_user FROM ak_pegawai
									WHERE id=?
									',array($CI->session->userdata['user_authentication']['id_pengguna']));
		$fitursmsg=$querysmsg->result_array();
		
		//cek fitur sms
		$queryf=$CI->db->query('SELECT * FROM ak_fitur_sekolah
									WHERE id_sekolah=? AND fitur="sms_notifikasi" AND aktif=1
									',array($CI->session->userdata['user_authentication']['id_sekolah']));
		$fitur=$queryf->result_array();
		if(!empty($fitur)){
			if($jenis=='penghubungortu'){
				foreach($_POST['id_siswa'] as $ky=>$id_siswax){
					$id_siswa=json_decode(base64_decode($id_siswax),true);
					if($id_siswa['id']!=null || $id_siswa['id']!=""){
						$extract[]=$id_siswa['id'];
					}
					
				}
			$query=$CI->db->query('SELECT ap.hp,ap.id as id_user,ak.nama,ak.kelas,ak.id as id_kelas, s.nama as nama_siswa FROM
										ak_det_jenjang adj 
										JOIN ak_siswa s 
										JOIN ak_kelas ak 
										JOIN ak_pegawai ap
										ON adj.id_siswa=s.id 
										AND adj.id_kelas=ak.id
										AND ap.id_siswa=s.id
										WHERE ak.id=?
										AND adj.id_sekolah=?
										AND adj.id_ta=?
										AND ak.publish=1
										AND adj.id_siswa IN('.implode(",",$extract).')
										ORDER BY s.nama ASC
										',array($id_kelas,$CI->session->userdata['user_authentication']['id_sekolah'],$CI->session->userdata['ak_setting']['ta']));
										
			}else{
			$query=$CI->db->query('SELECT ap.hp,ap.id as id_user,ak.nama,ak.kelas,ak.id as id_kelas, s.nama as nama_siswa FROM
										ak_det_jenjang adj 
										JOIN ak_siswa s 
										JOIN ak_kelas ak 
										JOIN ak_pegawai ap
										ON adj.id_siswa=s.id 
										AND adj.id_kelas=ak.id
										AND ap.id_siswa=s.id
										WHERE ak.id=?
										AND adj.id_sekolah=?
										AND adj.id_ta=?
										AND ak.publish=1
										ORDER BY s.nama ASC
										',array($id_kelas,$CI->session->userdata['user_authentication']['id_sekolah'],$CI->session->userdata['ak_setting']['ta']));
										
			}
			//pr($query);die();
			$no_hp=$query->result_array();
			//echo $CI->db->last_query();
			//pr($no_hp);die();
			//$no_hp=array(0=>array('hp'=>'083867139945'));
			$maxindex=max(array_keys($no_hp))+1;
			$no_hp[$maxindex]=array('hp'=>$fitursmsg[0]['hp'],'id_user'=>$fitursmsg[0]['id_user']);
			//pr($no_hp);
			$CI->load->model('ad_setting');
			//pr($CI->session->userdata['user_authentication']);
			$setting=$CI->ad_setting->getSetting('sms_modem',$CI->session->userdata['user_authentication']['id_sekolah']);
			$modem=unserialize($setting[0]['value']);
			
			foreach($no_hp as $datanya){
				if($datanya['hp']!='' && strlen($datanya['hp'])>8){
					$insert_sms=array(
									'nama_siswa'=>''.$datanya['nama_siswa'].'',
									'id_user'=>''.$datanya['id_user'].'',
									'no_hp'=>''.$datanya['hp'].'',
									'pesan'=>'lihat di https://studentbook.co/u/'.base64_encode($datanya['id_user']).' '.$pesan.''."\n@".$CI->session->userdata['ak_setting']['nama_sekolah'],
									'jenis'=>''.$jenis.'',
									'id_jenis'=>''.$id_jenis.'',
									'id_kelas'=>''.$datanya['id_kelas'].'',
									'id_pegawai'=>''.$CI->session->userdata['user_authentication']['id_pengguna'].'',
									'kelas'=>''.$datanya['kelas'].$datanya['nama'].'',
									'waktu'=>date('Y-m-d H:i:s'),
									'SenderID'=>$modem[0]
					);
					
					$CI->db->insert('ak_sms',$insert_sms);
					//echo $CI->db->last_query(); 
					/*$this->setTo($datanya['hp']);
					$this->setText($pesan);
					$this->send();	*/
				}
			}
		}
	}
	
}
?>