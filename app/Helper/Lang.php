<?php

namespace App\Helper;

class Lang
{
    public static function getCurrentUserLangLabel()
    {
        $user = \Auth::user();

        if(empty($user)) return;

        $langs = config('app.available_locales');

        return isset($langs[$user->lang]) ? $langs[$user->lang] : '';
    }

    public static function getAvailableLangs()
    {
        $user = \Auth::user();

        if(empty($user)) return;

        $langs = config('app.available_locales');

        if(isset($langs[$user->lang]))
            unset($langs[$user->lang]);

        return $langs;
    }
}