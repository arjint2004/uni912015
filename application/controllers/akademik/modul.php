<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modul extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('global');
		$this->load->helper('akademik');
		$this->load->helper('module');
		$this->load->library('session');
		$this->load->library('auth');
		$this->auth->logged_in();
	}

	public function index()
	{
		$role = studentbook_module_role();
		$admin_roles = array('admin sekolah', 'superadmin', 'admin');
		$data['role'] = $role;
		$data['modules'] = daftar_module($role);
		$data['grouped'] = daftar_module_grouped($role);
		$data['show_profile'] = ! in_array($role, $admin_roles);
		$data['page_title'] = 'Tampilan Module';
		$data['main'] = 'akademik/modul/index';
		if (in_array($role, $admin_roles))
		{
			$this->load->view('layout/ad_adminsekolah', $data);
		}
		else
		{
			$this->load->view('layout/ak_default', $data);
		}
	}
}
