<?php namespace App\Controllers;

class Home extends IonAuthController
{
	public function index()
	{
		return redirect()->to('/home/timeline');
	}

	public function timeline(){
		$postModel = model('App\Models\PostModel');
		$postLikesModel = model('App\Models\PostLikesModel');
		$postAttachmentModel = model('App\Models\PostAttachmentModel');
		$postCommentModel = model('App\Models\PostCommentModel');

		$this->useDropzone();
		$this->useImageCompressor();

		$this->data['posts'] = $postModel
				->withSelect(['post.*','users.fullname','student_photo.name as photo','post_comment.comment_count','post_likes.likes_count','post_attachment.attach_count','post_attachment.attachment'])
				->withJoin('users','id','user_id')
				->withJoin('student_photo','user_id','user_id')
				->withCustomJoin('(SELECT post_id, count(id) as comment_count FROM post_comment GROUP BY post_id) as post_comment','post_comment','post_id','id')
				->withCustomJoin('(SELECT post_id, count(id) as likes_count FROM post_likes GROUP BY post_id) as post_likes','post_likes','post_id','id')
				->withCustomJoin("(SELECT post_id, count(id) as attach_count, GROUP_CONCAT(name SEPARATOR ',') as attachment FROM post_attachment GROUP BY post_id) as post_attachment",'post_attachment','post_id','id')
				->withOrderBy('created_at','DESC')
				->findAll(10);

		echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar', $this->data);
		echo view('admin/timeline', $this->data);
		echo view('admin/include/footer');
	}

	public function add_post(){
		$postModel = model('App\Models\PostModel');
		$postAttachmentModel = model('App\Models\PostAttachmentModel');

		if ($this->request->getFiles()) {
			$files = $this->request->getFileMultiple('post_photo');
			$postData = $this->request->getPost();
			$postData['user_id'] =  $this->ionAuth->getUserId();
			if ($files) {
				$postId = $postModel->insert($postData);
				if ($postId) {
					$path = ROOTPATH.'public/assets/uploads/posts/'.$postData['user_id'];
					if (!file_exists($path)) {
					    mkdir($path, 0755, true);
					}
					foreach ($files as $file) {
						$name = $file->getRandomName();
						$file = $file->move($path.'/', $name);
						$attachData['post_id'] = $postId;
						$attachData['name'] = $name;
						$postAttachmentModel->insert($attachData);
					}
					echo $postId;
					return;
				}
			}
		} elseif($this->request->getPost()){
			$postData = $this->request->getPost();
			$postData['user_id'] =  $this->ionAuth->getUserId();
			$postId = $postModel->insert($postData);
			echo $postId;
			return;
		}

		echo 0;

	}

}
