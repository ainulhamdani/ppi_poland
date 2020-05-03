<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class JWTConfig extends BaseConfig
{
    public static $KEY  = '__test_secret__';
    public static $ALGO = ['HS256'];

}
