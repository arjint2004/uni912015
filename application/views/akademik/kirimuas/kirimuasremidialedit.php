<script>
	$(document).ready(function(){
		$("#kirimuasremidialedit").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				 // id_kelas:{required:true,notEqual:''},
				  //siswa:{required:true,notEqual:'Pilih Siswa'},
				  //id_pelajaran:{required:true,notEqual:''},
				  //bab:{required:true,notEqual:''},
				  id_parent:{required:true,notEqual:''},
				  //file:{required:true,notEqual:''},
				  tanggal_kumpul:{required:true,notEqual:''},
				  keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
	
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		
		// selected area	
		$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>akademik/kirimuas/getOptionSiswaByIdKelas/'+$(this).val(),
				beforeSend: function() {
					$('select#siswa_adduas').after("<img id='waituas15' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas15').remove();
					$("#siswa_adduas").html(msg);	
				}
		});
		
		$('#pelajaran_adduas').load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('#kelas_adduas').val()+'/<?=$uas['uas'][0]['id_pelajaran']?>');
		$('#siswa_adduas').load('<?=base_url()?>akademik/kirimuas/getOptionSiswaRemidiByIdKelas/'+$('#kelas_adduas').val()+'/<?=$uas['uas'][0]['id']?>');
		$('#judul_adduas').load('<?=base_url()?>akademik/kirimuas/createOptionUasRemidiEditByKelasPelajaranIdPegawai/<?=$uas['uas'][0]['id_pelajaran']?>/'+$('#kelas_adduas').val()+'/<?=$uas['uas'][0]['id_parent']?>');
		
		$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>akademik/kirimuas/getOptionFileUasByIdUas/<?=$uas['uas'][0]['id_parent']?>',
				beforeSend: function() {
					$('select#judul_adduas').after("<img id='waituas16' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas16').remove();
					$("#filecekuas").html(msg);	
				}
		});
		
		//end selected area
		
		
		$("table.adddata tr th a.canceluasremidi").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelasuas').val()+'&pelajaran='+$('select#pelajaranuas').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimuas/daftaruaslist')?>',
					beforeSend: function() {
						$("table.adddata tr th a.canceluasremidi").after("<img id='waituas17' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waituas17").remove();
						//$('select#kelasuas').val($('select#kelas_adduas').val());
						//$('select#pelajaranuas').html($('select#pelajaran_adduas').html());
						//$('select#pelajaranuas').val($('select#pelajaran_adduas').val());	
						$('#subjectlistuas').html(msg);
						$('#subjectujian').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		$("#kirimuasremidialedit").submit(function(e){
			$frm = $(this);
			//$id_kelas = $frm.find('*[name=id_kelas]').val();
			//$siswa = $frm.find('*[name=siswa]').val();
			//$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			//$bab = $frm.find('*[name=bab]').val();
			$id_parent = $frm.find('*[name=id_parent]').val();
			//$file = $frm.find('*[name=file]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			//alert($('select#siswa_adduas').val());
			if($('select#siswa_adduas').val()=='' || $('select#siswa_adduas').val()==null){$('select#siswa_adduas').css('border','1px solid red');return false;}else{$('select#siswa_adduas').css('border','');}
			if(/*$frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=siswa]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid')*/ /*&& $frm.find('*[name=bab]').is('.valid') && */ $frm.find('*[name=id_parent]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid') */&& $frm.find('*[name=keterangan]').is('.valid')) {
				
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&judul='+$("select#judul_adduas").attr('title'),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#kirimuasremidialedit").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Inserting Data');
					},
					success: function(msg) {
						$(".error-box").delay(1000).fadeOut("slow",function(){
							$(this).remove();
						});
						var upload=ajaxuploadnew("<? echo base_url();?>akademik/kirimuas/uploadfileuas/"+msg,"response","image-list","fileuasremidial");
						
						
						$.ajax({
							url: "<? echo base_url();?>akademik/kirimuas/uploadfileuas/"+msg,
							type: "POST",
							data: upload,
							processData: false,
							contentType: false,
							beforeSend: function() {
								$("#kirimuasremidialedit").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
								$(".error-box").delay(1000).html('Proses Upload File');
							},
							error	: function(){
								alert('UAS anda sudah tersimpan. Tetapi lampiran file anda gagal di Upload. Klik OK untuk melengkapi lampiran');
								//$('#subjectlistuas').load('<?=base_url('akademik/kirimuas/kirimuasutamaedit')?>/'+msg);	
								$('#fileuasremidial').val("");
								return false;
							},
							success: function (res) {
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});	
								if(res=='null'){
									$.ajax({
										type: "POST",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelas_adduas').val()+'&pelajaran='+$('select#pelajaran_adduas').val()+'&ajax=1',
										url: '<?=base_url('akademik/kirimuas/daftaruaslist')?>',
										beforeSend: function() {
											$("#kirimuasremidial").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
											$(".error-box").delay(1000).html('Load data');
											$(".error-box").delay(1000).fadeOut("slow",function(){
												$(this).remove();
											});
										},
										success: function(msg) {
											$(".waituas19").remove();
											$('select#kelasuas').val($('select#kelas_adduas').val());
											$('select#pelajaranuas').html($('select#pelajaran_adduas').html());
											$('select#pelajaranuas').val($('select#pelajaran_adduas').val());
											$('#subjectlistuas').html(msg);
											$('#subjectujian').scrollintoview({ speed:'1100'});
										}
									});
								}else{
									alert(res+'');
									//$('#subjectlistuas').load('<?=base_url('akademik/kirimuas/kirimuasutamaedit')?>/'+msg);
									$('#fileuasremidial').val("");
									return false;
								}
							}
						});
						
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		$("ul.file div.actdell").click(function(){
			var objdell=$(this);
			if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
				$('ul.file').load();
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
					url: base_url+'akademik/kirimuas/deletefile/'+$(this).attr('id'),
					beforeSend: function() {
						$(objdell).after("<img id='waituas31' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waituas31").remove();	
						$(objdell).parent().remove();
					}
				});
				return false;
			}
		});	
		$("select#judul_adduas").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>akademik/kirimuas/getOptionFileUasByIdUas/'+$(this).val(),
				beforeSend: function() {
					$('select#judul_adduas').after("<img id='waituas20' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas20').remove();
					$(obj).attr('title',$(obj).find(":selected").attr('judul'));
					$('#babremidiuas').val($(obj).find(":selected").attr('bab'));
					$("#filecekuas").html(msg);	
				}
			});
		});
		$("select#pelajaran_adduas").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>akademik/kirimuas/createOptionUasByKelasPelajaranIdPegawai/'+$(this).val()+'/'+$('select#kelas_adduas').val(),
				beforeSend: function() {
					$('select#judul_adduas').after("<img id='waituas21' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas21').remove();
					$("#judul_adduas").html(msg);	
				}
			});
		});
		$("select#kelas_adduas").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>akademik/kirimuas/getOptionSiswaRemidiByIdKelas/'+$(this).val()+'/'+<?=$uas['uas'][0]['id']?>,
				beforeSend: function() {
					$('select#siswa_adduas').after("<img id='waituas22' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas22').remove();
					$("#siswa_adduas").html(msg);	
				}
			});
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#pelajaran_adduas').after("<img id='waituas23' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas23').remove();
					$("#pelajaran_adduas").html(msg);	
				}
			});
		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimuasremidialedit').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimuasremidialedit" enctype="multipart/form-data" id="kirimuasremidialedit" action="<? echo base_url();?>akademik/kirimuas/kirimuasremidialedit/<?=@$uas['uas'][0]['id']?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Edit UAS Remidial</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimuasremidialedit').submit();" id="simpanuas" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton canceluasremidi" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" disabled id="kelas_adduas" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$uas['uas'][0]['id_kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
					<input type="hidden" name="id_kelas" id="kelas_adduas" value="<?=@$uas['uas'][0]['id_kelas']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Untuk Siswa</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="siswa_adduas" multiple name="siswa[]">
						<option value="">Pilih Siswa</option>
					</select>
					<div  style="font-size:11px;">jika pilihan lebih dari satu siswa, maka gunakan ctrl+klik-kanan</div>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_adduas" disabled name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
						<? }} ?>
					</select>
					<input type="hidden" name="id_pelajaran" id="pelajaran_adduas" value="<?=@$uas['uas'][0]['id_pelajaran']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Judul UAS</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="judul_adduas" title="<?=@$uas['uas'][0]['judul']?>" name="id_parent">
						<option value="">Pilih UAS</option>
					</select>				
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" readonly value="<?=@$uas['uas'][0]['bab']?>" id="babremidiuas" size="30" name="bab" >				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran Soal</td>
				<td width="1">:</td>
				<td>
					<ul class="file">
						<?foreach($uas['file'] as $file){?>
							<li><?=$file['file_name']?><div id="<?=$file['id']?>" class="actdell"></div></li>
						<? } ?>
						
					</ul>
					<input type="file" name="file" id="fileuasremidial" multiple />
					<div id="response" style="font-size:11px;">Masukkan file baru jika dibutuhkan. Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu <br /> Atau pakai file asli di bawah</div>
					<form id="remidialfile" method="post" action="">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<ul class="file" id="filecekuas">
						<li></li>
					</ul>
					</form>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="<?=@$uas['uas'][0]['tanggal_kumpul']?>" id="datekirimuasremidialedit">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"><?=@$uas['uas'][0]['keterangan']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" <? if(@$uas['uas'][0]['share']){echo 'checked';}?> name="share" value="1" />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimuasremidialedit').submit();" id="simpanuasbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton canceluasremidi" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 
	<input type="hidden" value="<?=@$uas['uas'][0]['id']?>" name="id"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>