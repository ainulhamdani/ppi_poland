<?php namespace App\Models;

class PostFollowModel extends BaseModel
{
  protected $table      = 'post_follow';
  protected $primaryKey = 'id';

  protected $allowedFields = ['user_id','post_id'];
}
