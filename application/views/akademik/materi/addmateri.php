<script>
	$(document).ready(function(){
		
		$("#materi").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  bab:{required:true,notEqual:''},
				  pokok_bahasan:{required:true,notEqual:''},
				 /* file:{required:true,notEqual:''},
				  keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		$("table.adddata tr th a#cancelmateri").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelas').val()+'&pelajaran='+$('select#pelajaran').val()+'&ajax=1',
					url: '<?=base_url('akademik/materi/daftarmaterilist')?>',
					beforeSend: function() {
						$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#wait").remove();
						$('select#kelas').val($('select#kelas_add').val());
						$('select#pelajaran').html($('select#pelajaran_add').html());
						$('select#pelajaran').val($('select#pelajaran_add').val());	
						$('#subjectlistmateri').html(msg);
						$('#subject').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		filesize('fileaddmateri',15000000,50);
		$("#materi").submit(function(e){
			
			if($('select#kelas_add').val()==null && !$('input#simpanarsip').is(':checked')){
				$('select#kelas_add').css('border','1px solid red');
					if($('#date2materi').val()==''){
						$('#date2materi').css('border','1px solid red');
					}else{
						$('#date2materi').css('border','1px solid #D7D7D7');
					}
				return false;
			}else{
				$('select#kelas_add').css('border','1px solid #D7D7D7');
			}

			$frm = $(this);
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$bab = $frm.find('*[name=bab]').val();
			$pokok_bahasan = $frm.find('*[name=pokok_bahasan]').val();
			/*$file = $frm.find('*[name=file]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();*/
			if($frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=bab]').is('.valid') && $frm.find('*[name=pokok_bahasan]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid')  && $frm.find('*[name=keterangan]').is('.valid')*/) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#materi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Memasukkan Data');
						//$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".error-box").delay(1000).fadeOut("slow",function(){
							$(this).remove();
						});	
						var upload=ajaxuploadnew("<? echo base_url();?>akademik/materi/upload/"+msg,"response","image-list","fileaddmateri");
						$.ajax({
							url: "<? echo base_url();?>akademik/materi/upload/"+msg,
							type: "POST",
							data: upload,
							processData: false,
							contentType: false,
							beforeSend: function() {
								$("#materi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
								$(".error-box").delay(1000).html('Proses Upload File');
							},
							error	: function(){
								alert('Materi anda sudah tersimpan. Tetapi lampiran file anda gagal di Upload. Klik OK untuk melengkapi lampiran');
								$('#subjectlistmateri').load('<?=base_url('akademik/materi/editmateri')?>/'+msg);						
							},
							success: function (res) {
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});	
								if(res=='null'){
									$.ajax({
										type: "POST",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&&ajax=1',
										url: '<?=base_url('akademik/materi/daftarmaterilist')?>',
										beforeSend: function() {
											$("#materi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
											$(".error-box").delay(1000).html('Load data');
											$(".error-box").delay(1000).fadeOut("slow",function(){
												$(this).remove();
											});
										},
										success: function(msg2) {
											$("#wait").remove();
											$('select#kelas').val($('select#kelas_add').val());
											$('select#pelajaran').html($('select#pelajaran_add').html());
											$('select#pelajaran').val($('select#pelajaran_add').val());
											$('#subjectlistmateri').html(msg2);
											$('#subject').scrollintoview({ speed:'1100'});
										}
									});
								}else{
									alert(res+'');
									$('#subjectlistmateri').load('<?=base_url('akademik/materi/editmateri')?>/'+msg);
								}
							}
						});
						

						$("#wait").remove();
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		/*$("select#kelas_add").change(function(e){
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
		});*///Submit End
		
		$("#keteranganmateri").hide(500);
		$("#tanggalmateri").hide(500);
		$("input#simpanarsip").change(function(e){
			if($(this).is(':checked')){
				$("select#kelas_add").prop('disabled', true);
				//$("#keteranganaddmateri").prop('disabled', true);
				$("#keteranganaddmateri").val('');
				$("#keteranganmateri").hide(500);
				//$("#date2materi").prop('disabled', true);
				$("#date2materi").val('');
				$("#tanggalmateri").hide(500);
			}else{
				$("select#kelas_add").prop('disabled', false);
				//$("#keteranganaddmateri").prop('disabled', false);
				$("#keteranganmateri").show(500);
				//$("#date2materi").prop('disabled', false);
				$("#tanggalmateri").show(500);
			}
			
		});//Submit End
		$("select#pelajaran_add").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#kelas_add").html(msg);	
				}
			});
		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datemateri').datepick();
	$('#date2materi').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="materi" enctype="multipart/form-data" id="materi" action="<? echo base_url();?>akademik/materi/addmateri">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Tambah Materi</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#materi').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="cancelmateri" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td colspan="2">
					<select class="selectfilter" id="pelajaran_add" name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? //if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Kirim Materi ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_add" name="id_kelas[]" disabled multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			    <td>
					<div id="response" style="font-size:11px;"><input type="checkbox" checked id="simpanarsip" name="simpanarsip" /> &nbsp; Jangan Kirim, Simpan saja sebagai arsip</div></td>
			</tr>
			<tr>
				<td class="title">Pokok Bahasan</td>
				<td>:</td>
				<td colspan="2">
					<input type="text" value="" size="30" name="pokok_bahasan">				
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td colspan="2">
					<input type="text" value="" size="30" name="bab">				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran file dengan upload</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="file" name="file" id="fileaddmateri" multiple />
					<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran file dari content belajar</td>
				<td width="1">:</td>
				<td colspan="2">
					<ul class="file" id="addmatericontbljr"></ul>
					<a class="button small light-grey zoom-icon modal" title="" href="<?=base_url('akademik/bahanajar/guru/908786/additional')?>" style="margin-left:0;"> <span> Pilih materi dari content belajar </span> </a>
					<!--<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dari daftar "Content Belajar", klik tombol diatas kemudian pilih file</div>-->
				</td>
			</tr>
			<!--<tr>
				<td width="30%" class="title">Diberikan Tanggal</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_diberikan" style="width:100px;" value="<?=date('Y-m-d')?>" id="datemateri">
				</td>
			</tr>--> 
			<tr  id="tanggalmateri">
				<td width="30%" class="title">Tanggal Diajarkan</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="text" name="tanggal_diajarkan" style="width:100px;" value="" id="date2materi" />
				</td>
			</tr>
			<tr id="keteranganmateri">
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td colspan="2">
					<textarea name="keterangan" id="keteranganaddmateri"></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="checkbox" checked name="share" value="1" />
				</td>
			</tr>
			
			<tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#materi').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="cancelmateri" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
  </form>
</div>