<?php namespace App\Controllers;

class Profile extends IonAuthController
{
	public function index()
	{
    return redirect()->to('/profile/photo');
  }

  public function general(){
		if ($this->data['is_admin']) {
			return redirect()->to('/profile/photo');
		}
		$studentModel = model('App\Models\StudentModel');
    $userModel = model('App\Models\UserModel');
    $universityModel = model('App\Models\UniversityModel');
    $studentStatusModel = model('App\Models\StudentStatusModel');
    $locationModel = model('App\Models\LocationModel');

		if ($this->request->getPost()) {
			// var_dump($this->request->getPost());exit;
			if ($studentModel->save($this->request->getPost()) !== false)
			{
					$postData = $this->request->getPost();
					$postData['id'] = $this->ionAuth->getUserId();
					$userModel->save($postData);
			}
		}

		$this->useSelect2('select2');

		$this->data['universities'] = $universityModel->findAll();
		$this->data['statuses'] = $studentStatusModel->findAll();
		$this->data['locations'] = $locationModel
			->withSelect(['location.*','parent_loc.name as parent_loc_name'])
			->withCustomJoin('(SELECT location.id,location.name FROM location) as parent_loc','parent_loc','id','parent_id')
			->withWhere('level',3)
			->withOrderBy('parent_loc_name','DESC')->findAll();

		$this->data['majors'] = $studentModel
			->withSelect(['major'])
			->withGroupBy('major')
			->findAll();
			
		$this->data['student'] = $studentModel
		->withSelect(['student.*','users.fullname','users.nickname','users.email','university.name as university_name','student_status.description as student_status'])
		->withJoin('users','id','user_id')
		->withJoin('university','id','university_id')
		->withJoin('student_status','id','student_status_id')
		->withWhere('user_id',$this->ionAuth->getUserId())
		->first();

		// var_dump($this->data['student']);exit;

    echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_profile', $this->data);
		echo view('admin/profile/general', $this->data);
		echo view('admin/include/footer');
  }

  public function photo(){
		$studentModel = model('App\Models\StudentModel');
		$studentPhotoModel = model('App\Models\StudentPhotoModel');

		$this->useImageCompressor();

		if ($this->request->getFiles()) {
			$file = $this->request->getFile('photo_profile');
			if ($file)
			{
        $name = $file->getRandomName();
        $file = $file->move(ROOTPATH.'public/assets/uploads/profile_pictures', $name);
				if ($file) {
					if ($this->request->getPost('id')) {
						$fileData['id'] = $this->request->getPost('id');
						$oldPhoto = $studentPhotoModel->find($fileData['id']);
						unlink(ROOTPATH.'public/assets/uploads/profile_pictures/'.$oldPhoto['name']);
					}
					$fileData['user_id'] = $this->ionAuth->getUserId();
					$fileData['name'] = $name;
					$check = $studentPhotoModel->save($fileData);
					echo 'success';
				} else {
					echo 'failed';
				}
			} else {
				echo 'file not exist';
			}
			return;
		}


		$this->data['student'] = $studentModel
		->withSelect(['student.*','student_photo.name as photo'])
		->withJoin('student_photo','user_id','user_id')
		->withWhere('student.user_id',$this->ionAuth->getUserId())
		->first();

    echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_profile', $this->data);
		echo view('admin/profile/photo', $this->data);
		echo view('admin/include/footer');
  }
}
