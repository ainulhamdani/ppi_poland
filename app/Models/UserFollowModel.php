<?php namespace App\Models;

class UserFollowModel extends BaseModel
{
  protected $table      = 'user_follow';
  protected $primaryKey = 'id';

  protected $allowedFields = ['user_id','follow'];
}
