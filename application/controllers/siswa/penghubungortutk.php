<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class penghubungortutk extends CI_Controller
    {
        var $upload_dir='upload/akademik/jurnalwali/';
        var $upload_dirpeng='upload/akademik/penghubungortutk/';
		public $denied_mime_types = array('application/x-php','application/x-asp','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        
		public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }

		public function getOptionSiswaByIdKelas($id_kelas){
			$this->load->library('ak_siswa');
			$optionsiswa=$this->ak_siswa->createOptionSiswaByIdKelasId_sis($id_kelas);
			echo $optionsiswa;
        }
        public function penghubungortulist($start=0,$page=0,$id_pengguna=0,$kepsek=0)
        {
			if($start==1){$start=0;}
			if(isset($_POST['kepsek'])){$kepsek=$_POST['kepsek'];}
			if(isset($_POST['id_pengguna'])){$id_pengguna=$_POST['id_pengguna'];}
			$data['kepsek']   = $kepsek;
			$data['id_pengguna']   = $id_pengguna;
			
			//data
			$this->load->model('ad_jurnal');
			$this->load->library('pagination');
			
			$config['base_url']   = site_url('akademik/penghubungortutk/penghubungortulist');
			$config['per_page']   = 15;

			$config['cur_page']   = $start;
			$config['total_rows'] = $this->ad_jurnal->getCountPenghubung($_POST['id_kelas'],$id_pengguna);
			$data['start'] = $start;
			
			$data['datahubung']=array();
			if(isset($_POST['id_kelas'])){
				$data['datahubung']=$this->ad_jurnal->getDataPenghubung($this->session->userdata['user_authentication']['id_sekolah'],$_POST['id_kelas'],''.$start.','.$config['per_page'].'');
				if(!empty($data['datahubung'])){
					foreach($data['datahubung'] as $ky=>$datapeng){
						$data['datahubung'][$ky]['file']=$this->ad_jurnal->getFilePengByIdPeng($datapeng['id']);
						$data['datahubung'][$ky]['siswa']=$this->ad_jurnal->getPengDikirim($datapeng['id']);
					}
				}
			}elseif($kepsek=='kepsek'){
				$data['datahubung']=$this->ad_jurnal->getDataPenghubung($this->session->userdata['user_authentication']['id_sekolah'],$_POST['id_kelas'],''.$start.','.$config['per_page'].'',$id_pengguna);
				if(!empty($data['datahubung'])){
					foreach($data['datahubung'] as $ky=>$datapeng){
						$data['datahubung'][$ky]['file']=$this->ad_jurnal->getFilePengByIdPeng($datapeng['id']);
						$data['datahubung'][$ky]['siswa']=$this->ad_jurnal->getPengDikirim($datapeng['id']);
					}
				}				
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			//pr($config);
			$data['main']= 'siswa/penghubungortutk/penghubungortulist';
            $this->load->view('layout/ad_blank',$data);
		}
		


        public function penghubungortu()
        {
			$type="perkembangan_tk";
			if(isset($_POST['id_kelas'])){
					$this->load->model('ad_kelas');
					$datakelas=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$_POST['id_kelas']);
					//pr($datakelas);
					//if($_POST['type']=="tanggalpengtk"){
						if($datakelas[0]['kelas']==1 || $datakelas[0]['kelas']==2){
							$type="perkembangan_tpa";
						}elseif($datakelas[0]['kelas']==3 || $datakelas[0]['kelas']==4){
							$type="perkembangan_tk";
						}elseif($datakelas[0]['kelas']==5 || $datakelas[0]['kelas']==6){
							$type="perkembangan_tk";
						}
						
					//}
			}
			//content perkembngan
			$this->load->model('ad_penghubungortutk');
			$content=$this->ad_penghubungortutk->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah'],$type,$this->session->userdata['ak_setting']['semester']);
			$contentmenu=$this->ad_penghubungortutk->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah'],"menu_makan");
			$content[0]['contarr']=unserialize($content[0]['content']);
			$contentmenu[0]['contmenuarr']=unserialize($contentmenu[0]['content']);
			$data['content']=$content;	
			$data['contentmenu']=$contentmenu;	
			
			if(isset($_POST['save'])){

				$datasiswa['id']=$this->session->userdata['user_authentication']['id_siswa'];
				$datasiswa['id_siswa_det_jenjang']=$this->session->userdata['user_authentication']['id_siswa_det_jenjang'];
				$contentsiswa=$this->ad_penghubungortutk->getdataPengByIdSiswaTglType($datasiswa['id'],$_POST['tanggalpengtk'],$type);
				$contentmenusiswa=$this->ad_penghubungortutk->getdataPengByIdSiswaTglType(0,$_POST['tanggalpengtk'],"menu_makan");
				//pr($contentmenusiswa);
				if(isset($_POST['program'])){
					if(empty($contentsiswa)){ 	 	 	 	 	
						$datain=array( 
									   'id_ta'=>$this->session->userdata['ak_setting']['ta'],
									   'semester'=>$this->session->userdata['ak_setting']['semester'],
									   'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									   'id_siswa'=>$datasiswa['id'],
									   'id_siswa_det_jenjang'=>$datasiswa['id_siswa_det_jenjang'],
									   'contentsiswa'=>serialize($_POST['program']),
									   'tanggal'=>$_POST['tanggalpengtk']
									);
						$this->db->insert('ak_penghubung_tk',$datain);
					}else{
						$datain=array( 
									   'id_ta'=>$this->session->userdata['ak_setting']['ta'],
									   'semester'=>$this->session->userdata['ak_setting']['semester'],
									   'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									   'id_siswa'=>$datasiswa['id'],
									   'id_siswa_det_jenjang'=>$datasiswa['id_siswa_det_jenjang'],
									   'contentsiswa'=>serialize($_POST['program']),
									   'tanggal'=>$_POST['tanggalpengtk']
									);
						$this->db->where('id',$contentsiswa[0]['id']);
						$this->db->update('ak_penghubung_tk',$datain);
					}
				}
				if(isset($_POST['programmenu'])){
					if(empty($contentmenusiswa)){ 	 	 	 	 	
						$datain=array( 
									   'id_ta'=>$this->session->userdata['ak_setting']['ta'],
									   'semester'=>$this->session->userdata['ak_setting']['semester'],
									   'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									   'id_kelas'=>$_POST['id_kelas'],
									   //'id_siswa'=>$datasiswa['id'],
									   //'id_siswa_det_jenjang'=>$datasiswa['id_siswa_det_jenjang'],
									   'contentsiswa'=>serialize($_POST['programmenu']),
									   'tanggal'=>$_POST['tanggalpengtkmenu'],
									   'type'=>"menu_makan"
									);
						$this->db->insert('ak_penghubung_tk',$datain);
					}else{
						$datain=array( 
									   'id_ta'=>$this->session->userdata['ak_setting']['ta'],
									   'semester'=>$this->session->userdata['ak_setting']['semester'],
									   'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									   'id_kelas'=>$_POST['id_kelas'],
									   //'id_siswa'=>$datasiswa['id'],
									   //'id_siswa_det_jenjang'=>$datasiswa['id_siswa_det_jenjang'],
									   'contentsiswa'=>serialize($_POST['programmenu']),
									   'tanggal'=>$_POST['tanggalpengtkmenu'],
									   'type'=>"menu_makan"
									);
						$this->db->where('id',$contentmenusiswa[0]['id']);
						$this->db->update('ak_penghubung_tk',$datain);
					}
				}
				//echo $this->db->last_query()."<br />";
				$contentsiswa[0]['contarr']=unserialize($contentsiswa[0]['contentsiswa']);
				$data['contentsiswa']=$contentsiswa;
				$contentmenusiswa[0]['conmenutarr']=unserialize($contentmenusiswa[0]['contentsiswa']);
				$data['contentmenusiswa']=$contentmenusiswa;
			}
			
			//content perkembngan end
			
			$this->load->model('ad_kelas');
			
			$data1=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data2=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['kelaslaporan']=array_merge($data1,$data2);
			

			if(isset($_POST['kepada'])){
					$this->load->library('smsprivate');
					if(in_array('siswa',$_POST['kepada'])){
						$siswaortu="siswa";
					}
					if(in_array('ortu',$_POST['kepada']) || in_array('siswaortu',$_POST['kepada'])){
						$siswaortu .="ortu";
					}else{
						
						if(in_array('ortu',$_POST['kepada'])){
							$siswaortu ="ortu";
						}
					}
				$insert=array(
						'id_ta'=>$this->session->userdata['ak_setting']['ta'],
						'semester'=>$this->session->userdata['ak_setting']['semester'],
						'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
						'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
						'subject'=>$_POST['subject'],
						'keterangan'=>$_POST['keterangan'],
						'kepada'=>$siswaortu,
						'tanggal'=>date('Y-m-d H:i:s'),
						'id_kelas'=>$_POST['id_kelas']
				);
				//pr($siswaortu);
				$this->db->insert('ak_penghubung',$insert);
				$id_peng=mysql_insert_id();
				$this->smsprivate->send_by_kelas($_POST['id_kelas'],$_POST['pesan'],'penghubungortu',$id_peng);
				//unset($_POST['id_siswa'][0]);
				$this->load->library('ak_notifikasi');
				$this->load->model('ad_notifikasi');
				
				foreach($_POST['id_siswa'] as $ky=>$id_siswax){
					$id_siswa=json_decode(base64_decode($id_siswax),true);
					if($id_siswa!=''){
						$this->db->insert('ak_penghubung_kirim',array('id_penghubung'=>$id_peng,'id_siswa'=>$id_siswa['id'],'siswaortu'=>$siswaortu));
						if($siswaortu=='siswa'){
							$this->ak_notifikasi->set_notifikasi($id_siswa['id'],'penghubung',12,$this->session->userdata['user_authentication']['nama'],$_POST['subject'],$id_information=0,$jenis_information='');
						}elseif($siswaortu=='ortu'){
							$this->ak_notifikasi->set_notifikasi($id_siswa['id_ortu'][$id_siswa['id']],'penghubung',14,$this->session->userdata['user_authentication']['nama'],$_POST['subject'],$id_information=0,$jenis_information='');
						}elseif($siswaortu=='siswaortu'){
							$this->ak_notifikasi->set_notifikasi($id_siswa['id'],'penghubung',12,$this->session->userdata['user_authentication']['nama'],$_POST['subject'],$id_information=0,$jenis_information='');
							$this->ak_notifikasi->set_notifikasi($id_siswa['id_ortu'][$id_siswa['id']],'penghubung',14,$this->session->userdata['user_authentication']['nama'],$_POST['subject'],$id_information=0,$jenis_information='');
						}
						
					}
					//$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang($id_siswa['id_siswa_det_jenjang'],0,$data=array('group'=>'penghubung'));
				}
				echo $id_peng;
				die();
			}

			if(isset($_POST['onlyview']) && $_POST['onlyview']=='true'){
				if($_POST['type']=="tanggalpengtkmenu"){
					$data['main']= 'siswa/penghubungortutk/menumakan';
				}elseif($_POST['type']=="tanggalpengtk"){
					$data['main']= 'siswa/penghubungortutk/perkembangan';
				}
				
			}else{
				$data['main']= 'siswa/penghubungortutk/penghubungortu';			
			}

            $this->load->view('layout/ad_blank',$data);
		}
		
    }
?>