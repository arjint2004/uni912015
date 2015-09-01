<script>
$(document).ready(function(){


		$("#subjectnilaiaddref").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  subject:{required:true,notEqual:''},
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
	
//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#subjectnilaiaddref").submit(function(e){
			$frm = $(this);
			$subject = $frm.find('*[name=subject]').val();
			$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			if($frm.find('*[name=subject]').is('.valid') && $frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&'+$('form#nilai').serialize()+'&id_referensi='+$('select#subjecton option').filter(":selected").attr('id_ref'),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanabsensi").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						$('#subjectnilai').load('<? echo base_url();?>akademik/nilai/listSubject/<?=base64_encode($jenis);?>');
						//$('#simpanabsensi').before('<div id="berhasil" style="float:left;">Simpan Berhasil</div>');
						//$('#berhasil').delay(10).fadeIn(500).delay(1000).fadeOut(500);
						//$('#berhasil').remove();
						//$("#simpanabsensi").show();	
					}
				});
				return false;
			}
			
			return false;
		});//Submit End
		$("select#pengumpulan_add,select#remidial_add").change(function(e){
			if($('select#pengumpulan_add').val()=='Offline'){
				$("table.adddata tr td#subject").html('<input type="text"  name="subject" size="50" value="" />');
			}else if($('select#pengumpulan_add').val()=='Online'){
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
					url: '<?=base_url()?>akademik/nilai/getSubjectDrop/<?=base64_encode(str_replace("nilai ","",$jenis))?>/'+$('select#remidial_add').val(),
					beforeSend: function() {
						$('select#pengumpulan_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$('#wait').remove();
						$("table.adddata tr td#subject").html(msg);	
					}
				});
			}
		});
		$("select#kelas_add").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_add").html(msg);	
				}
			});
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#subjectnilaiaddref").serialize()+'&id_kelas='+$(this).val(),
				url: '<?=base_url()?>akademik/nilai/add',
				beforeSend: function() {
					$(this).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#nilai").html(msg);	
				}
			});
			return false;
		});//Submit End
});
</script>
<div class="addaccount">
<form action="<? echo base_url();?>akademik/nilai/addnilai" id="subjectnilaiaddref" name="subjectnilaiaddref" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
		
		<h3>Tambah <?=$jenis?></h3>
		<div class="hr"></div>
		<table class="adddata">
			<tr>
				<th colspan="3" style="text-align:right;"><a title="" class="button small light-grey absenbutton" id="simpanabsensi" onclick="$('#subjectnilaiaddref').submit();"> Simpan </a></th>
			</tr>
			<tr>
				<td class="title">Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_add" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
					
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_add" name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
						<? }} ?>
						</select>
				</td>
			</tr>
			<tr>
				<td width="30%" class='title'>Jenis <?=str_replace("nilai","",$jenis)?></td>
				<td width="1">:</td>
				<td>
					<select class="selectfilter" id="pengumpulan_add" name="pengumpulan">
						<option <? if(@$_POST['pengumpulan']=='Offline'){echo 'selected';}?> value="Offline">Offline</option>
						<option <? if(@$_POST['pengumpulan']=='Online'){echo 'selected';}?> value="Online">Online</option>
					</select>					
				</td>
			</tr>
			<tr>
				<td class="title">Remidial</td>
				<td>:</td>
				<td>
					<?//if($jenis=='nilai uts' || $jenis=='nilai uas'){?>
					<!--<select class="selectfilter" id="remidial_add" name="remidial">
					<?//if(!$inserted){?>
						<option <? if(@$_POST['remidial']=='non_remidial'){echo 'selected';}?> value="non_remidial">Non Remidial</option>
					<? //} ?>
					<?//if($inserted){?>
						<option <? if(@$_POST['remidial']=='remidial'){echo 'selected';}?> value="remidial">Remidial</option>
					<? //} ?>	
					</select>-->
					<? //}else{ ?>	
					<select class="selectfilter" id="remidial_add" name="remidial">
						<option <? if(@$_POST['remidial']=='non_remidial'){echo 'selected';}?> value="non_remidial">Non Remidial</option>
						<option <? if(@$_POST['remidial']=='remidial'){echo 'selected';}?> value="remidial">Remidial</option>
					</select>					
					<? //} ?>
				</td>
			</tr>
			<tr>
				<td width="30%" class='title'>Subject</td>
				<td width="1">:</td>
				<td id="subject">
				<? 
				$value='';
				$readonly='';
				if($jenis=='nilai uts'){ $value='Nilai Ujian Tengah Semester';$readonly='readonly';}?>
				<? if($jenis=='nilai uas'){ $value='Nilai Ujian Akhir Semester';$readonly='readonly';}?>
				<input type="text"  name="subject" size="50" value="<?=$value?>" <?=$readonly?> />
				</td>
			</tr>
			
		</table>

	<input type="hidden" name="jenis" value="<?=$jenis?>"/> 
	<input type="hidden" name="ajax" value="1"/> 

	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>
<div id="nilai"></div>