<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model(['transaction_m','item_m','stock_m','menu_m']);
	}

	public function index()
	{
		$data['order'] = $this->transaction_m->getOrder();
		$data['totalCarts'] = $this->transaction_m->jumlahCarts();
		$this->template->load('template', 'transaction/transaction/transaction_data', $data);
	}
	public function invoice($kode_unik)
	{
		$data['invoice'] = $this->transaction_m->getInvoice($kode_unik);
		$this->template->load('template', 'transaction/history/invoice',$data);
	}
	public function history()
	{
		$data['history'] = $this->transaction_m->getHistory();
		$this->template->load('template', 'transaction/history/history_data', $data);
	}
	public function moveOrder()
	{
		$user_id = $this->input->post('user_id');
		$keterangan = $this->input->post('keterangan');

		$kode_unik = rand(111111, 999999);
		$kode_unik2 = rand(111111,999999);
		$finalkodeunik = $kode_unik.$kode_unik2;

		$params = array(
			'user_id' => $user_id,
			'keterangan' => $keterangan,
			'carts_barcode' => $finalkodeunik,
		);
		$this->transaction_m->inputTransaction($params, 'order');
		$this->transaction_m->updateCarts($finalkodeunik);
		$this->transaction_m->updateStatus();
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('success', 'Pesanan anda telah kami terima, silahkan tunggu');
		}
		redirect('order');

	}
	public function checkout()
	{
		$data['product'] = $this->item_m->get();
		$data['carts'] = $this->transaction_m->getCarts();
		$data['totalCarts'] = $this->transaction_m->jumlahCarts();
		$this->template->load('template', 'transaction/checkout/checkout', $data);
	}
	public function cartStore()
	{
		$harga = $this->menu_m->getMenu()->row()->harga;
		$menu_id = $this->input->post('menu_id');
		$jumlah = $this->input->post('qty');
		$status = 1;
		$kode_unik = rand(111111, 999999);
		$kode_unik2 = rand(111111, 999999);
		$user_id = $this->input->post('user_id');

		$params = array(
			'menu_id' => $menu_id,
			'jumlah' => $jumlah,
			'sub_total' => $harga * $jumlah,
			'status' => $status,
			'kode_unik' => $kode_unik.$kode_unik2,
			'user_id' => $user_id
		);
		$this->transaction_m->inputTransaction($params, 'carts');
		redirect('order');
	}

}

/* End of file Transaction.php */
/* Location: ./application/controllers/Transaction.php */