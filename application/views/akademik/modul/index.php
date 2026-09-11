<style>
.modul-intro { color:#666; margin:0 0 16px; }
.modul-toolbar { overflow:hidden; margin:0 0 18px; }
.modul-cari { width:70%; max-width:360px; padding:8px 10px; border:1px solid #d7d7d7; border-radius:4px; }
.modul-count { float:right; color:#888; font-size:12px; padding-top:8px; }
.modul-kategori { margin:0 0 22px; }
.modul-kategori-title { margin:0 0 10px; font-size:15px; color:#2b4c7e; border-bottom:1px solid #e6e6e6; padding-bottom:6px; }
.modul-grid { overflow:hidden; }
.modul-card { display:block; float:left; width:30%; margin:0 3% 12px 0; min-height:92px; padding:12px; background:#f7f7f7; border:1px solid #e0e0e0; border-left:4px solid #3b6ea5; border-radius:4px; text-decoration:none; color:#444; box-sizing:border-box; }
.modul-card:nth-child(3n) { margin-right:0; }
.modul-card:hover { background:#eef4fb; border-color:#3b6ea5; color:#222; }
.modul-badge { display:inline-block; width:22px; height:22px; line-height:22px; text-align:center; background:#3b6ea5; color:#fff; border-radius:3px; font-size:12px; font-weight:bold; margin-right:6px; }
.modul-nama { font-weight:bold; font-size:13px; }
.modul-desc { display:block; margin-top:6px; font-size:12px; color:#777; line-height:1.35; }
.modul-empty { padding:20px; background:#fafafa; border:1px dashed #ccc; color:#888; }
@media (max-width: 768px) {
	.modul-card, .modul-card:nth-child(3n) { width:48%; margin-right:4%; }
	.modul-card:nth-child(2n) { margin-right:0; }
	.modul-cari { width:100%; max-width:none; }
	.modul-count { float:none; display:block; margin-top:6px; }
}
@media (max-width: 480px) {
	.modul-card, .modul-card:nth-child(2n), .modul-card:nth-child(3n) { width:100%; margin-right:0; }
}
</style>
<?php if ( ! empty($show_profile)) {
	$this->load->view('akademik/mainakademik/topindex');
} ?>

<div class="portfolio column-one-half-with-sidebar">
	<h3>Tampilan Module</h3>
	<div class="hr"></div>
	<p class="modul-intro">Daftar module yang dapat Anda akses sebagai <strong><?php echo htmlspecialchars($role === '' ? 'pengguna' : $role, ENT_QUOTES, 'UTF-8'); ?></strong>. Klik kartu untuk membuka module.</p>

	<?php if (empty($grouped)) { ?>
		<div class="modul-empty">Belum ada module yang tersedia untuk peran ini.</div>
	<?php } else { ?>
		<div class="modul-toolbar">
			<input type="text" id="modul-cari" class="modul-cari" placeholder="Cari module..." autocomplete="off" />
			<span class="modul-count"><?php echo count($modules); ?> module</span>
		</div>

		<?php foreach ($grouped as $kategori => $items) { ?>
			<div class="modul-kategori" data-kategori="<?php echo htmlspecialchars($kategori, ENT_QUOTES, 'UTF-8'); ?>">
				<h4 class="modul-kategori-title"><?php echo htmlspecialchars($kategori, ENT_QUOTES, 'UTF-8'); ?></h4>
				<div class="modul-grid">
					<?php foreach ($items as $modul) {
						$huruf = strtoupper(substr($modul['nama'], 0, 1));
					?>
					<a class="modul-card" href="<?php echo $modul['url']; ?>" data-nama="<?php echo htmlspecialchars(strtolower($modul['nama'].' '.$modul['deskripsi'].' '.$kategori), ENT_QUOTES, 'UTF-8'); ?>">
						<span class="modul-badge"><?php echo $huruf; ?></span>
						<span class="modul-nama"><?php echo htmlspecialchars($modul['nama'], ENT_QUOTES, 'UTF-8'); ?></span>
						<span class="modul-desc"><?php echo htmlspecialchars($modul['deskripsi'], ENT_QUOTES, 'UTF-8'); ?></span>
					</a>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
</div>

<script>
$(document).ready(function() {
	$('#modul-cari').bind('keyup input', function() {
		var q = $.trim($(this).val()).toLowerCase();
		var visible = 0;
		$('.modul-kategori').show();
		$('.modul-card').each(function() {
			var nama = $(this).attr('data-nama') || '';
			var match = (q === '' || nama.indexOf(q) !== -1);
			if (match) {
				$(this).show();
				visible++;
			} else {
				$(this).hide();
			}
		});
		$('.modul-kategori').each(function() {
			var n = 0;
			$(this).find('.modul-card').each(function() {
				if ($(this).css('display') !== 'none') { n++; }
			});
			if (n > 0) { $(this).show(); } else { $(this).hide(); }
		});
		$('.modul-count').text(visible + ' module');
	});
});
</script>
