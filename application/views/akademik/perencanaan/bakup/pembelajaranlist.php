								<script>
									$(document).ready(function(){
										//Submit Start

										
										$("ul.file div.actdell").click(function(){
											var objdell=$(this);
											if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/perencanaan/deletefilepemb/'+$(this).attr('id'),
													beforeSend: function() {
														$(objdell).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#wait").remove();	
														$(objdell).parent().remove();
													}
												});
												return false;
											}
										});
										
										$("div#actdellpemp").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/perencanaan/deletepemb/'+$(this).attr('id_pemb'),
													beforeSend: function() {
														$(objdell).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#wait").remove();	
														if(msg==1){
															$(objdell).parent('td').parent('tr').remove();
															$(objdell).parent('td').parent('tr').next().remove();
														}
													}
												});
												return false;
											}
										});
										
										
									});
								</script>
							   <table>
										<thead>
											<tr>
												<th>No</th>      
												<th>Pelajaran</th>
												<th>Kelas</th>
												<th>Semester</th>
												<th>Penilaian</th>
												<th>Action</th>
											</tr>                         
										</thead>
										<tbody>
											<? 
											$nox=array();$no=1;
											if(!empty($pembelajaran['pembelajaran'])){
											foreach($pembelajaran['pembelajaran'] as $kt=>$datapembelajaran){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="$('#detailpembelajaran<?=$datapembelajaran['id']?>').toggle('fade')">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datapembelajaran['nama_pelajaran']?></td>
												<td class="title" ><?=$datapembelajaran['kelas']?><?=$datapembelajaran['nama_kelas']?></td>
												<td ><?=$datapembelajaran['semester']?></td>
												<td ><a href="<?=site_url('akademik/perencanaan/penilaian/')?>" id="penilaianklik" class="penilaian">Input Penilaian</a></td>
												<td >
													<div class="actedit" onclick="$('#subjectlist').load('<?=base_url('akademik/perencanaan/editpembelajaran/'.$datapembelajaran['id'])?>');"></div> 
													<div id="actdellpemp" id_pemb="<?=$datapembelajaran['id']?>" class="actdell"></div>
												</td>
											</tr>
											<tr id="detailpembelajaran<?=$datapembelajaran['id']?>" style="display:none;">
												<td colspan="7" class="innercolspan">
													<div style="width:99%;" class="file">
													<h3 >File Data Pembelajaran</h3>
													<div class="hr"></div>
													<ul class="file">
														<? foreach($datapembelajaran['file'] as $file){ ?>
															<li id="li<?=$file['id']?>"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode("upload/akademik/rencana_pembelajaran/").'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?></a> <div style="float:right;" id="<?=$file['id']?>" class="actdell"></div></li>
															
														<? } ?>
													</ul>
													</div>
													
												</td>
											</tr>
											<? }  } ?>
										</tbody>
								</table>
								