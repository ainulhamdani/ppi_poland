<?php namespace App\Controllers;

class Auth extends IonAuthController
{
	public function index()
	{
		if ($this->ionAuth->loggedIn()) {
			if ($this->ionAuth->isAdmin($this->ionAuth->getUserId())) {
				return redirect()->to('/admin');
			} else {
				return redirect()->to('/');
			}
		}

		echo view('admin/login');
	}

	public function register(){
		if ($this->ionAuth->loggedIn()) {
			return redirect()->to('/');
		}

		echo view('admin/register');
	}

	public function authenticate(){

		if ($this->request->getPost())
		{

			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->request->getVar('remember');

			if ($this->ionAuth->login($this->request->getVar('username'), $this->request->getVar('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				return redirect()->to('/auth');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				// use redirects instead of loading views for compatibility with MY_Controller libraries
				return redirect()->back()->withInput();
			}
		} else {
			echo view('admin/login',$this->data);
		}
	}

	public function logout(){
		$this->ionAuth->logout();

		// redirect them to the login page
		// $this->session->setFlashdata('message', $this->ionAuth->messages());
		return redirect()->to('/auth');
	}

	public function do_register(){
		$tables                        = $this->configIonAuth->tables;
		$identityColumn                = $this->configIonAuth->identity;
		$this->data['identity_column'] = $identityColumn;

		if ($this->request->getPost())
		{
			$email    = strtolower($this->request->getPost('email'));
			$identity = ($identityColumn === 'email') ? $email : $this->request->getPost('identity');
			$password = $this->request->getPost('password');

			$additionalData = [
				'fullname' => $this->request->getPost('fullname'),
				'nickname'  => $this->request->getPost('nickname'),
			];
		}
		if ($this->request->getPost() && $id = $this->ionAuth->register($identity, $password, $email, $additionalData))
		{
			$studentModel = model('App\Models\StudentModel');
			$student = ['user_id' => $id];
			$studentModel->save($student);
			// $this->session->setFlashdata('message', $this->ionAuth->messages());
			return redirect()->to('/auth');
		}else{
			return redirect()->to('/auth/register');
		}
	}
}
