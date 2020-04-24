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

      $view = 'admin/admin/add_university';
    } elseif($mode == "delete"){
			if ($this->request->getPost()) {
				if($universityModel->delete($id)) {
					echo 'success';
				}
				return;
			} else{
				return redirect()->to('/admin/university');
			}
			echo 'failed';
			return;
		} else {
      $this->useDataTables('university_table');

      $this->data['universities'] = $universityModel->findAll();
      $view = 'admin/admin/university';
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
      $view = 'admin/admin/add_student';
    } elseif($mode == "delete"){
			if ($this->request->getPost()) {
				if($studentModel->delete($id)) {
					echo 'success';
				}
				return;
			} else{
				return redirect()->to('/admin/student');
			}
			echo 'failed';
			return;
		} else {
      $this->useDataTables('student_table');

      $this->data['students'] =
        $studentModel
          ->withSelect(['student.*','users.fullname','users.email','university.name as university_name','student_status.description as student_status'])
          ->withJoin('users','id','user_id')
          ->withJoin('university','id','university_id')
          ->withJoin('student_status','id','student_status_id')
          ->findAll();

      $view = 'admin/admin/student';
    }
    echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_admin', $this->data);
    echo view($view, $this->data);
		echo view('admin/include/footer');
	}

	public function kepengurusan($mode="", $id=""){
		$kepengurusanModel = model('App\Models\KepengurusanModel');

    if ($mode == "add" || $mode == "edit") {
      if ($this->request->getPost()) {
        if ($kepengurusanModel->save($this->request->getPost()) !== false)
        {
            return redirect()->to('/admin/kepengurusan');
        }
      }

      $this->data['mode'] = $mode;
      $this->data['id'] = $id;
      $this->data['kepengurusan'] = [];
      if ($id!="") {
        $this->data['kepengurusan'] = $kepengurusanModel
        ->find($id);
      }

      $this->useSelect2('select2');

      $view = 'admin/admin/add_kepengurusan';
    } elseif($mode == "delete"){
			if ($this->request->getPost()) {
				if($kepengurusanModel->delete($id)) {
					echo 'success';
				}
				return;
			} else{
				return redirect()->to('/admin/kepengurusan');
			}
			echo 'failed';
			return;
		} else {
      $this->useDataTables('kepengurusan_table');

      $this->data['kepengurusans'] =
        $kepengurusanModel
          ->findAll();

      $view = 'admin/admin/kepengurusan';
    }
		echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_admin', $this->data);
		echo view($view, $this->data);
		echo view('admin/include/footer');
	}

	public function jabatan($mode="", $id=""){
		$jabatanModel = model('App\Models\JabatanModel');

    if ($mode == "add" || $mode == "edit") {
      if ($this->request->getPost()) {
        if ($jabatanModel->save($this->request->getPost()) !== false)
        {
            return redirect()->to('/admin/jabatan');
        }
      }

      $this->data['mode'] = $mode;
      $this->data['id'] = $id;
      $this->data['jabatan'] = [];
      if ($id!="") {
        $this->data['jabatan'] = $jabatanModel
        ->find($id);
      }

      $this->useSelect2('select2');

      $view = 'admin/admin/add_jabatan';
    } elseif($mode == "delete"){
			if ($this->request->getPost()) {
				if($jabatanModel->delete($id)) {
					echo 'success';
				}
				return;
			} else{
				return redirect()->to('/admin/jabatan');
			}
			echo 'failed';
			return;
		} else {
      $this->useDataTables('jabatan_table');

      $this->data['jabatans'] =
        $jabatanModel
          ->findAll();

      $view = 'admin/admin/jabatan';
    }
    echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_admin', $this->data);
    echo view($view, $this->data);
		echo view('admin/include/footer');
	}

	public function pengurus($mode="", $id=""){
		$pengurusModel = model('App\Models\PengurusModel');

    if ($mode == "add" || $mode == "edit") {
      if ($this->request->getPost()) {
        if ($pengurusModel->save($this->request->getPost()) !== false)
        {
            return redirect()->to('/admin/pengurus');
        }
      }

			$jabatanModel = model('App\Models\JabatanModel');
			$kepengurusanModel = model('App\Models\KepengurusanModel');
			$studentModel = model('App\Models\StudentModel');

			$this->data['students'] =
        $studentModel
          ->withSelect(['student.user_id','users.fullname'])
          ->withJoin('users','id','user_id')
          ->findAll();

			$this->data['jabatans'] =
        $jabatanModel
          ->findAll();

			$this->data['kepengurusans'] =
        $kepengurusanModel
          ->findAll();

      $this->data['mode'] = $mode;
      $this->data['id'] = $id;
      $this->data['pengurus'] = [];
      if ($id!="") {
        $this->data['pengurus'] = $pengurusModel
        ->find($id);
      }

      $this->useSelect2('select2');

      $view = 'admin/admin/add_pengurus';
    } elseif($mode == "delete"){
			if ($this->request->getPost()) {
				if($pengurusModel->delete($id)) {
					echo 'success';
				}
				return;
			} else{
				return redirect()->to('/admin/pengurus');
			}
			echo 'failed';
			return;
		} elseif($mode == "deactivate"){
			if ($this->request->getPost()) {
				$is_activate = $this->request->getPost('is_activate');
				$col['id'] = $id;
				$col['is_active'] = $is_activate == "Activate"?1:0;
				if($pengurusModel->save($col)) {
					echo 'success';
				}
				return;
			} else{
				return redirect()->to('/admin/pengurus');
			}
			echo 'failed';
			return;
		} else {
      $this->useDataTables('pengurus_table');

      $this->data['penguruses'] =
        $pengurusModel
          ->withSelect(['pengurus.*','users.fullname','jabatan.name as jabatan_name','kepengurusan.name as kepengurusan_name'])
          ->withJoin('users','id','user_id')
          ->withJoin('jabatan','id','jabatan_id')
          ->withJoin('kepengurusan','id','kepengurusan_id')
          ->findAll();

      $view = 'admin/admin/pengurus';
    }
		echo view('admin/include/header');
		echo view('admin/include/navbar');
		echo view('admin/include/sidebar_admin', $this->data);
		echo view($view, $this->data);
		echo view('admin/include/footer');
	}

}
