								<script>
								$(document).ready(function(){
									if($('ul.tabs-frameuts').length > 0) $('ul.tabs-frameuts').tabs('> .tabs-frame-contentuts');
									$("div#actdelluts").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/kirimuts/delete/'+$(this).attr('id_uts'),
													beforeSend: function() {
														$(objdell).after("<img id='waituts7' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#waituts7").remove();	
														if(msg==1){
															//$(objdell).parent('td').parent('tr').next().remove();
															//$(objdell).parent('td').parent('tr').remove();
															$.ajax({
																	type: "POST",
																	data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelasuts').val()+'&pelajaran='+$('select#pelajaranuts').val()+'&ajax=1',
																	url: '<?=base_url()?>akademik/kirimuts/daftarutslist',
																	beforeSend: function() {
																		$(objdell).after("<img id='waituts8' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
																	},
																	success: function(msg) {
																		$("#waituts8").remove();
																		//$('select#kelasuts').val('');
																		//$('select#pelajaranuts').html($('select#pelajaran_adduts').html());
																		//$('select#pelajaranuts').val('');
																		$('#subjectlistuts').html(msg);
																	}
															});
														}
													}
												});
												return false;
											}
									});	
									
									$("div.actedituts").click(function(){
											var objdell=$(this);
											$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: $(objdell).attr('href'),
													beforeSend: function() {
														$(objdell).after("<img id='waituts9' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#waituts9").remove();
														$('#subjectlistuts').html(msg);
													}
											});
									});
										
										

									$("div#paginationutsilist a").click(function(){
										var objdell=$(this);
										$.ajax({
											type: "POST",
											data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_pengguna=<?=@$id_pengguna?>&kepsek=<?=@$kepsek?>',
											url: $(objdell).attr('href'),
											beforeSend: function() {
												$(objdell).after("<img class='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
											},
											success: function(msg) {
												$(".wait").remove();	
												$("#subjectlistuts").html(msg);
												//$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
											}
										});
										return false;
									});			
								});
								function getdetail(id,obj,ident){
									$('#'+ident+id).toggle('fade');
									$('table.utslist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/uts',
										beforeSend: function() {
											//$("#filterpelajaranuts select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											
										},
										success: function(msg) {
											//$("#wait").remove();
											$('#komentaruts'+id).html(msg);	
										}
									});
									return false;
								}
								</script>
								<? //uts($uts);?>
								<? if($kepsek=='kepsek' && $page==0){?>
								<div id="subjectlistuts" style="min-width:700px;">	
								<? } ?>	
								<div class="tabs-container">
									<ul class="tabs-frame tabs-frameuts">
										<li><a href="#">Semua arsip UTS</a></li>
										<li><a href="#">UTS Terkirim</a></li>
										<li><a href="#">Download</a></li>
									</ul>
									<div class="tabs-frame-content tabs-frame-contentuts ">
									<div style="float:left;" id="paginationutsilist" >
									<?=$link?>
									</div>										
									<table class="utslist">
											<thead>
												<tr> 
													<th>No</th>
													<th>Jenis</th>      
													<th>Judul</th>
													<th>Dikirim Ke</th>
													<th>Tgl Upload</th>
													<th style="width:37px;">Detail</th>
													<? if($kepsek!='kepsek'){?>
													<th style="width:75px;">Ubah|Hapus</th>
													<? } ?>
												</tr>                         
											</thead>
											<tbody>
												<? 
												$cur_page2=$cur_page;
												$per_page2=$per_page;
												if(@$cur_page==0){@$cur_page=1;}
												$no=(@$cur_page*@$per_page)-@$per_page+1;
												if(!empty($uts)){
												foreach($uts as $kt=>$datauts){
													if($datauts['jenis']!='remidial'){$bordettop="bordettop";}else{$bordettop="";}
												?>
												<tr style="cursor:pointer;<? if($datauts['jenis']!='remidial'){?>border-top:1px solid #ccc;<?}?>" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datauts['id']?>,this,'detailutssemua');">
													<td class="<?=$bordettop?>" ><? if($datauts['jenis']!='remidial'){?><?=$no++;?><? } ?></td>
													<td class="<?=$bordettop?> title"><? if($datauts['jenis']=='non_remidial'){echo "UTS Utama";}else{ echo "remidial";}?></td>
													<td class="<?=$bordettop?> title" ><?=$datauts['judul']?></td>
													<td class="<?=$bordettop?> title" ><? 
													if(!empty($datauts['dikirim'])){
														foreach($datauts['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}
													}else{
														echo 'Belum dikirim';
													}
													?></td>
													<td class="<?=$bordettop?>"><? $tg=tanggal($datauts['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
													<td class="<?=$bordettop?>"><a style="cursor:pointer;">Lihat</a></td>
													<? if($kepsek!='kepsek'){?>
													<td class="<?=$bordettop?>" >
														<? if($datauts['jenis']=='non_remidial'){?>
														<div class="actedituts actedit" id_uts="<?=$datauts['id']?>" title="ubah" href="<?=base_url('akademik/kirimuts/kirimutsutamaedit/'.$datauts['id'])?>"></div>
														<? }else{ ?>
														<div class="actedituts actedit" id_uts="<?=$datauts['id']?>" title="ubah" href="<?=base_url('akademik/kirimuts/kirimutsremidialedit/'.$datauts['id'])?>"></div> 
														<? } ?>
														<div class="actdell" id="actdelluts" id_uts="<?=$datauts['id']?>"></div>
													</td>
													<?}?>
												</tr>
												<tr id="detailutssemua<?=$datauts['id']?>" style="display:none;">
													<td colspan="7" class="innercolspan">
														<div class="">
														<? 
														if(!empty($datauts['dikirim'])){
															foreach($datauts['dikirim'] as $dtdkrm){
																pengumpulan_akademik($dtdkrm['id_kelas'],$datauts['id_sekolah'],$jenis='uts',$datauts['id'],$datauts['id_pelajaran'],$dtdkrm['kelas'].$dtdkrm['nama_kelas']);
															}
														}
														?>
														<? 
														if($datauts['jenis']=='remidial'){
															ikut_remidi($datauts['id_kelas'],$datauts['id'],$jenis='uts');
														}
														?>
														<div class="full file">
														<h3 >Detail UTS</h3>
														<div class="hr"></div>
														<table class="noborder">
															<tr>
																<td class="title">Judul UTS</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauts['judul']?></td>
															</tr>
															<tr>
																<td class="title">Mata Pelajaran</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauts['nama_pelajaran']?></td>
															</tr>
															<tr>
																<td class="title">BAB</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauts['bab']?></td>
															</tr>
															<tr>
																<td class="title">Jenis</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauts['jenis']?></td>
															</tr>
															
														</table>
														</div>
														
														<div class="full file">
														<h3 >Lampiran</h3>
														<div class="hr"></div>
														<table class="noborder">
															<?
															if(!empty($datauts['file'])){
															foreach($datauts['file'] as $file){?>
															<tr>
																<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/uts/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
																| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/uts/'.$file['file_name']).'')?>">Lihat</a>
																</td>
															</tr>
															<? }} ?>
														</table>
														</div>
														
														<!--<div class="full file">
														<h3 >Keterangan</h3>
														<div class="hr"></div>
														<ul>
															<li><?=$datauts['keterangan']?></li>
														</ul>
														</div>-->
														<br class="clear" />
														<!--<div id="komentaruts<?=$datauts['id']?>"></div>-->
														</div>
													</td>
												</tr>
												<? } } ?>
											</tbody>
										</table>
										<div style="float:left;" id="paginationutsilist" >
										<?=$link?>
										</div>										
										
									</div>
									<div class="tabs-frame-content tabs-frame-contentuts">
										<div style="float:left;" id="paginationutsilist" >
										<?=$link?>
										</div>											
										<table class="utslist">
											<thead>
												<tr> 
													<th>No</th>
													<th>Jenis</th>      
													<th>Judul</th>
													<th>Ke Kelas</th>
													<th>Waktu Upload</th>
													<? if($kepsek!='kepsek'){?>
													<th>Ubah | Hapus</th>
													<? } ?>
												</tr>                         
											</thead>
											<tbody>
												<? 
												//if(@$cur_page2==0){@$cur_page2=1;}
												//$noc=(@$cur_page2*@$per_page2)-@$per_page2+1;
												$noc=1;
												if(!empty($terkirim)){
												foreach($terkirim as $kt=>$datauts){
													if($datauts['jenis']!='remidial'){$bordettop="bordettop";}else{$bordettop="";}
												?>
												<tr style="cursor:pointer;<? if($datauts['jenis']!='remidial'){?>border-top:1px solid #ccc;<?}?>" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datauts['id']?>,this,'detailutsterkirim');">
													<td class="<?=$bordettop?>" ><? if($datauts['jenis']!='remidial'){?><?=$noc++;?><? } ?></td>
													<td class="<?=$bordettop?> title"><? if($datauts['jenis']=='non_remidial'){echo "UTS Utama";}else{ echo "remidial";}?></td>
													<td class="<?=$bordettop?> title" ><?=$datauts['judul']?></td>
													<td class="<?=$bordettop?> title" ><? foreach($datauts['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
													<td class="<?=$bordettop?>"><? $tg=tanggal($datauts['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
													<? if($kepsek!='kepsek'){?>
													<td class="<?=$bordettop?>" >
														<? if($datauts['jenis']=='non_remidial'){?>
														<div class="actedituts actedit" id_uts="<?=$datauts['id']?>" title="ubah" href="<?=base_url('akademik/kirimuts/kirimutsutamaedit/'.$datauts['id'])?>"></div>
														<? }else{ ?>
														<div class="actedituts actedit" id_uts="<?=$datauts['id']?>" title="ubah" href="<?=base_url('akademik/kirimuts/kirimutsremidialedit/'.$datauts['id'])?>"></div> 
														<? } ?>
														<div class="actdell" id="actdelluts" id_uts="<?=$datauts['id']?>"></div>
													</td>
													<? } ?>
												</tr>
												<tr id="detailutsterkirim<?=$datauts['id']?>" style="display:none;">
													<td colspan="6" class="innercolspan">
														<div class="">
															<div class="full file">
															<h3 >Di Kirim ke Kelas</h3>
															<div class="hr"></div>
															<table class="noborder">
																
																<tr>
																	<th style="width:10px;">No</th>
																	<th >Kelas</th>
																	<th >Tanggal Dikumpulkan</th>
																	<th >Keterangan</th>
																</tr>
																<? foreach($datauts['dikirim'] as $dtdkrm){ $noo++;?>
																<tr>
																	<td ><?=$noo?></td>
																	<td class="title"><?=$dtdkrm['kelas'].$dtdkrm['nama_kelas']?></td>
																	<td class="title"><? $tg=tanggal($dtdkrm['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
																	<td class="title"><?=$dtdkrm['keterangan']?></td>
																</tr>
																<? }
																	unset($noo);
																?>
															</table>
															</div>
														<? 
														foreach($datauts['dikirim'] as $dtdkrm){
															pengumpulan_akademik($dtdkrm['id_kelas'],$datauts['id_sekolah'],$jenis='uts',$datauts['id'],$datauts['id_pelajaran'],$dtdkrm['kelas'].$dtdkrm['nama_kelas']);
														}
														?>
														<? 
														if($datauts['jenis']=='remidial'){
															ikut_remidi($datauts['id_kelas'],$datauts['id'],$jenis='uts');
														}
														?>
														<div class="full file">
														<h3 >Detail UTS</h3>
														<div class="hr"></div>
														<table class="noborder">
															<tr>
																<td class="title">Judul UTS</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauts['judul']?></td>
															</tr>
															<tr>
																<td class="title">Mata Pelajaran</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauts['nama_pelajaran']?></td>
															</tr>
															<tr>
																<td class="title">BAB</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauts['bab']?></td>
															</tr>
															<tr>
																<td class="title">Jenis</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauts['jenis']?></td>
															</tr>
														</table>
														</div>
														
														<div class="full file">
														<h3 >Lampiran</h3>
														<div class="hr"></div>
														<table class="noborder">
															<?
															if(!empty($datauts['file'])){
															foreach($datauts['file'] as $file){?>
															<tr>
																<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/uts/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
																| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/uts/'.$file['file_name']).'')?>">Lihat</a>
																</td>
															</tr>
															<? } } ?>
														</table>
														</div>
														
														<!--<div class="full file">
														<h3 >Keterangan</h3>
														<div class="hr"></div>
														<ul>
															<li><?=$datauts['keterangan']?></li>
														</ul>
														</div>-->
														<br class="clear" />
														<div id="komentaruts<?=$datauts['id']?>"></div>
														</div>
													</td>
												</tr>
												<? } } ?>
											</tbody>
										</table>	
										<div style="float:left;" id="paginationutsilist" >
										<?=$link?>
										</div>										
									</div>
									<div class="tabs-frame-content tabs-frame-contentuts">
										<table>
											<thead>
													<tr>
														<th>No</th>
														<th>Nama</th>
														<th>Link</th>
													</tr>
											</thead>
											<tbody>
												<tr>
													<td style="text-align:left;width:1%;">1</td>
													<td style="text-align:left;">Template  Soal</td>
													<td><a href="<?=base_url('upload/akademik/template/TemplateUts.docx')?>">Download</a></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<? if($kepsek=='kepsek'){?>
								</div>
								<? } ?>