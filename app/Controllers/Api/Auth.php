<?php namespace App\Controllers\Api;

use Firebase\JWT\JWT;
use App\Controllers\IonAuthController;
use CodeIgniter\API\ResponseTrait;
use Config\JWTConfig;
class Auth extends IonAuthController
{
	use ResponseTrait;

	public function authenticate() {
    if ($this->request->getPost()) {
      if ($this->ionAuth->login($this->request->getVar('username'), $this->request->getVar('password'), false))
			{
				$token = bin2hex(random_bytes(64));

        $payload = [
          'iss' => base_url(),
          "iat" => now(),
          'user_id' => $this->ionAuth->getUserId(),
					'token' => $token,
        ];

				$jwtData = [
					'user_id' => $this->ionAuth->getUserId(),
					'user_agent' => $this->request->getServer('HTTP_USER_AGENT'),
					'ip_address' => $this->request->getServer('REMOTE_ADDR'),
					'iat' => now(),
					'token' => $token,
				];

				$userJwtModel = model('App\Models\UserJwtModel');
				$userJwtModel->save($jwtData);

        $jwt = JWT::encode($payload, JWTConfig::$KEY);
        $data = ['message' => 'Access granted', 'token' => $jwt];
				$this->ionAuth->logout();
        return $this->respond($data, 200);
			}
			else
			{
				return $this->respond(['error' => true, 'message' => 'Wrong username or password'], 401);
			}
    }
		return $this->respond(['error' => true, 'message' => 'Missing username or password'], 400);
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
			$send['send_email'] = true;
			$send['email'] = $email;
			$send['name'] = $additionalData['nickname'];
			$send['id'] = $data['id'];
			$send['activation_code'] = $data['activation'];
			$this->_send_email($send['email'], view('admin/email/verify', $send), 'Verify your account');
			return $this->response->setJSON(['success'=> true]);
		}else{
			$this->response->setStatusCode(400, 'Bad Request');
			return $this->response->setJSON(['redirect' => 'register']);
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
					$this->_send_email($forgotten['identity'], view('admin/email/forgot_password', $forgotten), 'Request new password');
					return $this->response->setJSON(['success'=> true]);
				}
				else
				{
					$this->response->setStatusCode(400, 'Bad Request');
					return $this->response->setJSON(['redirect' => 'forgot_password']);
				}
			}
		}

		$this->response->setStatusCode(400, 'Bad Request');
		return $this->response->setJSON(['redirect' => 'forgot_password']);
	}

	public function user_data(){
		if (isset($this->request->user)) {
			$userModel = model('App\Models\UserModel');
			$user = $userModel
				->withSelect(['users.id','users.email','users.active','users.nickname','users.fullname','student_photo.name as photo'])
				->withJoin('student_photo','user_id','id')
				->withWhere('users.id', $this->request->user->user_id)
				->first();
			return $this->response->setJSON($user);
		} else {
			return $this->response->setStatusCode(403, 'Not authenticate');
		}
	}

	public function logout(){
		if (isset($this->request->user)) {
			$userJwtModel = model('App\Models\UserJwtModel');
			$jwt = $userJwtModel
				->withWhere('user_id', $this->request->user->user_id)
				->withWhere('token', $this->request->user->token)
				->first();

			if($jwt)
				$userJwtModel->delete($jwt['id']);
		}

		return $this->response->setJSON(['success'=> true]);
	}

	private function _send_email($to, $content, $subject){
		$emailModel = model('App\Models\MailSettingModel');
		$mailSettings = $emailModel->first();

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
