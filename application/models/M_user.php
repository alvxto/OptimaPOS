<?php

class M_user extends CI_Model {
	public function get_data ()
	{
		return $this->db->get('user')->result_array();
	}
	public function tambahData($data)
	{
		$this->db->insert('user',$data);
	}
	public function ambilDataByid($id)
	{
		$this->db->select("*");
        $this->db->from("user");
        $this->db->where('id_user', $id);
        
        return $this->db->get()->result_array();
	}
	public function editData($id,$data)
	{
		$this->db->where('id_user', $id);
		$this->db->update('user',$data);
	}
	public function hapusData($id)
	{
		$this->db->delete('user', array('id_user' => $id));
	}
}
