<script>
$(document).ready(function(){


		$("#mapelform").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  nama:{required:true,notEqual:'Pilih mapel'},
				  id_jurusan:{required:true,notEqual:'Pilih Jurusan'},
				  semester:{required:true,notEqual:'Pilih Semester'},
				  jenjang:{required:true,notEqual:'Pilih Jenjang'},
				  kelompok:{required:true,notEqual:'Pilih Kelompok'}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});


		<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMA'){?>
		$("select#id_jurusan").load('<?php echo base_url(); ?>admin/pelajaran/getjurusanByjenjang/<?=$pelajaran[0]['kelas']?>');
		$("select#jenjangkelas").change(function(){
			$("select#id_jurusan").load('<?php echo base_url(); ?>admin/pelajaran/getjurusanByjenjang/'+$(this).val());
		});
		<? } ?>
	function loaddatamapel(){
		$.ajax({
			type: "POST",
			data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
			url: base_url+'admin/pelajaran/listData',
			beforeSend: function() {
				$("#listmapelloading").html("<img src='"+config_images+"loading.png' />");
			},
			success: function(msg) {
				$("#listmapel").html(msg);			
			}
		});
	}
	
//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#mapelform").submit(function(e){
			$frm = $(this);
			$nama = $frm.find('*[name=nama]').val();
			$id_jurusan = $frm.find('*[name=id_jurusan]').val();
			$semester = $frm.find('*[name=semester]').val();
			$jenjang = $frm.find('*[name=jenjang]').val();
			$kelompok = $frm.find('*[name=kelompok]').val();
			if($frm.find('*[name=nama]').is('.valid') <? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?> && $frm.find('*[name=id_jurusan]').is('.valid') && $frm.find('*[name=kelompok]').is('.valid')<? } ?> && $frm.find('*[name=semester]').is('.valid') && $frm.find('*[name=jenjang]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#adduser").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".addaccount").remove();	
							$.ajax({
								type: "POST",
								data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
								url: '<?php echo base_url(); ?>admin/pelajaran/listData',
								beforeSend: function() {
									$("#listpelajaran").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#listpelajaran").html(msg);			
								}
							});			
					}
				});
				return false;
			}
			
			return false;
		});//Submit End
});
</script>
<div class="addaccount">
<form action="<? echo base_url();?>admin/pelajaran/editdata" id="mapelform" name="mapelform" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> Edit Data Pelajaran </h3>
		<table class="adddata">
		
			<tr>
				<td width="30%" class='title'>Nama Pelajaran</td>
				<td width="1">:</td>
				<td><input type="text" name="nama" size="30" value="<?=$pelajaran[0]['nama']?>"/></td>
			</tr>
			<tr>
				<td width="30%" class='title'>Alias</td>
				<td width="1">:</td>
				<td>
				<input type="text" name="alias" maxlength="10" size="10"  value="<?=$pelajaran[0]['alias']?>"/><br /><br />
				<div style="font-size:11px;" id="response">*) Singkatan nama pelajarang yang akan digunakan untuk SMS notifikasi</div>
				</td>
			</tr>
			<tr>
				<td class="title">Jenjang</td>
				<td>:</td>
				<td>
					<select name="jenjang"  id="jenjangkelas" class="selectadddata">
						<option value="">Pilih Jenjang Kelas</option>
						<? foreach($grade as $datagrade){?>
						<option <? if($pelajaran[0]['kelas']==$datagrade){echo 'selected';}?>  value="<?=$datagrade?>"><?=$datagrade?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD' || $this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMP'){?>
				<script>
				$(document).ready(function(){
					$('.addaccountclose').after('<input type="hidden" name="id_jurusan" value="<?=$pelajaran[0]['id_jurusan']?>">');
				});
				</script>
			<? }else{ ?>
			<tr>
				<td class="title">Jurusan</td>
				<td>:</td>
				<td>
					<select name="id_jurusan" id="id_jurusan" class="selectadddata">
						<option value="">Pilih Jurusan</option>
						<? foreach($jurusan as $datajur){?>
						<option <? if($pelajaran[0]['id_jurusan']==$datajur['id']){echo 'selected';}?> value="<?=$datajur['id']?>"><?=$datajur['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<? } ?>
			<tr>
				<td class="title">Semester</td>
				<td>:</td>
				<td>
					<select name="semester"  class="selectadddata">
						<option value="">Pilih Semester</option>
						<? foreach($semester as $datasemester){?>
							<option <? if($pelajaran[0]['semester']==$datasemester['id']){echo 'selected';}?> value="<?=$datasemester['id']?>"><?=$datasemester['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Kelompok</td>
				<td>:</td>
				<td>
					<select name="kelompok"  class="selectadddata">
						<option value="">Pilih Kelompok</option>

						
						<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD' || $this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMP'){?>
							<option <? if($pelajaran[0]['kelompok']=='Normatif'){echo 'selected';}?>  value="Normatif">Normatif</option>
							<option <? if($pelajaran[0]['Ekstrakurikuler']=='Ekstrakurikuler'){echo 'selected';}?>  value="Ekstrakurikuler">Ekstrakurikuler</option>
						<? }else{ ?>
						<option <? if($pelajaran[0]['kelompok']=='Normatif'){echo 'selected';}?>  value="Normatif">Normatif</option>
						<option <? if($pelajaran[0]['kelompok']=='Adaptif'){echo 'selected';}?>  value="Adaptif">Adaptif</option>
						<option <? if($pelajaran[0]['kelompok']=='Produktif'){echo 'selected';}?>  value="Produktif">Produktif</option>					
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title" colspan="3"><input type="submit" name="simpan" value="Simpan"/></td>
			</tr>
		</table>

	<input type="hidden" name="id" value="<?=$pelajaran[0]['id']?>"/> 
	<input type="hidden" name="addpelajaran" value="1"/> 
	<input type="hidden" name="ajax" value="1"/> 
	</form>
	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
</div>