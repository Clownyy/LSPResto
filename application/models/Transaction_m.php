<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_m extends CI_Model {

	// public function sub_total()
	// {
	// 	$item_id = $this->input->post('item_id');
	// 	$harga = $this->db->select('price')->from('p_item')->where('item_id', $item_id);
	// 	$hargaSatuan = $this->db->get()->row()->price;
	// 	$jumlah = $this->input->post('jumlah');
	// 	$sub_total = $hargaSatuan * $jumlah;
	// }
	public function inputTransaction($data,$table)
	{
		$this->db->insert($table,$data);
	}
	public function getInvoice($kode_unik)
	{
		$this->db->select('checkout.*, p_item.name as item_name, p_item.barcode as barcode_item, p_item.price as harga_satuan, user.name as cashier');
		$this->db->from('checkout');
		$this->db->join('p_item', 'p_item.barcode = checkout.kode_unik');
		$this->db->join('user', 'user.user_id = checkout.user_id');
		$this->db->where('checkout.kode_unik', $kode_unik);
		$query = $this->db->get()->row();
		return $query;
	}
	public function getHistory()
	{
		$this->db->select('checkout.*, user.name as name');
		$this->db->from('checkout');
		$this->db->join('user', 'user.user_id = checkout.user_id');
		$query = $this->db->get();
		return $query;
	}
	public function getCarts()
	{
		$this->db->select('carts.*, menu.nama_menu as menu, menu.barcode as barcode_menu, menu.harga as harga, user.user_id as user_id');
		$this->db->from('carts');
		$this->db->join('menu', 'menu.id_menu = carts.menu_id');
		$this->db->join('user', 'user.user_id = carts.user_id');
		$this->db->where('status', 1);
		$this->db->where('carts.user_id', $this->session->userdata('userid'));
		$query = $this->db->get();
		return $query;
	}
	public function getOrder()
	{
		$this->db->select('order.*,')
	}
	public function jumlahCarts()
	{
		$this->db->select_sum('sub_total');
		$this->db->from('carts');
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('userid'));
		$query = $this->db->get()->row()->sub_total;
		return $query;
	}
	public function totalCarts($id)
	{
		$this->db->select('*');
		$this->db->from('carts');
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('userid'));
		$query = $this->db->count_all_results();
		return $query;
	}
	public function updateCarts($finalkodeunik)
	{
		$this->db->set('kode_unik', $finalkodeunik);
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('userid'));
		return $this->db->update('carts');
	}
	public function updateStatus()
	{
		$this->db->set('status', 0);
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('userid'));
		return $this->db->update('carts');
	}

}

/* End of file Transaction_m.php */
/* Location: ./application/models/Transaction_m.php */