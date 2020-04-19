<?php namespace App\Controllers;

class Home extends IonAuthController
{
	public function index()
	{
		return redirect()->to('/home/timeline');
	}

	public function timeline(){
		echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar', $this->data);
		echo view('admin/timeline', $this->data);
		echo view('admin/include/footer');
	}

}
