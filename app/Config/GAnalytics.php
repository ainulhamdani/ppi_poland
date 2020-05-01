<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class GAnalytics extends BaseConfig
{
    // copy the full tag into this variable
    public static function getTag($user_id){
      if (!$user_id)
        return '<!-- Global site tag (gtag.js) - Google Analytics -->';
      else
        return '<!-- Global site tag (gtag.js) - Google Analytics -->';
    }

}
