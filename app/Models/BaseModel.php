<?php namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{

  public function withSelect($columns){
    if (is_array($columns)&&!empty($columns)) {
      $select = [];
      foreach ($columns as $column) {
        $select[] = $column;
      }
      $this->builder()
         ->select(implode(',',$select));
    }
    elseif (is_string($columns)) {
      $this->builder()
         ->select($columns);
    }

    return $this;
  }

  public function withOrderBy($column, $orderType='ASC'){

    $this->builder()
			 ->orderBy($column, $orderType);

    return $this;
  }

  public function withJoin($joinTable, $targetColumn, $sourceColumn, $joinType='LEFT'){

    $this->builder()
			 ->join($joinTable, $this->table.'.'.$sourceColumn.' = '.$joinTable.'.'.$targetColumn, $joinType);

    return $this;
  }

  public function withCustomJoin($query, $joinTable, $targetColumn, $sourceColumn, $joinType='LEFT'){

    $this->builder()
			 ->join($query, $this->table.'.'.$sourceColumn.' = '.$joinTable.'.'.$targetColumn, $joinType);

    return $this;
  }

  public function withWhere($column, $values){

    if (is_array($values)&&!empty($values)) {
      $this->builder()
         ->whereIn($column, $values);
    }
		elseif (is_numeric($values) || is_string($values))
		{
      $this->builder()
  			 ->where($column, $values);
		}

    return $this;
  }

}
