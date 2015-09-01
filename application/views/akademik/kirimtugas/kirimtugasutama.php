<script>
	$(document).ready(function(){
		$("#kirimtugasutama").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  //id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  bab:{required:true,notEqual:''},
				  judul:{required:true,notEqual:''},
				  //file:{required:true,notEqual:''},
				  //keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		
		$("table.adddata tr th a.canceltugas").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelastugas').val()+'&pelajaran='+$('select#pelajarantugas').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimtugas/daftartugaslist')?>',
					beforeSend: function() {
						$("table.adddata tr th a.canceltugas").after("<img id='waittugas24' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waittugas24").remove();
						//$('select#kelastugas').val('');
						//$('select#pelajarantugas').html($('select#pelajaran_addtugas').html());
						//$('select#pelajarantugas').val('');	
						$('#subjectlisttugas').html(msg);
						
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		
		filesize('fileaddtugas',15000000,50);
		$("#kirimtugasutama").submit(function(e){
			$frm = $(this);
			
			if($('input#datekirimtugasutama').val()==''  && !$('input#simpanarsiptugas').is(':checked')){
				$('input#datekirimtugasutama').css('border','1px solid red');
			}else{
				$('input#datekirimtugasutama').css('border','1px solid #D8D8D8');
			}
			
			if($('select#kelas_addtugas').val()==null  && !$('input#simpanarsiptugas').is(':checked')){
				$('select#kelas_addtugas').css('border','1px solid red');
				return false;
			}else{
				$('select#kelas_addtugas').css('border','1px solid #D8D8D8');
			}
			
			if($('input#datekirimtugasutama').val()==''  && !$('input#simpanarsiptugas').is(':checked')){
				$('input#datekirimtugasutama').css('border','1px solid red');
				return false;
			}else{
				$('input#datekirimtugasutama').css('border','1px solid #D8D8D8');
			}
			
			//$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$bab = $frm.find('*[name=bab]').val();
			$judul = $frm.find('*[name=judul]').val();
			//$file = $frm.find('*[name=file]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			if($frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=bab]').is('.valid') && $frm.find('*[name=judul]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid') && $frm.find('*[name=keterangan]').is('.valid')*/) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#kirimtugasutama").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Inserting Data');
					},
					success: function(msg) {
						$(".error-box").delay(1000).fadeOut("slow",function(){
							$(this).remove();
						});
						var upload=ajaxuploadnew("<? echo base_url();?>akademik/kirimtugas/uploadfiletugas/"+msg,"response","image-list","fileaddtugas");
						$.ajax({
							url: "<? echo base_url();?>akademik/kirimtugas/uploadfiletugas/"+msg,
							type: "POST",
							data: upload,
							processData: false,
							contentType: false,
							beforeSend: function() {
								$("#kirimtugasutama").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
								$(".error-box").delay(1000).html('Proses Upload File');
							},
							error	: function(){
								alert('TUGAS anda sudah tersimpan. Tetapi lampiran file anda gagal di Upload. Klik OK untuk melengkapi lampiran');
								$('#subjectlisttugas').load('<?=base_url('akademik/kirimtugas/kirimtugasutamaedit')?>/'+msg);						
							},
							success: function (res) {
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});	
								if(res=='null'){
									$.ajax({
										type: "POST",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&&ajax=1',
										url: '<?=base_url('akademik/kirimtugas/daftartugaslist')?>',
										beforeSend: function() {
											$("#materi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
											$(".error-box").delay(1000).html('Load data');
											$(".error-box").delay(1000).fadeOut("slow",function(){
												$(this).remove();
											});
										},
										success: function(msg) {
											$('#subjectlisttugas').html(msg);
											$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
										}
									});
								}else{
									alert(res+'');
									$('#subjectlisttugas').load('<?=base_url('akademik/kirimtugas/kirimtugasutamaedit')?>/'+msg);
								}
							}
						});
	
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		$("#keterangantugas").hide(500);
		$("#tanggaltugas").hide(500);
		$("input#simpanarsiptugas").change(function(e){
			if($(this).is(':checked')){
				$("select#kelas_addtugas").prop('disabled', true);
				//$("input#datekirimtugasutama").prop('disabled', true);
				$("#keteranganaddtugas").val('');
				$("#datekirimtugasutama").val('');
				$("#keterangantugas").hide(500);
				$("#tanggaltugas").hide(500);
			}else{
				$("select#kelas_addtugas").prop('disabled', false);
				//$("input#datekirimtugasutama").prop('disabled', false);
				$("#keterangantugas").show(500);
				$("#tanggaltugas").show(500);
			}
		});//Submit End
		$("select#pelajaran_addtugas").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addtugas').after("<img id='waittugas27' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waittugas27').remove();
					$("#kelas_addtugas").html(msg);	
					$("select#kelas_addtugas").parent('td').children('input[type="hidden"]').remove();
					$("select#kelas_addtugas option").each(function(e){
						var val=$(this).attr('id_mengajar');
						var id_kelas=$(this).attr('value');
						
						if(e==0){
							$(this).remove();
						}
						if(val!=undefined){
							$("select#kelas_addtugas").parent('td').append('<input  type="hidden" name="id_mengajar['+id_kelas+']" value="'+val+'" />');
						}
					});
				}
			});
		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimtugasutama').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimtugasutama" enctype="multipart/form-data" id="kirimtugasutama" action="<? echo base_url();?>akademik/kirimtugas/kirimtugasutama">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Tambah TUGAS</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#kirimtugasutama').submit();" id="simpantugas" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a class="button small light-grey absenbutton canceltugas" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td colspan="2">
					<select class="selectfilter" id="pelajaran_addtugas" name="id_pelajaran">
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
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_addtugas" disabled name="id_kelas[]" multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>

			    <td><input type="checkbox" checked id="simpanarsiptugas" name="simpanarsiptugas" />
&nbsp; Jangan Kirim, Simpan saja sebagai arsip</td>
			</tr>
			<tr id="tanggaltugas">
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="" id="datekirimtugasutama">
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
				<td class="title">Judul TUGAS</td>
				<td>:</td>
				<td colspan="2">
					<input type="text" value="" size="30" name="judul">				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran Soal</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="file" name="file" id="fileaddtugas" multiple />
					<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
				</td>
			</tr>
			<tr id="keterangantugas">
				<td width="30%" class="title">SMS ke ORTU</td>
				<td width="1">:</td>
				<td colspan="2">
					<textarea name="keterangan"  maxlength="200" placeholder="Keterangan akan dikirim ke Orang Tua / Wali Siswa melalui SMS" id="keteranganaddtugas"></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="checkbox" name="share" value="1" checked />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#kirimtugasutama').submit();" id="simpantugasbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a class="button small light-grey absenbutton canceltugas" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
  </form>
</div>