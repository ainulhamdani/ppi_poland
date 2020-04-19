<?php namespace App\Controllers;

class Profile extends IonAuthController
{
	public function index()
	{
    return redirect()->to('/profile/general');
  }

  public function general(){
    echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_profile', $this->data);
		echo view('admin/profile/general');
		echo view('admin/include/footer');
  }

  public function university(){
    echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_profile', $this->data);
		echo view('admin/profile/university');
		echo view('admin/include/footer');
  }

}
