<?php
/**
 * Created by PhpStorm.
 * User: Masiur
 * Date: 11/8/17
 * Time: 6:08 PM
 */

namespace App\BaseSettings;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class Menu
{
    /**
     * Compares given route name with current route name.
     *
     * @param  string  $routeName
     * @param  string  $output
     * @return boolean
     */
    public static function isActiveRoute($routeName, $output = "active open")
    {
        if(Route::currentRouteName() == $routeName) return $output;
        return null;
    }
    /**
     * Compares given URL with current URL.
     *
     * @param  string  $url
     * @param  string  $output
     * @return boolean
     */
    public static function isActiveURL($url, $output = "active")
    {
        if(URL::current() == url($url)) return $output;
        return null;
    }
    /**
     * Detects if the given string is found in the current URL.
     *
     * @param  string  $string
     * @param  string  $output
     * @return boolean
     */
    public static function isActiveMatch($string, $output = "active")
    {
        if(strpos(URL::current(), $string)) return $output;
        return null;
    }
    /**
     * Compares given array of route names with current route name.
     *
     * @param  array  $routeNames
     * @param  string $output
     * @return boolean
     */
    public static function areActiveRoutes(array $routeNames, $output = "active open")
    {
        foreach($routeNames as $routeName)
        {
            if(Route::currentRouteName() == $routeName) return $output;
        }
        return null;
    }
    /**
     * Compares given array of URLs with current URL.
     *
     * @param  array  $urls
     * @param  string $output
     * @return boolean
     */
    public static  function areActiveURLs(array $urls, $output = "active")
    {
        foreach($urls as $url)
        {
            if(URL::current() == url($url)) return $output;
        }
        return null;
    }

}