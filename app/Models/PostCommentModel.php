<?php namespace App\Models;

class PostCommentModel extends BaseModel
{
  protected $table      = 'post_comment';
  protected $primaryKey = 'id';

  protected $returnType = 'array';
  protected $useSoftDeletes = true;

  protected $allowedFields = ['post_id','user_id','comment'];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
