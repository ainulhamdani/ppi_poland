<?php namespace App\Controllers\Api;

use App\Controllers\IonAuthController;
use CodeIgniter\API\ResponseTrait;
class Profile extends IonAuthController
{
	use ResponseTrait;

  public function general(){
		$studentModel = model('App\Models\StudentModel');
		$data['student'] = $studentModel
		->withSelect(['student.*','users.fullname','users.nickname','users.email','university.name as university_name','student_status.description as student_status'])
		->withJoin('users','id','user_id')
		->withJoin('university','id','university_id')
		->withJoin('student_status','id','student_status_id')
		->withWhere('user_id',$this->request->user->user_id)
		->first();

    return $this->response->setJSON($data);
  }

	public function addtional_data(){
			$studentModel = model('App\Models\StudentModel');
	    $universityModel = model('App\Models\UniversityModel');
	    $studentStatusModel = model('App\Models\StudentStatusModel');
	    $locationModel = model('App\Models\LocationModel');

			$data['universities'] = $universityModel->findAll();
			$data['statuses'] = $studentStatusModel->findAll();
			$data['locations'] = $locationModel
				->withSelect(['location.*','parent_loc.name as parent_loc_name'])
				->withCustomJoin('(SELECT location.id,location.name FROM location) as parent_loc','parent_loc','id','location.parent_id')
				->withWhere('level',3)
				->withOrderBy('parent_loc_name','DESC')->findAll();

			$data['majors'] = $studentModel
				->withSelect(['major'])
				->withGroupBy('major')
				->findAll();
			return $this->response->setJSON($data);
	}

	public function save_profile(){
    $studentModel = model('App\Models\StudentModel');
    $userModel = model('App\Models\UserModel');

		if ($this->request->getPost()) {
			if ($studentModel->save($this->request->getPost()) !== false)
			{
					$postData = $this->request->getPost();
					$postData['id'] = $this->request->user->user_id;
					$userModel->save($postData);
          return $this->response->setJSON(['success' => true]);
			}
      return $this->response->setStatusCode(500, 'Server Error');
		}
    return $this->response->setStatusCode(400, 'Bad Request');
	}

  public function photo(){
		$studentModel = model('App\Models\StudentModel');
		$studentPhotoModel = model('App\Models\StudentPhotoModel');

		$this->data['student'] = $studentModel
		->withSelect(['student.*','student_photo.name as photo'])
		->withJoin('student_photo','user_id','user_id')
		->withWhere('student.user_id',$this->request->user->user_id)
		->first();

    return $this->response->setJSON($this->data['student']);
  }

  public function save_photo(){
		$studentModel = model('App\Models\StudentModel');
		$studentPhotoModel = model('App\Models\StudentPhotoModel');

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
					$fileData['user_id'] = $this->request->user->user_id;
					$fileData['name'] = $name;
					$check = $studentPhotoModel->save($fileData);
					return $this->response->setJSON(['success' => true, 'message' => $name]);
				} else {
					return $this->response->setJSON(['error' => true]);
				}
			} else {
				return $this->response->setStatusCode(400, 'File not exist');
			}
			return $this->response->setStatusCode(400, 'Bad Request');
		}
  }

}
