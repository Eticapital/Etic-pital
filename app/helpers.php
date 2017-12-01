<?php

if (! function_exists('top')) {
    /**
     * Crea un evento que se convertirá en una notificación "top"
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     * @return string
     */
    function top($body, $type = 'success', $showCloseButton = true, $title = '', $duration = null, $user = null)
    {
        event(new \App\Events\TopNotification(
            $body,
            $type,
            $showCloseButton,
            $title,
            $duration,
            $user
        ));
    }
}

if (! function_exists('growl')) {
    /**
     * Crea un evento que se convertirá en una notificación "growl"
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     * @return string
     */
    function growl($body, $type = 'success', $title = null, $showIcon = false, $showCloseButton = true, $duration = null, $user = null)
    {
        event(new \App\Events\GrowlNotification(
            $body,
            $type,
            $title,
            $showIcon,
            $showCloseButton,
            $duration,
            $user
        ));
    }
}


if (!function_exists('format_percent')) {
    function format_percent($value, $decimals = 0)
    {
        $value = number_format($value, $decimals, '.', '') . '%';
        return sprintf('<span class="">%s</span>', $value);
    }
}

if (!function_exists('parse_size')) {
    function parse_size($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }
}

if (! function_exists('file_upload_max_size')) {
    /**
     * Devuelve el máximo tamaño permitdo para cargas
     * @return intenger
     */
    function file_upload_max_size()
    {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $max_size = parse_size(ini_get('post_max_size'));

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }

        return $max_size;
    }
}


if (! function_exists('money')) {
    /**
     * Devuelve el máximo tamaño permitdo para cargas
     * @return intenger
     */
    function money($amount, $decimals = 0, $symbol = '$', $is_cents = true)
    {
        return $symbol . number_format($is_cents ? $amount / 100 : $amount, $decimals);
    }
}
