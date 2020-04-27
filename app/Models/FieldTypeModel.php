<?php namespace App\Models;

class FieldTypeModel extends BaseModel
{
  protected $table      = 'field_type';
  protected $primaryKey = 'id';

  protected $allowedFields = ['name'];
}
