<?php namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
class Api extends IonAuthController
{
	use ResponseTrait;

	public function get_post_count($user_id=null)
	{
    $postModel = model('App\Models\PostModel');
		if ($user_id) {
			$count['post_count'] = $postModel->withWhere('user_id',$user_id)->countAllResults();
		} else {
			$count['post_count'] = $postModel->countAll();
		}

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
