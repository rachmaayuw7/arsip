<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_kategori');
	}

	public function index()
	{
		$data['title'] = 'Kategori';
		$this->render('kategori', $data);
	}

	public function formKategori(){
		$data['title'] = 'Tambah Kategori';
		$data['id'] = $this->m_kategori->getMaxID() + 1;
		$this->render('tambahKategori', $data);
	}

	public function simpanKtg(){
		$id = $this->input->post('id_ktg');
		$namaKtg = $this->input->post('nama_kategori');
		$keterangan = $this->input->post('keterangan');

		if(!$this->m_kategori->insertKtg($id, $namaKtg, $keterangan)){
			// Successful insert
			$data['icon'] = 'success';
			$data['value'] = 'Berhasil!';
			$data['message'] = 'Sukses Upload Data!';
		} else {
			// Failed insert
			$data['icon'] = 'error';
			$data['value'] = 'Gagal!';
			$data['message'] = 'Gagal Menyimpan Data!';
		}

		echo json_encode($data);
	}
	
	public function showData(){
		$nama = $this->input->post("nama_kategori");
		$data['data'] = $this->m_kategori->getKategori($nama);

		echo json_encode($data);
	}

	public function deleteKtg(){
		$id_ktg = $this->input->post('id_ktg');
		if(!$this->m_kategori->delKtg($id_ktg)){
			$data['icon'] = 'success';
			$data['value'] = 'Berhasil!';
			$data['message'] = 'Sukses Hapus Data!';
		} else {
			$data['icon'] = 'error';
			$data['value'] = 'Gagal!';
			$data['message'] = 'Gagal Menyimpan Data!';
		}
		echo json_encode($data);
	}

	public function editKtg($id){
		$data['title'] = "Edit Kategori";
		$data['value'] = $this->m_kategori->detailKtg($id);
		$this->render('editKategori', $data);
	}

	public function updateKtg(){
		$timestamp = time();  
        $formattedDate = date('Y-m-d H:i:s', $timestamp);
		$id = $this->input->post('id_ktg');
		$namaKtg = $this->input->post('nama_kategori');
		$keterangan = $this->input->post('keterangan');

		$data = array(
			'nama_kategori' => $namaKtg,
			'keterangan' => $keterangan,
			'update_at'	=> $formattedDate
		); 

		if(!$this->m_kategori->updateKtg($id, $data)){
			$data['icon'] = 'success';
			$data['value'] = 'Berhasil!';
			$data['message'] = 'Sukses Update Data!';
		} else {
			$data['icon'] = 'error';
			$data['value'] = 'Gagal!';
			$data['message'] = 'Gagal Update Data!';
		}
		echo json_encode($data);
	}

	public function render($content_view, $data = []) {
        $this->load->view('layouts/header', $data);
		$this->load->view('layouts/topbar');
		$this->load->view('layouts/navbar');
        $this->load->view($content_view, $data);
        $this->load->view('layouts/foot');
		$this->load->view('layouts/js');
    }
}
