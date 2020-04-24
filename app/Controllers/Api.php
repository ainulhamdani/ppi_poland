<?php namespace App\Controllers;

class Api extends IonAuthController
{
	public function get_post_count()
	{
    $postModel = model('App\Models\PostModel');
    $count = $postModel->withSelectCount('id','post_count')->first();
    echo json_encode($count);
  }

}
