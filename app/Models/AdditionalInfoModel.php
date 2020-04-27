<?php namespace App\Models;

class AdditionalInfoModel extends BaseModel
{
  protected $table      = 'student_additional_info';
  protected $primaryKey = 'id';

  protected $returnType = 'array';
  protected $useSoftDeletes = true;

  protected $allowedFields = ['user_id','field_id','content','is_public'];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
