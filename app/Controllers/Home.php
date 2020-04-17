<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		if (!$this->session->get('username')) {
			return redirect()->to('/login'); 
		}
		echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar');
		echo view('admin/index');
		echo view('admin/include/footer');
	}

	//--------------------------------------------------------------------

}
