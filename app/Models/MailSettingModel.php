<?php namespace App\Models;

class MailSettingModel extends BaseModel
{
  protected $table      = 'mail_settings';
  protected $primaryKey = 'id';

  protected $allowedFields = ['name','SMTP_user', 'SMTP_pass', 'SMTP_host', 'SMTP_crypto', 'SMTP_port'];
}
