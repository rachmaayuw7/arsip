<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 */
	public function index()
	{
		$data['title'] = 'Dashboard';
		$this->render('arsip', $data);
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
