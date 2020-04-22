<?php namespace App\Models;

class StudentPhotoModel extends BaseModel
{
  protected $table      = 'student_photo';
  protected $primaryKey = 'id';

  protected $returnType = 'array';
  protected $useSoftDeletes = true;

  protected $allowedFields = ['user_id','name'];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
