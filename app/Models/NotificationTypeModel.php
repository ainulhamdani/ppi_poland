<?php namespace App\Models;

class NotificationTypeModel extends BaseModel
{
  protected $table      = 'notification_type';
  protected $primaryKey = 'id';

  protected $allowedFields = ['name','content'];
}
