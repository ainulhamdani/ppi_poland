<?php namespace App\Models;

class NotificationModel extends BaseModel
{
  protected $table      = 'notification';
  protected $primaryKey = 'id';

  protected $allowedFields = ['notification_type_id','user_to','user_from','post_id','comment_id','is_read'];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';
}
