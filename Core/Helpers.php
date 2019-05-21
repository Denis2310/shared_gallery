<?php

/**
 * [redirect description]
 * @param  string $location [description]
 * @return [type]           [description]
 */
function redirect(string $location = '')
{
    header("Location: $location");
}

/**
 * [rrmdir description]
 * @param  [type] $dir [description]
 * @return [type]      [description]
 */
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);

        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object)) {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }

            }
        }

        rmdir($dir);
    }
}
