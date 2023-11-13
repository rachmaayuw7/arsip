<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

	public function index()
	{
		$data['title'] = 'About';
		$this->render('about', $data);
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
