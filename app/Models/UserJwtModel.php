<?php namespace App\Models;

class UserJwtModel extends BaseModel
{
  protected $table      = 'user_jwt';
  protected $primaryKey = 'id';

  protected $allowedFields = ['user_id','user_agent','ip_address','iat','token'];
}
