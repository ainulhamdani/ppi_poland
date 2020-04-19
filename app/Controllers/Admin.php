<?php namespace App\Controllers;

class Admin extends IonAuthController
{
	public function index()
	{
		return redirect()->to('/admin/overview');
	}

	public function overview(){
		echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_admin', $this->data);
		echo view('admin/index');
		echo view('admin/include/footer');
	}

	public function university($mode="", $id=""){
    $universityModel = model('App\Models\UniversityModel');

    if ($mode == "add" || $mode == "edit") {
      if ($this->request->getPost()) {
        if ($universityModel->save($this->request->getPost()) !== false)
        {
            return redirect()->to('/admin/university');
        }
      }

      $this->data['mode'] = $mode;
      $this->data['id'] = $id;
      $this->data['university'] = [];
      if ($id!="") {
        $this->data['university'] = $universityModel->find($id);
      }

      $this->useSelect2('select2');

      $view = 'admin/add_university';
    } else {
      $this->useDataTables('university_table');

      $this->data['universities'] = $universityModel->findAll();
      $view = 'admin/university';
    }
    echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_admin', $this->data);
    echo view($view, $this->data);
		echo view('admin/include/footer');
	}

	public function student($mode="", $id=""){
    $studentModel = model('App\Models\StudentModel');
    $universityModel = model('App\Models\UniversityModel');
    $studentStatusModel = model('App\Models\StudentStatusModel');

    if ($mode == "add" || $mode == "edit") {
      if ($this->request->getPost()) {
        if ($studentModel->save($this->request->getPost()) !== false)
        {
            return redirect()->to('/admin/student');
        }
      }

      $this->data['mode'] = $mode;
      $this->data['id'] = $id;
      $this->data['student'] = [];
      if ($id!="") {
        $this->data['student'] = $studentModel
        ->withSelect(['student.*','users.fullname','users.email','university.name as university_name','student_status.description as student_status'])
        ->withJoin('users','id','user_id')
        ->withJoin('university','id','university_id')
        ->withJoin('student_status','id','student_status_id')
        ->find($id);
      }

      $this->useSelect2('select2');

      $this->data['universities'] = $universityModel->findAll();
      $this->data['statuses'] = $studentStatusModel->findAll();
      $view = 'admin/add_student';
    } else {
      $this->useDataTables('student_table');

      $this->data['students'] =
        $studentModel
          ->withSelect(['student.*','users.fullname','users.email','university.name as university_name','student_status.description as student_status'])
          ->withJoin('users','id','user_id')
          ->withJoin('university','id','university_id')
          ->withJoin('student_status','id','student_status_id')
          ->findAll();

      $view = 'admin/student';
    }
    echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_admin', $this->data);
    echo view($view, $this->data);
		echo view('admin/include/footer');
	}

}
