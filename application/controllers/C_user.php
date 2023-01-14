<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_user extends CI_Controller {

	public function index()
	{
		$this->load->model('M_user');
		$data['user'] = $this->M_user->get_data();
		$this->load->view('T_user/V_navbar');
		$this->load->view('T_user/V_sidebar');
		$this->load->view('V_user',$data);
		$this->load->view('T_user/V_footer');
	}
	public function tambahData()
	{

		$this->load->view('V_tambahUser');
	}
	public function tambahDataAksi()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
 
		$data = array(
			'username' => $username,
			'password' => $password
			);
		$this->load->model('M_user');
		$this->M_user->tambahData($data,'user');
		redirect('C_user/index');
	}
	public function ambilDataById()
	{
		$this->load->model('M_user');
		$data['user'] = $this->M_user->ambilDataById($id);

	}
	public function editData($id)
	{
		$this->load->model('M_user');
		$data['user'] = $this->M_user->ambilDataById($id);
		$this->load->view('V_editUser',$data);
	}
	public function editDataAksi()
	{
		$id = $this->input->post('id');
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
 
		$data = array(
			'username' => $username,
			'password' => $password
			);
		$this->load->model('M_user');
		$this->M_user->editData($id,$data);
		redirect('C_user/index');
	}
	public function hapusData($id)
	{
		$this->load->model('M_user');
		$this->M_user->hapusData($id);
		redirect('C_user/index');
	}
}

