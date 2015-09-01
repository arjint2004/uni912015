
<script>
	$(document).ready(function(){
		$("#catatanraportform").submit(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize(),
				url: '<?=base_url()?>akademik/raport/catatan/'+$('select#siswaraport').val(),
				beforeSend: function() {
					$("#simpancatatanraport").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$("#wait").remove();	
					$.ajax({
						type: "GET",
						data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
						url: '<?=base_url()?>akademik/raport/catatan/'+$('select#siswaraport').val(),
						beforeSend: function() {
							$("#simpancatatanraport").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(msg) {
							$("#wait").remove();
							$("#catatanload").html(msg);	
						}
					});
					return false;
				}
			});
			return false;
		});
	});
</script>	
<? //pr($kenaikan);?>
<div id="content" class="raport catatanr">
	<?=$this->load->view('akademik/raport/header')?>
	
	<form action="<? echo base_url();?>" id="catatanraportform" name="catatanraportform" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<table>
		<thead>
			<tr>
				<th colspan="6" style="text-align:right;">
					<a title="" class="button small light-grey absenbutton" id="simpancatatanraport" onclick="$('#catatanraportform').submit();"> Simpan </a>
				</th>
			</tr>                           
        </thead>
		<tbody>
			<tr> 
			   <td><textarea style="width: 97%; height: 200px; margin: 0px;" name="catatan[<?=$id_det_jenjang?>]" ><?=@$catatan[0]['catatan']?></textarea></td>
			</tr>
		</tbody>
	</table>
	</form>
</div>		
<div id="content" class="raport">
	<?//=$this->load->view('akademik/raport/header')?>
	<div class="column one-full">
                    <!-- **Team** -->
                    <div class="team">
                        <div class="share-links"> 
                            <div class="column one-half"> 
                                <h5>Keterangan</h5>
                            </div>            
                        </div> <!-- **Share Links - End** -->                 
                    </div> <!-- **Team - End** -->               
	</div>
	<form action="<? echo base_url();?>" id="catatanraportform" name="catatanraportform" method="post" >
	<table>
		<thead>
			<tr>
				<th colspan="2"></th>
			</tr>                           
        </thead>
		<tbody>
			<? if(isset($kenaikan['statusnaik'])){?>
			<tr> 
			   <td class="title">Kenaikan</td>
			   <td class="title"><?=$kenaikan['statusnaik']?></td>
			</tr>
			<? } ?>
			<tr> 
			   <td class="title">Program</td>
			   <td class="title"><?=$kenaikan['data'][0]['jurusan']?></td>
			</tr>
			<? if(isset($kenaikan['statuslulus'])){?>
			<tr> 
			   <td class="title">Kelulusan</td>
			   <td class="title"><?=$kenaikan['statuslulus']?></td>
			</tr>
			<? } ?>
			<? if(isset($kenaikan['statuslulus'])){?>
			<? if($kenaikan['statuslulus']=='LULUS'){?>
			<tr> 
			   <td class="title" colspan="2"><b>Siswa ini telah menyelesaikan seluruh program pembelajaran di sekolah ini sampai tuntas.</b></td>
			</tr>
			<? }else{ ?>
			<tr> 
			   <td class="title" colspan="2"><b>Siswa ini dinyatakan tidak LULUS.</b></td>
			</tr>
			<? } ?>
			<? } ?>
		</tbody>
	</table>
	<table class="polos">
	  <tr>
		<td>&nbsp;</td>
		<td>Yogyakarta, <? $tg=tanggal($catatan[0]['tanggal']." 00:00:00"); echo $tg[2];?></td>
	  </tr>
	  <tr>
		<td>Orang Tua </td>
		<td>Wali Kleas </td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><strong> ( <?=$siswadata[0]['NmOrtu']?> ) </strong></td>
		<td><strong> ( <?=$wali[0]['nama'];?> ) </strong></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>( Kepala Sekolah ) </td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><strong> ( <?=$kepsek[0]['nama'];?> ) </strong></td>
	  </tr>
	</table>
	</form>
</div>