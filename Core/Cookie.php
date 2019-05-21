<?php
namespace Core;

class Cookie
{
    /**
     * [register description]
     * @param  [type] $name     [description]
     * @param  [type] $value    [description]
     * @param  [type] $site_url [description]
     * @return [type]           [description]
     */
    public static function register($name, $value, $site_url)
    {
        $time = time() + 31536000;
        return setcookie($name, $value, $time, $site_url);
    }
    /**
     * [destroy description]
     * @param  [type] $name     [description]
     * @param  [type] $site_url [description]
     * @return [type]           [description]
     */
    public static function destroy($name, $site_url)
    {
        $time = time() - 100;
        return setcookie($name, null, $time, $site_url);
    }
}
