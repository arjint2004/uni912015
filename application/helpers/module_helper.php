<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Katalog module Studentbook.
 * Dipakai halaman Tampilan Module supaya semua fitur tampil per peran.
 */

if ( ! function_exists('studentbook_module_catalog'))
{
	function studentbook_module_catalog()
	{
		return array(
			array(
				'id' => 'materi',
				'nama' => 'Materi Pelajaran',
				'deskripsi' => 'Kirim dan kelola materi pembelajaran.',
				'kategori' => 'Pembelajaran',
				'url_guru' => 'akademik/materi',
				'url_siswa' => 'siswa/materi',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'pr',
				'nama' => 'Pekerjaan Rumah',
				'deskripsi' => 'Buat, kirim, dan kumpulkan PR.',
				'kategori' => 'Pembelajaran',
				'url_guru' => 'akademik/kirimpr/daftarpr',
				'url_siswa' => 'siswa/kirimpr/daftarpr',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'tugas',
				'nama' => 'Tugas Sekolah',
				'deskripsi' => 'Kelola tugas sekolah dan pengumpulan.',
				'kategori' => 'Pembelajaran',
				'url_guru' => 'akademik/kirimtugas/daftartugas',
				'url_siswa' => 'siswa/kirimtugas/daftartugas',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'bahanajar',
				'nama' => 'Content Belajar',
				'deskripsi' => 'Bahan ajar kurikulum KTSP dan K13.',
				'kategori' => 'Pembelajaran',
				'url_guru' => 'akademik/bahanajar/guru',
				'url_siswa' => 'akademik/bahanajar/siswa',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'harian',
				'nama' => 'Ulangan Harian',
				'deskripsi' => 'Soal dan pelaksanaan ulangan harian.',
				'kategori' => 'Ujian',
				'url_guru' => 'akademik/kirimharian/daftarharian',
				'url_siswa' => 'siswa/kirimharian/daftarharian',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'uts',
				'nama' => 'UTS',
				'deskripsi' => 'Ujian Tengah Semester.',
				'kategori' => 'Ujian',
				'url_guru' => 'akademik/kirimuts/daftaruts',
				'url_siswa' => 'siswa/kirimuts/daftaruts',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'uas',
				'nama' => 'UAS',
				'deskripsi' => 'Ujian Akhir Semester.',
				'kategori' => 'Ujian',
				'url_guru' => 'akademik/kirimuas/daftaruas',
				'url_siswa' => 'siswa/kirimuas/daftaruas',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'evaluasi_otentik',
				'nama' => 'Evaluasi Otentik',
				'deskripsi' => 'Buat dan scoring evaluasi otentik.',
				'kategori' => 'Evaluasi',
				'url_guru' => 'akademik/perencanaan',
				'url_siswa' => '',
				'roles' => array('guru')
			),
			array(
				'id' => 'nilai_kognitif',
				'nama' => 'Nilai Kognitif',
				'deskripsi' => 'Penilaian deskriptif kognitif.',
				'kategori' => 'Evaluasi',
				'url_guru' => 'akademik/nilaiotentik',
				'url_siswa' => '',
				'roles' => array('guru')
			),
			array(
				'id' => 'nilai_tugas',
				'nama' => 'Penilaian Tugas',
				'deskripsi' => 'Input nilai tugas sekolah.',
				'kategori' => 'Penilaian',
				'url_guru' => 'akademik/nilaitugas',
				'url_siswa' => '',
				'roles' => array('guru')
			),
			array(
				'id' => 'nilai_harian',
				'nama' => 'Penilaian UL Harian',
				'deskripsi' => 'Input nilai ulangan harian.',
				'kategori' => 'Penilaian',
				'url_guru' => 'akademik/nilai',
				'url_siswa' => '',
				'roles' => array('guru')
			),
			array(
				'id' => 'rekap_nilai',
				'nama' => 'Rekapitulasi Nilai',
				'deskripsi' => 'Rekap nilai akademik siswa.',
				'kategori' => 'Penilaian',
				'url_guru' => 'akademik/rekapnilai',
				'url_siswa' => 'siswa/rekapnilai',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'absensi',
				'nama' => 'Absensi',
				'deskripsi' => 'Catat kehadiran siswa.',
				'kategori' => 'Absensi',
				'url_guru' => 'akademik/absensi',
				'url_siswa' => '',
				'roles' => array('guru')
			),
			array(
				'id' => 'rekap_absensi',
				'nama' => 'Rekap Absensi',
				'deskripsi' => 'Rekapitulasi kehadiran siswa.',
				'kategori' => 'Absensi',
				'url_guru' => 'akademik/absensi/rekapabsensi',
				'url_siswa' => 'siswa/rekapabsensi',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'jadwal',
				'nama' => 'Jadwal Pelajaran',
				'deskripsi' => 'Lihat jadwal pelajaran.',
				'kategori' => 'Administrasi',
				'url_guru' => 'akademik/jadwal',
				'url_siswa' => 'akademik/jadwal',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'administrasi',
				'nama' => 'Administrasi Guru',
				'deskripsi' => 'RPP, silabus, program, dan analisis.',
				'kategori' => 'Administrasi',
				'url_guru' => 'akademik/administrasi',
				'url_siswa' => '',
				'roles' => array('guru')
			),
			array(
				'id' => 'sms',
				'nama' => 'Notifikasi SMS',
				'deskripsi' => 'Kirim dan pantau SMS akademik.',
				'kategori' => 'Komunikasi',
				'url_guru' => 'akademik/sms',
				'url_siswa' => '',
				'roles' => array('guru')
			),
			array(
				'id' => 'penghubung_ortu',
				'nama' => 'Penghubung Orang Tua',
				'deskripsi' => 'Laporan kegiatan dan perkembangan siswa.',
				'kategori' => 'Komunikasi',
				'url_guru' => 'akademik/jurnalwali/penghubungortu',
				'url_siswa' => 'siswa/jurnalwalikelas/penghubungortu',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'catatan_guru',
				'nama' => 'Catatan Guru',
				'deskripsi' => 'Catatan perkembangan siswa.',
				'kategori' => 'Komunikasi',
				'url_guru' => 'akademik/catatanguru',
				'url_siswa' => 'siswa/catatanguru',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'jurnal_wali',
				'nama' => 'Jurnal Wali Kelas',
				'deskripsi' => 'Jurnal dan catatan wali kelas.',
				'kategori' => 'Wali Kelas',
				'url_guru' => 'akademik/jurnalwali',
				'url_siswa' => 'siswa/jurnalwalikelas',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'prestasi',
				'nama' => 'Prestasi Siswa',
				'deskripsi' => 'Input prestasi siswa.',
				'kategori' => 'Wali Kelas',
				'url_guru' => 'akademik/prestasi',
				'url_siswa' => '',
				'roles' => array('guru')
			),
			array(
				'id' => 'raport',
				'nama' => 'Raport',
				'deskripsi' => 'Lihat dan cetak raport siswa.',
				'kategori' => 'Raport',
				'url_guru' => 'akademik/raportktsp',
				'url_siswa' => 'siswa/raport',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'ekstrakurikuler',
				'nama' => 'Pengembangan Diri',
				'deskripsi' => 'Nilai ekstrakurikuler dan pengembangan diri.',
				'kategori' => 'Penilaian',
				'url_guru' => 'akademik/nilaiekstrakurikuler/pembinaextra',
				'url_siswa' => '',
				'roles' => array('guru')
			),
			array(
				'id' => 'kepribadian',
				'nama' => 'Penilaian Kepribadian',
				'deskripsi' => 'Nilai kepribadian siswa.',
				'kategori' => 'Penilaian',
				'url_guru' => 'akademik/nilaikepribadian/kesiswaanindex',
				'url_siswa' => '',
				'roles' => array('guru')
			),
			array(
				'id' => 'monitor_guru',
				'nama' => 'Monitor Guru',
				'deskripsi' => 'Pantau aktifitas akademik guru.',
				'kategori' => 'Kepala Sekolah',
				'url_guru' => 'akademik/kepsek',
				'url_siswa' => '',
				'roles' => array('guru', 'admin sekolah')
			),
			array(
				'id' => 'sosial',
				'nama' => 'Jejaring Sosial',
				'deskripsi' => 'Profil, pertemanan, dan kegiatan sekolah.',
				'kategori' => 'Jejaring Sosial',
				'url_guru' => 'sos/pegawai/pertemanan',
				'url_siswa' => 'sos/siswa/pertemanan',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'chat',
				'nama' => 'Chat',
				'deskripsi' => 'Percakapan antar pengguna.',
				'kategori' => 'Jejaring Sosial',
				'url_guru' => 'sos/chat',
				'url_siswa' => 'sos/chat',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'group',
				'nama' => 'Group',
				'deskripsi' => 'Kelompok dan komunitas sekolah.',
				'kategori' => 'Jejaring Sosial',
				'url_guru' => 'sos/group',
				'url_siswa' => 'sos/group',
				'roles' => array('guru', 'siswa', 'ortu')
			),
			array(
				'id' => 'admin_akun',
				'nama' => 'Data Akun',
				'deskripsi' => 'Kelola akun guru dan siswa.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/schooladmin/dataakun',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_profil',
				'nama' => 'Profil Sekolah',
				'deskripsi' => 'Ubah data dan logo sekolah.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/sekolah/editprofil',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_content',
				'nama' => 'Content Sekolah',
				'deskripsi' => 'Konten publik sekolah.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/content',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_ta',
				'nama' => 'Tahun Ajaran',
				'deskripsi' => 'Atur tahun ajaran aktif.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/setting/tahunAjaran',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_semester',
				'nama' => 'Semester',
				'deskripsi' => 'Atur semester aktif.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/setting/semester',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_kelas',
				'nama' => 'Kelas',
				'deskripsi' => 'Data kelas dan wali kelas.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/kelas',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_pelajaran',
				'nama' => 'Pelajaran',
				'deskripsi' => 'Mata pelajaran sekolah.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/pelajaran',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_pengajaran',
				'nama' => 'Tugas Pengajaran',
				'deskripsi' => 'Pembagian mengajar guru.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/pengajaran',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_jadwal',
				'nama' => 'Jadwal Pelajaran',
				'deskripsi' => 'Atur jadwal pelajaran.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/jadwal',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_ekstra',
				'nama' => 'Ekstrakurikuler',
				'deskripsi' => 'Data dan pendaftaran ekstrakurikuler.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/extrakurikuler',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_kalender',
				'nama' => 'Kalender Akademik',
				'deskripsi' => 'Kalender kegiatan sekolah.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/calender',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_kkm',
				'nama' => 'Nilai KKM',
				'deskripsi' => 'Setting KKM mata pelajaran.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/nilaikkm',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_raport',
				'nama' => 'Setting Raport',
				'deskripsi' => 'Pengaturan cetak raport.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/raport/setting',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_kenaikan',
				'nama' => 'Kenaikan & Kelulusan',
				'deskripsi' => 'Proses kenaikan kelas dan kelulusan.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/raport/setkenaikanindex',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'admin_sms',
				'nama' => 'SMS Blasting',
				'deskripsi' => 'Kirim SMS massal ke orang tua.',
				'kategori' => 'Admin Sekolah',
				'url_guru' => 'admin/sms/sms',
				'url_siswa' => '',
				'roles' => array('admin sekolah')
			),
			array(
				'id' => 'super_sekolah',
				'nama' => 'Data Sekolah',
				'deskripsi' => 'Daftar dan aktivasi sekolah.',
				'kategori' => 'Super Admin',
				'url_guru' => 'superadmin/sekolah',
				'url_siswa' => '',
				'roles' => array('superadmin')
			),
			array(
				'id' => 'super_sms',
				'nama' => 'Nama Pengirim SMS',
				'deskripsi' => 'Sender name SMS sekolah.',
				'kategori' => 'Super Admin',
				'url_guru' => 'superadmin/sekolah/smssender',
				'url_siswa' => '',
				'roles' => array('superadmin')
			),
			array(
				'id' => 'super_akun',
				'nama' => 'Data Account',
				'deskripsi' => 'Akun super admin.',
				'kategori' => 'Super Admin',
				'url_guru' => 'superadmin/super/accountindex',
				'url_siswa' => '',
				'roles' => array('superadmin')
			),
			array(
				'id' => 'adminsb_artikel',
				'nama' => 'Konten Artikel',
				'deskripsi' => 'Artikel beranda Studentbook.',
				'kategori' => 'Admin Studentbook',
				'url_guru' => 'adminsb/artikel',
				'url_siswa' => '',
				'roles' => array('admin')
			),
			array(
				'id' => 'adminsb_home',
				'nama' => 'Home Control',
				'deskripsi' => 'Atur slide dan konten beranda.',
				'kategori' => 'Admin Studentbook',
				'url_guru' => 'adminsb/admin/homecontrol',
				'url_siswa' => '',
				'roles' => array('admin')
			),
			array(
				'id' => 'keuangan',
				'nama' => 'Keuangan',
				'deskripsi' => 'Module keuangan sekolah.',
				'kategori' => 'Keuangan',
				'url_guru' => 'keuangan/keuangan',
				'url_siswa' => '',
				'roles' => array('guru', 'admin sekolah')
			)
		);
	}
}

if ( ! function_exists('studentbook_module_role'))
{
	function studentbook_module_role()
	{
		$CI =& get_instance();
		$auth = $CI->session->userdata('user_authentication');
		if (empty($auth) || !is_array($auth))
		{
			return '';
		}

		if ( ! empty($auth['otoritas']))
		{
			return strtolower($auth['otoritas']);
		}

		$id_group = isset($auth['id_group']) ? (int) $auth['id_group'] : 0;
		$map = array(
			10 => 'superadmin',
			11 => 'admin sekolah',
			13 => 'guru',
			14 => 'ortu',
			16 => 'guru',
			30 => 'admin'
		);
		if (isset($map[$id_group]))
		{
			return $map[$id_group];
		}

		return '';
	}
}

if ( ! function_exists('daftar_module'))
{
	function daftar_module($role = null)
	{
		if ($role === null)
		{
			$role = studentbook_module_role();
		}
		$role = strtolower((string) $role);
		$siswa_like = ($role === 'siswa' || $role === 'ortu');

		$out = array();
		foreach (studentbook_module_catalog() as $modul)
		{
			if ( ! in_array($role, $modul['roles']))
			{
				continue;
			}
			$path = $siswa_like ? $modul['url_siswa'] : $modul['url_guru'];
			if ($path === '')
			{
				continue;
			}
			$modul['url'] = site_url($path);
			$out[] = $modul;
		}
		return $out;
	}
}

if ( ! function_exists('daftar_module_grouped'))
{
	function daftar_module_grouped($role = null)
	{
		$grouped = array();
		foreach (daftar_module($role) as $modul)
		{
			$grouped[$modul['kategori']][] = $modul;
		}
		return $grouped;
	}
}
