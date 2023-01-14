<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dashboard extends CI_Controller {

	public function index()
	{
		$this->load->view('T_dashboard/V_navbar');
		$this->load->view('T_dashboard/V_sidebar');
		$this->load->view('V_dashboard');
		$this->load->view('T_dashboard/V_footer');
	}
}
