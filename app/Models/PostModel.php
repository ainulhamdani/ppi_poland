<?php namespace App\Models;

class PostModel extends BaseModel
{
  protected $table      = 'post';
  protected $primaryKey = 'id';

  protected $returnType = 'array';
  protected $useSoftDeletes = true;

  protected $allowedFields = ['user_id','content'];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
