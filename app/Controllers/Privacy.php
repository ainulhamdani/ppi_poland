<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Privacy extends Controller
{
  public function index(){
    echo view('privacy_policy');
  }
}
