<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class PusherConfig extends BaseConfig
{
    // copy the full tag into this variable
    public static $cluster = "eu";
    public static $app_id = "__app_id__";
    public static $key = "__key__";
    public static $secret = "__secret__";
    public static $useTLS = false;

}
