<?php namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
class Api extends IonAuthController
{
	use ResponseTrait;

	public function get_post_count()
	{
    $postModel = model('App\Models\PostModel');
    $count = $postModel->withSelectCount('id','post_count')->first();
    echo json_encode($count);
  }

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
