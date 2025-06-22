<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Helpers extends Model
{

    public static function get_host($url)
    {
        $parse = parse_url($url);
        $referrer_host = $parse['host'] ?? null;
        //if (substr($referrer_host, 0, 4) == 'www.') $referrer_host = str_replace('www.', '', $referrer_host);

        return $referrer_host ?? null;
    }


    public static function check_source_destination_host($source_host, $destination_host, $allow_subdomains)
    {

        if ($source_host == $destination_host) return true;

        if ($allow_subdomains) {
            /*
            filme.clevada.com  clevada.com
            */

            if (str_ends_with($source_host, $destination_host)) return true;
        }

        return false;
    }
}
