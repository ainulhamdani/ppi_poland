<?php namespace App\Models;

class PostAttachmentModel extends BaseModel
{
  protected $table      = 'post_attachment';
  protected $primaryKey = 'id';

  protected $returnType = 'array';

  protected $allowedFields = ['post_id','name'];
}
