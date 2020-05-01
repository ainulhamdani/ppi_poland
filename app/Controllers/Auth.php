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
		$this->data['message'] = $this->session->getFlashdata('message');

		echo view('admin/login',	$this->data);
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
				$this->session->setFlashdata('message', $this->ionAuth->getErrors());
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

		if ($this->request->getPost() && $data = $this->ionAuth->register($identity, $password, $email, $additionalData))
		{
			$studentModel = model('App\Models\StudentModel');
			$student = ['user_id' => $data['id']];
			$studentModel->save($student);
			$this->session->setFlashdata(['send_email'=> true, 'email' => $email, 'name' => $additionalData['nickname'], 'id' => $data['id'], 'activation_code' => $data['activation']]);
			// $this->session->setFlashdata('message', $this->ionAuth->messages());
			return redirect()->to('/auth/registration_success');
		}else{
			return redirect()->to('/auth/register');
		}
	}

	public function confirmation(){
		if ($this->request->getGet())	{
			$code = explode('-',$this->request->getGet('confirmation_token'));
			$id = $code[1];
			$code = $code[0];

			$activation = $this->ionAuth->activate($id, $code);

			if ($activation)
			{
				// redirect them to the auth page
				// $this->session->setFlashdata('message', $this->ionAuth->messages());
				return redirect()->to('/auth/activation_success');
			}
			else
			{
				// redirect them to the forgot password page
				// $this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				return redirect()->to('/auth/forgot_password');
			}

		}
		else {
			return redirect()->to('/auth');
		}
	}

	public function forgot_password(){
		if ($this->request->getPost())	{
			$identityColumn = $this->configIonAuth->identity;
			$user = $this->ionAuth->where($identityColumn, $this->request->getPost('identity'))->users()->row();

			if (!empty($user)){
				$forgotten = $this->ionAuth->forgottenPassword($user->{$this->configIonAuth->identity});

				if ($forgotten)
				{
					// if there were no errors
					echo view('admin/request_new_password_success');
					ob_end_flush();

					$this->_send_email($forgotten['identity'], view('admin/email/forgot_password', $forgotten), 'Request new password');
					return;
				}
				else
				{
					// $this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
					return redirect()->to('/auth/forgot_password');
				}
			}

		}

		echo view('admin/forgot_password');
	}

	public function reset_password(){
		if ($this->request->getGet())	{
			$code = $this->request->getGet('confirmation_token');
			$user = $this->ionAuth->forgottenPasswordCheck($code);

			if ($user) {
				if (! $this->request->getPost())	{
					$data['code'] = $code;
					$data['user_id'] = $user->id;
					echo view('admin/reset_password',$data);
				}
				else {
					$identity = $user->{$this->configIonAuth->identity};

					// do we have a valid request?
					if ($user->id != $this->request->getPost('user_id'))
					{
						// something fishy might be up
						$this->ionAuth->clearForgottenPasswordCode($identity);

						throw new \Exception(lang('Auth.error_security'));
					}
					else
					{
						// finally change the password
						$change = $this->ionAuth->resetPassword($identity, $this->request->getPost('password2'));

						if ($change)
						{
							// if the password was successfully changed
							// $this->session->setFlashdata('message', $this->ionAuth->messages());
							return redirect()->to('/auth/reset_password_success');
						}
						else
						{
							return redirect()->to('/auth/reset_password?confirmation_token=' . $code);
						}
					}
				}

			}

		}
		else {
			return redirect()->to('/auth');
		}
	}

	public function reset_password_success(){
		echo view('admin/reset_success');
	}

	public function activation_success(){
		echo view('admin/activation_success');
	}

	public function registration_success(){
		echo view('admin/registration_success');
		ob_end_flush();

		$data = $this->session->getFlashdata();
		if (!empty($data)) {
			if ($data['send_email']) {
				$this->_send_email($data['email'], view('admin/email/verify', $data), 'Verify your account');
			}
		}
	}

	public function check_email(){
		if ($this->request->getGet()){
			$userModel = model('App\Models\UserModel');
			$email    = strtolower($this->request->getGet('email'));
			if($userModel->withSelect('id')->withWhere('email', $email)->first()){
				echo json_encode(['exist'=> true]);
				return;
			} else {
				echo json_encode(['exist'=> false]);
				return;
			}
		}
		echo json_encode(['exist'=> false]);
	}

	public function _send_email($to, $content, $subject){
		$emailModel = model('App\Models\MailSettingModel');
		$mailSettings = $emailModel->first();
		// var_dump($mailSettings);

		$config['protocol'] = 'smtp';
		$config['SMTPHost'] = $mailSettings['SMTP_host'];
		$config['SMTPUser'] = $mailSettings['SMTP_user'];
		$config['SMTPPass'] = $mailSettings['SMTP_pass'];
		$config['SMTPCrypto'] = $mailSettings['SMTP_crypto'];
		$config['SMTPPort'] = $mailSettings['SMTP_port'];
		$config['mailType'] = 'html';

		$email = \Config\Services::email();
		$email->initialize($config);

		$email->setFrom($mailSettings['SMTP_user'], $mailSettings['name']);
		$email->setTo($to);

		$email->setSubject('PPI Poland | '.$subject);
		$email->setMessage($content);

		$email->send();
	}
}
