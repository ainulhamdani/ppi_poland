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
        return $this->respond($data, 200);
			}
			else
			{
				return $this->respond(['error' => true, 'message' => 'Wrong username or password'], 401);
			}
    }
  }

}
