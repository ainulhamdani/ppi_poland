<?php namespace App\Models;

class PostLikesModel extends BaseModel
{
  protected $table      = 'post_likes';
  protected $primaryKey = 'id';

  protected $returnType = 'array';

  protected $allowedFields = ['post_id','user_id'];
}
