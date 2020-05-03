<?php namespace App\Controllers\Api;

use App\Controllers\IonAuthController;
use CodeIgniter\API\ResponseTrait;
class Post extends IonAuthController
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

}
