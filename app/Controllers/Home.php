<?php namespace App\Controllers;

class Home extends IonAuthController
{
	public function index()
	{
		return redirect()->to('/home/timeline');
	}

	public function timeline(){
		$this->useDropzone();
		$this->useImageCompressor();

		echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar', $this->data);
		echo view('admin/home/timeline', $this->data);
		echo view('admin/include/footer');
	}

	public function get_posts($limit=10, $offset=0, $user_id=0){
		$postModel = model('App\Models\PostModel');
		$postLikesModel = model('App\Models\PostLikesModel');
		$postAttachmentModel = model('App\Models\PostAttachmentModel');
		$postCommentModel = model('App\Models\PostCommentModel');

		$this->useDropzone();
		$this->useImageCompressor();

		if (!$user_id==0) {
			$this->data['posts'] = $postModel
					->withSelect(['post.*','users.fullname','student_photo.name as photo','post_comment.comment_count','post_likes.likes_count','post_attachment.attach_count','post_attachment.attachment'])
					->withJoin('users','id','user_id')
					->withJoin('student_photo','user_id','user_id')
					->withCustomJoin('(SELECT post_id, count(id) as comment_count FROM post_comment GROUP BY post_id) as post_comment','post_comment','post_id','post.id')
					->withCustomJoin('(SELECT post_id, count(id) as likes_count FROM post_likes GROUP BY post_id) as post_likes','post_likes','post_id','post.id')
					->withCustomJoin("(SELECT post_id, count(id) as attach_count, GROUP_CONCAT(name SEPARATOR ',') as attachment FROM post_attachment GROUP BY post_id) as post_attachment",'post_attachment','post_id','post.id')
					->withWhere('post.user_id', $user_id)
					->withOrderBy('created_at','DESC')
					->findAll($limit,$offset);
		} else {
			$this->data['posts'] = $postModel
					->withSelect(['post.*','users.fullname','student_photo.name as photo','post_comment.comment_count','post_likes.likes_count','post_attachment.attach_count','post_attachment.attachment'])
					->withJoin('users','id','user_id')
					->withJoin('student_photo','user_id','user_id')
					->withCustomJoin('(SELECT post_id, count(id) as comment_count FROM post_comment GROUP BY post_id) as post_comment','post_comment','post_id','post.id')
					->withCustomJoin('(SELECT post_id, count(id) as likes_count FROM post_likes GROUP BY post_id) as post_likes','post_likes','post_id','post.id')
					->withCustomJoin("(SELECT post_id, count(id) as attach_count, GROUP_CONCAT(name SEPARATOR ',') as attachment FROM post_attachment GROUP BY post_id) as post_attachment",'post_attachment','post_id','post.id')
					->withOrderBy('created_at','DESC')
					->findAll($limit,$offset);
		}


		echo view('admin/home/_get_posts', $this->data);
	}

	public function get_comments($post_id=0){
		$postCommentModel = model('App\Models\PostCommentModel');

		$this->data['comments'] = $postCommentModel
			->withSelect(['post_comment.*','users.fullname','student_photo.name as photo'])
			->withJoin('users','id','user_id')
			->withJoin('student_photo','user_id','user_id')
			->withWhere('post_id',$post_id)->findAll();

		if(empty($this->data['comments']))
			echo 'empty';
		else
			echo view('admin/home/_get_comments', $this->data);
	}

	public function get_comment($comment_id=0){
		$postCommentModel = model('App\Models\PostCommentModel');

		$this->data['comments'] = $postCommentModel
			->withSelect(['post_comment.*','users.fullname','student_photo.name as photo'])
			->withJoin('users','id','user_id')
			->withJoin('student_photo','user_id','user_id')
			->withWhere('post_comment.id',$comment_id)->findAll(1);

		echo view('admin/home/_get_comments', $this->data);
	}

	public function users(){
		$studentModel = model('App\Models\StudentModel');
    $universityModel = model('App\Models\UniversityModel');
    $locationModel = model('App\Models\LocationModel');

		$this->useSelect2('select2');

		$this->data['universities'] = $universityModel->findAll();
		$this->data['locations'] = $locationModel
			->withSelect(['location.*','parent_loc.name as parent_loc_name'])
			->withCustomJoin('(SELECT location.id,location.name FROM location) as parent_loc','parent_loc','id','location.parent_id')
			->withWhere('level',3)
			->withOrderBy('parent_loc_name','DESC')->findAll();



		$nofilter = false;
		if ($this->request->getGet()) {
			$location_id = $this->request->getGet('location_id');
			$university_id = $this->request->getGet('university_id');
			if ($university_id && $university_id!='') {
				$this->data['students'] = $studentModel
				->withSelect(['student.*','users.fullname','users.nickname','users.email','student_photo.name as photo','university.name as university_name',
											'student_status.description as student_status','location.parent_id as parent_id','location.name as location_name','parent_loc.name as parent_loc_name'])
				->withJoin('users','id','user_id')
				->withJoin('university','id','university_id')
				->withJoin('student_status','id','student_status_id')
				->withJoin('student_photo','user_id','user_id')
				->withJoin('location','id','location_id')
				->withCustomJoin('(SELECT location.id,location.name FROM location) as parent_loc','parent_loc','id','location.parent_id')
				->withWhere('university_id',$university_id)
				->findAll();
				$this->data['university_id'] = $university_id;
			} elseif ($location_id && $location_id!=''){
				$this->data['students'] = $studentModel
				->withSelect(['student.*','users.fullname','users.nickname','users.email','student_photo.name as photo','university.name as university_name',
											'student_status.description as student_status','location.parent_id as parent_id','location.name as location_name','parent_loc.name as parent_loc_name'])
				->withJoin('users','id','user_id')
				->withJoin('university','id','university_id')
				->withJoin('student_status','id','student_status_id')
				->withJoin('student_photo','user_id','user_id')
				->withJoin('location','id','location_id')
				->withCustomJoin('(SELECT location.id,location.name FROM location) as parent_loc','parent_loc','id','location.parent_id')
				->withWhere('location_id',$location_id)
				->findAll();
				$this->data['location_id'] = $location_id;
			} else {
				$nofilter = true;
			}

		} else {
			$nofilter = true;
		}

		if ($nofilter) {
			$this->data['students'] = $studentModel
			->withSelect(['student.*','users.fullname','users.nickname','users.email','student_photo.name as photo','university.name as university_name',
										'student_status.description as student_status','location.parent_id as parent_id','location.name as location_name','parent_loc.name as parent_loc_name'])
			->withJoin('users','id','user_id')
			->withJoin('university','id','university_id')
			->withJoin('student_status','id','student_status_id')
			->withJoin('student_photo','user_id','user_id')
			->withJoin('location','id','location_id')
			->withCustomJoin('(SELECT location.id,location.name FROM location) as parent_loc','parent_loc','id','location.parent_id')
			->findAll();
		}

		echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar', $this->data);
		echo view('admin/home/users', $this->data);
		echo view('admin/include/footer');
	}

	public function user($id=0){
		if ($id==0) {
			$id = $this->ionAuth->getUserId();
		}

		$postModel = model('App\Models\PostModel');
		$postLikesModel = model('App\Models\PostLikesModel');
		$postAttachmentModel = model('App\Models\PostAttachmentModel');
		$postCommentModel = model('App\Models\PostCommentModel');

		$studentModel = model('App\Models\StudentModel');
    $userModel = model('App\Models\UserModel');
    $universityModel = model('App\Models\UniversityModel');
    $studentStatusModel = model('App\Models\StudentStatusModel');

		$this->data['student'] = $studentModel
		->withSelect(['student.*','users.fullname','users.nickname','users.email','student_photo.name as photo','university.name as university_name',
									'student_status.description as student_status','location.parent_id as parent_id','location.name as location_name','parent_loc.name as parent_loc_name'])
		->withJoin('users','id','user_id')
		->withJoin('university','id','university_id')
		->withJoin('student_status','id','student_status_id')
		->withJoin('student_photo','user_id','user_id')
		->withJoin('location','id','location_id')
		->withCustomJoin('(SELECT location.id,location.name FROM location) as parent_loc','parent_loc','id','location.parent_id')
		->withWhere('student.user_id',$id)
		->first();


		$this->data['posts'] = $postModel
				->withSelect(['post.*','users.fullname','student_photo.name as photo','post_comment.comment_count','post_likes.likes_count','post_attachment.attach_count','post_attachment.attachment'])
				->withJoin('users','id','user_id')
				->withJoin('student_photo','user_id','user_id')
				->withCustomJoin('(SELECT post_id, count(id) as comment_count FROM post_comment GROUP BY post_id) as post_comment','post_comment','post_id','post.id')
				->withCustomJoin('(SELECT post_id, count(id) as likes_count FROM post_likes GROUP BY post_id) as post_likes','post_likes','post_id','post.id')
				->withCustomJoin("(SELECT post_id, count(id) as attach_count, GROUP_CONCAT(name SEPARATOR ',') as attachment FROM post_attachment GROUP BY post_id) as post_attachment",'post_attachment','post_id','post.id')
				->withWhere('post.user_id',$id)
				->withOrderBy('created_at','DESC')
				->findAll(10);

		echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar', $this->data);
		echo view('admin/home/profile', $this->data);
		echo view('admin/include/footer');
	}

	public function add_post(){
		if ($this->data['is_active']) {
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
		}

		echo 0;

	}

	public function add_comment(){
		if ($this->data['is_active']) {
			$postCommentModel = model('App\Models\PostCommentModel');
			if ($this->request->getPost()) {
				$postData = $this->request->getPost();
				$postData['user_id'] =  $this->ionAuth->getUserId();
				$commentId = $postCommentModel->insert($postData);
				$this->get_comment($commentId);
			}
		}
	}

}
