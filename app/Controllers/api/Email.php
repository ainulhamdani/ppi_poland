<?php namespace App\Controllers;

use App\Controllers\IonAuthController;
use CodeIgniter\API\ResponseTrait;
class Email extends IonAuthController
{
	use ResponseTrait;

	public function check_email(){
		if ($this->request->getGet()){
			$userModel = model('App\Models\UserModel');
			$email    = strtolower($this->request->getGet('email'));
			if($userModel->withSelect('id')->withWhere('email', $email)->first()){
				// echo 'exist';
				return $this->respond(['exist'=> true]);
			} else {
				return $this->respond(['exist'=> false]);
			}
		}
		return $this->respond(['exist'=> false]);
	}

}
