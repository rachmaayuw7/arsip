<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_surat');
		$this->load->model('m_kategori');
	}

	public function index()
	{
		$data['title'] = 'Arsip';
		$this->render('arsip', $data);
	}

	public function showData(){
		$judul = $this->input->post("namaSurat");
		$data['data'] = $this->m_surat->getSurat($judul);
		echo json_encode($data);
	}

	public function formSurat(){
		$data['title'] = 'Tambah Arsip Surat';
		$data['kategori'] = $this->m_kategori->getKategori("");
		$this->render('arsipSurat', $data);
	}

	public function saveSurat(){
		$timestamp = time();
		$formattedDate = date('Y-m-d H:i:s', $timestamp);
		$nomor = $this->input->post('nomorSurat');
		$id_ktg = $this->input->post('kategori');
		$judul = $this->input->post('judul');
		$file = $_FILES['fileUpload']['name'];

		$this->load->library('upload');

		$config['upload_path'] = './pdf/';
		$config['allowed_types'] = 'pdf';
		$config['max_size'] = 10240; // 10 MB
		$config['file_name'] = $timestamp . '_' . $file;

		$this->upload->initialize($config);

		if ($this->upload->do_upload('fileUpload')) {
			$uploadData = $this->upload->data();
			$uploadedFileName = $uploadData['file_name'];

			if (!$this->m_surat->insertSurat($nomor, $id_ktg, $judul, $uploadedFileName)) {
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
		} else {
			// Failed upload
			$data['icon'] = 'error';
			$data['value'] = 'Gagal!';
			$data['message'] = $this->upload->display_errors();
		}

		echo json_encode($data);

	}

	public function updateSurat(){
		$timestamp = time();
		$formattedDate = date('Y-m-d H:i:s', $timestamp);
		$id = $this->input->post('id_surat');
		$nomor = $this->input->post('nomorSurat');
		$id_ktg = $this->input->post('kategori');
		$judul = $this->input->post('judul');
		if(isset($_FILES['fileUpload'])){
			$file = $_FILES['fileUpload']['name'];
			//delete file di direktori
			$fileName = $this->m_surat->getNameFile($id);
			$filePath = './pdf/' . $fileName;
			if (file_exists($filePath)) {
				unlink($filePath); 
			}
			$this->load->library('upload');
			$config['upload_path'] = './pdf/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = 10240; // 10 MB
			$config['file_name'] = $timestamp . '_' . $file;
			$this->upload->initialize($config);
			if ($this->upload->do_upload('fileUpload')) {
				$uploadData = $this->upload->data();
				$uploadedFileName = $uploadData['file_name'];
				$data = array(
					'nomor_surat' => $nomor,
					'id_ktg' => $id_ktg,
					'judul' => $judul,
					'file' => $uploadedFileName,
					'update_at' => $formattedDate
				);
				if (!$this->m_surat->updateSurat($id, $data)) {
						// Successful insert
					$data['icon'] = 'success';
					$data['value'] = 'Berhasil!';
					$data['message'] = 'Sukses Update Data!';
				} else {
					// Failed insert
					$data['icon'] = 'error';
					$data['value'] = 'Gagal!';
					$data['message'] = 'Gagal Update Data!';
				}
			} else {
				$data['icon'] = 'error';
				$data['value'] = "Gagal!";
				$data['message'] = "Gagal Upload file di Direktori!";
			}
		} else {
			$file = "";
			$data = array(
				'nomor_surat' => $nomor,
				'id_ktg' => $id_ktg,
				'judul' => $judul,
				'update_at' => $formattedDate
			);
			if (!$this->m_surat->updateSurat($id, $data)) {
				// Successful insert
				$data['icon'] = 'success';
				$data['value'] = 'Berhasil!';
				$data['message'] = 'Sukses Update Data!';
			} else {
				// Failed insert
				$data['icon'] = 'error';
				$data['value'] = 'Gagal!';
				$data['message'] = 'Gagal Update Data!';
			}
		}
		echo json_encode($data);
	}

	function delSurat(){
		$id_surat = $this->input->post('id_surat');
		$fileName = $this->m_surat->getNameFile($id_surat);
		$filePath = './pdf/' . $fileName;
		if (file_exists($filePath)) {
			unlink($filePath); 
			if(!$this->m_surat->hapusSurat($id_surat)){
				$data['icon'] = 'success';
				$data['value'] = "Berhasil!";
				$data['message'] = "Sukses Hapus Data!";
			} else {
				$data['icon'] = 'error';
				$data['value'] = "Gagal!";
				$data['message'] = "Gagal Hapus Data!";
			}
		} else {
			$data['icon'] = 'error';
			$data['value'] = "Gagal!";
			$data['message'] = "Gagal Hapus File di Direktori!";
		}
		
		echo json_encode($data);
	}

	function getLihatSurat($id_surat){
		$data['detail'] = $this->m_surat->detailSurat($id_surat);
		$data['title'] = 'Detail Arsip';
		$this->render('arsipLihat', $data);
	}

	public function formEdit($id_surat){
		$data['detail'] = $this->m_surat->detailSurat($id_surat);
		$data['kategori'] = $this->m_kategori->getKategori("");
		$data['title'] = 'Edit Arsip';
		$this->render('arsipEdit', $data);
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
