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
		$this->useSweetAlert2();

		echo view('admin/include/header');
		echo view('admin/include/navbar', $this->data);
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
					->withCustomJoin('(SELECT post_id, count(id) as comment_count FROM post_comment WHERE deleted_at is NULL GROUP BY post_id) as post_comment','post_comment','post_id','post.id')
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
					->withCustomJoin('(SELECT post_id, count(id) as comment_count FROM post_comment WHERE deleted_at is NULL GROUP BY post_id) as post_comment','post_comment','post_id','post.id')
					->withCustomJoin('(SELECT post_id, count(id) as likes_count FROM post_likes GROUP BY post_id) as post_likes','post_likes','post_id','post.id')
					->withCustomJoin("(SELECT post_id, count(id) as attach_count, GROUP_CONCAT(name SEPARATOR ',') as attachment FROM post_attachment GROUP BY post_id) as post_attachment",'post_attachment','post_id','post.id')
					->withOrderBy('created_at','DESC')
					->findAll($limit,$offset);
		}


		echo view('admin/home/_get_posts', $this->data);
	}

	public function get_post_count($user_id=null)	{
    $postModel = model('App\Models\PostModel');
		if ($user_id) {
			$count['post_count'] = $postModel->withWhere('user_id',$user_id)->countAllResults();
		} else {
			$count['post_count'] = $postModel->countAll();
		}

    echo json_encode($count);
  }

	public function delete_post($post_id=0){
		if ($this->request->getPost()&&$post_id!=0) {
			$go_delete = $this->request->getPost('delete');
			if ($go_delete) {
				$postModel = model('App\Models\PostModel');
				$post = $postModel->find($post_id);
				if ($post['user_id']!=$this->data['user_id']) {
					echo 'warning';
					return;
				} else {
					if ($postModel->delete($post_id)) {
						echo 'success';
						return;
					}
				}
			}
		}
	}


	public function delete_comment($comment_id=0){
		if ($this->request->getPost()&&$comment_id!=0) {
			$go_delete = $this->request->getPost('delete');
			if ($go_delete) {
				$postCommentModel = model('App\Models\PostCommentModel');
				$comment = $postCommentModel->find($comment_id);
				if ($comment['user_id']!=$this->data['user_id']) {
					echo 'warning';
					return;
				} else {
					if ($postCommentModel->delete($comment_id)) {
						echo 'success';
						return;
					}
				}
			}
		}
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

	public function read_notification($id=0){
		if ($this->request->getPost()&&$id!=0) {
			$go_read = $this->request->getPost('read');
			if ($go_read) {
				$notificationModel = model('App\Models\NotificationModel');
				$notification = $notificationModel->find($id);
				if ($notification['user_to']!=$this->data['user_id']) {
					echo 'warning';
					return;
				} else {
					$notifs = $notificationModel
						->withWhere('notification_type_id', $notification['notification_type_id'])
						->withWhere('user_to', $notification['user_to'])
						->withWhere('user_from', $notification['user_from'])
						->withWhere('post_id', $notification['post_id'])
						->withWhere('is_read', 0)
						->findAll();
					foreach ($notifs as $notif) {
						$notif['is_read'] = 1;
						$notificationModel->save($notif);
					}
					echo 'success';
					return;
				}
			}
		}
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
		echo view('admin/include/navbar', $this->data);
		echo view('admin/include/sidebar', $this->data);
		echo view('admin/home/users', $this->data);
		echo view('admin/include/footer');
	}

	public function user($id=0){

		$this->useSweetAlert2();

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
									'student_status.description as student_status','location.parent_id as parent_id','location.name as location_name',
									'parent_loc.name as parent_loc_name','user_follow.follow','followers.count as followers_count','following.count as following_count'])
		->withJoin('users','id','user_id')
		->withJoin('university','id','university_id')
		->withJoin('student_status','id','student_status_id')
		->withJoin('student_photo','user_id','user_id')
		->withJoin('location','id','location_id')
		->withCustomJoin('(SELECT * FROM user_follow WHERE user_id = '.$this->data['user_id'].') as user_follow','user_follow','follow','student.user_id')
		->withCustomJoin('(SELECT location.id,location.name FROM location) as parent_loc','parent_loc','id','location.parent_id')
		->withCustomJoin('(SELECT COUNT(id) as count, follow FROM user_follow GROUP BY follow) as followers','followers','follow','student.user_id')
		->withCustomJoin('(SELECT COUNT(id) as count, user_id FROM user_follow GROUP BY user_id) as following','following','user_id','student.user_id')
		->withWhere('student.user_id',$id)
		->first();

		echo view('admin/include/header');
		echo view('admin/include/navbar', $this->data);
		echo view('admin/include/sidebar', $this->data);
		echo view('admin/home/profile', $this->data);
		echo view('admin/include/footer');
	}

	public function post($post_id=0){
		if ($post_id==0) {
			return redirect()->to('/home/timeline');
		}

		$this->useSweetAlert2();

		$postModel = model('App\Models\PostModel');
		$postLikesModel = model('App\Models\PostLikesModel');
		$postAttachmentModel = model('App\Models\PostAttachmentModel');
		$postCommentModel = model('App\Models\PostCommentModel');

		$this->data['student'] = null;

		$this->data['posts'] = $postModel
				->withSelect(['post.*','users.fullname','student_photo.name as photo','post_comment.comment_count','post_likes.likes_count','post_attachment.attach_count','post_attachment.attachment'])
				->withJoin('users','id','user_id')
				->withJoin('student_photo','user_id','user_id')
				->withCustomJoin('(SELECT post_id, count(id) as comment_count FROM post_comment GROUP BY post_id) as post_comment','post_comment','post_id','post.id')
				->withCustomJoin('(SELECT post_id, count(id) as likes_count FROM post_likes GROUP BY post_id) as post_likes','post_likes','post_id','post.id')
				->withCustomJoin("(SELECT post_id, count(id) as attach_count, GROUP_CONCAT(name SEPARATOR ',') as attachment FROM post_attachment GROUP BY post_id) as post_attachment",'post_attachment','post_id','post.id')
				->withWhere('post.id',$post_id)
				->withOrderBy('created_at','DESC')
				->findAll();

		if (count($this->data['posts'])==0) {
			return redirect()->to('/home/timeline');
		}

		$this->data['comments'] = $postCommentModel
			->withSelect(['post_comment.*','users.fullname','student_photo.name as photo'])
			->withJoin('users','id','user_id')
			->withJoin('student_photo','user_id','user_id')
			->withWhere('post_id',$post_id)->findAll();

		echo view('admin/include/header');
		echo view('admin/include/navbar', $this->data);
		echo view('admin/include/sidebar', $this->data);
		echo view('admin/home/single_post', $this->data);
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
						$this->save_follow_user_notification($postId);
						echo $postId;
						return;
					}
				}
			} elseif($this->request->getPost()){
				$postData = $this->request->getPost();
				$postData['user_id'] =  $this->ionAuth->getUserId();
				$postId = $postModel->insert($postData);
				$this->save_follow_user_notification($postId);
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
				$comment = $postCommentModel
					->withSelect(['post_comment.*','post.user_id as user_to'])
					->withJoin('post','id','post_id')
					->find($commentId);
				$this->save_notification(2,$comment['user_to'],$comment['user_id'],$comment['post_id'],$comment['id']);
				$this->save_follow_post_notification(3,$comment['user_id'],$comment['post_id'],$comment['id']);
				$this->follow_post($this->data['user_id'], $comment['post_id']);
				$this->get_comment($commentId);
			}
		}
	}

	public function follow_user($user_id=0){
		if ($user_id==0) {
			return redirect()->to('/home/timeline');
		}
		if ($user_id==$this->data['user_id']) {
			return redirect()->to('/home/user/'.$user_id);
		}

		if ($this->request->getGet()) {
			$userFollowModel = model('App\Models\UserFollowModel');
			$follow = $this->request->getGet('follow');
			$data['user_id'] = $this->data['user_id'];
			$data['follow'] = $user_id;
			if ($follow=='1') {
				$userFollowModel->save($data);
				$this->save_notification(8,$user_id,$this->data['user_id']);
			} else {
				$rowFollow = $userFollowModel
					->withWhere('user_id', $this->data['user_id'])
					->withWhere('follow', $user_id)
					->first();
				$userFollowModel->delete($rowFollow['id']);
			}
		}

		return redirect()->to('/home/user/'.$user_id);
	}

	private function follow_post($user_id, $post_id){
		$postFollowModel = model('App\Models\PostFollowModel');
		$data = $postFollowModel
			->withWhere('user_id', $user_id)
			->withWhere('post_id', $post_id)
			->first();
		if (!$data) {
			$data = [];
			$data['user_id'] = $user_id;
			$data['post_id'] = $post_id;
			return $postFollowModel->save($data);
		}
	}

	private function save_notification($type, $to, $from, $post_id=null, $comment_id=null){
		if ($to!=$from) {
			$userModel = model('App\Models\UserModel');
			$user_from = $userModel->withSelect(['users.fullname','student_photo.name as photo'])
				->withJoin('student_photo','user_id','id')
				->withWhere('users.id', $from)
				->first();

			$notificationTypeModel = model('App\Models\NotificationTypeModel');
			$notifMessage = $notificationTypeModel->find($type);

			$pusher['message'] = vsprintf($notifMessage['content'], [$user_from['fullname']]);
			$pusher['photo'] = $user_from['photo'];
			$pusher['post_id'] = $post_id;
			$pusher['comment_id'] = $comment_id;
			$this->pusher->trigger('notification-channel-'.$to, $notifMessage['name'], $pusher);

			$notificationModel = model('App\Models\NotificationModel');
			$data['notification_type_id'] = $type;
			$data['user_to'] = $to;
			$data['user_from'] = $from;
			$data['post_id'] = $post_id;
			$data['comment_id'] = $comment_id;
			return $notificationModel->save($data);
		}
	}

	private function save_follow_user_notification($post_id){
		$userModel = model('App\Models\UserModel');
		$userFollowModel = model('App\Models\UserFollowModel');
		$notificationModel = model('App\Models\NotificationModel');

		if ($this->data['user_id']==1) {
			$tos = $userModel
				->withSelect(['id as user_id'])
				->withWhere('id !=', 1)
				->findAll();
		} else {
			$tos = $userFollowModel
				->withWhere('follow', $this->data['user_id'])
				->findAll();
		}

			if ($tos) {
				$dataBatch = [];
				foreach ($tos as $to) {
					$user_from = $userModel->withSelect(['users.fullname','student_photo.name as photo'])
						->withJoin('student_photo','user_id','id')
						->withWhere('users.id', $this->data['user_id'])
						->first();

					$notificationTypeModel = model('App\Models\NotificationTypeModel');
					$notifMessage = $notificationTypeModel->find(1);

					$pusher['message'] = vsprintf($notifMessage['content'], [$user_from['fullname']]);
					$pusher['photo'] = $user_from['photo'];
					$pusher['post_id'] = $post_id;
					$this->pusher->trigger('notification-channel-'.$to['user_id'], $notifMessage['name'], $pusher);

					$data['notification_type_id'] = 1;
					$data['user_to'] = $to['user_id'];
					$data['user_from'] = $this->data['user_id'];
					$data['post_id'] = $post_id;
					$data['created_at'] = date("Y-m-d H:i:s");
					$dataBatch[] = $data;
				}
				return $notificationModel->insertBatch($dataBatch);
			}
	}

	private function save_follow_post_notification($type, $from, $post_id=null, $comment_id=null){
		$postFollowModel = model('App\Models\PostFollowModel');
		$notificationModel = model('App\Models\NotificationModel');

		$tos = $postFollowModel
			->withWhere('post_id', $post_id)
			->withWhere('user_id !=', $this->data['user_id'])
			->findAll();

		if ($tos) {
			$dataBatch = [];
			foreach ($tos as $to) {
				$userModel = model('App\Models\UserModel');
				$user_from = $userModel->withSelect(['users.fullname','student_photo.name as photo'])
					->withJoin('student_photo','user_id','id')
					->withWhere('users.id', $this->data['user_id'])
					->first();

				$notificationTypeModel = model('App\Models\NotificationTypeModel');
				$notifMessage = $notificationTypeModel->find($type);

				$pusher['message'] = vsprintf($notifMessage['content'], [$user_from['fullname']]);
				$pusher['photo'] = $user_from['photo'];
				$pusher['post_id'] = $post_id;
				$pusher['comment_id'] = $comment_id;
				$this->pusher->trigger('notification-channel-'.$to['user_id'], $notifMessage['name'], $pusher);

				$data['notification_type_id'] = $type;
				$data['user_to'] = $to['user_id'];
				$data['user_from'] = $from;
				$data['post_id'] = $post_id;
				$data['comment_id'] = $comment_id;
				$data['created_at'] = date("Y-m-d H:i:s");
				$dataBatch[] = $data;
			}
			return $notificationModel->insertBatch($dataBatch);
		}
	}

}
