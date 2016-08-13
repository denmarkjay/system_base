<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/14/2016
 * Time: 12:19 AM
 */

namespace Jay\Bundle\AdminBundle\Utility;

class Init
{
    static function app_safe_sql_string($param)
    {
        foreach ($param as $k => $v) {
            $param[$k] = addslashes($v);
        }

        return $param;
    }
}