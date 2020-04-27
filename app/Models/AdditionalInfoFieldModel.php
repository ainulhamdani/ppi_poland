<?php namespace App\Models;

class AdditionalInfoFieldModel extends BaseModel
{
  protected $table      = 'student_additional_info_field';
  protected $primaryKey = 'id';

  protected $returnType = 'array';
  protected $useSoftDeletes = true;

  protected $allowedFields = ['name','label','type_id'];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
