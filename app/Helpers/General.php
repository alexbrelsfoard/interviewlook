<?php

function pr($e)
{
    echo '<pre>';
    print_r($e);
    echo '</pre>';
}

if (!function_exists('vd')) {

    function vd()
    {
        foreach (func_get_args() as $e) {
            echo "<pre>";
            var_dump($e);
            echo "</pre>";
        }
    }

}

if (!function_exists('jl')) {

    function jl($e, $loc = __DIR__, $file_name = '', $raw_log = false)
    {
        $raw_log = $raw_log === true;
        if (!is_dir($loc)) $loc = __DIR__;
        if (!$file_name) {
            $file_name = 'log' . (!$raw_log ? '.json' : '');
        }
        $log_data = $raw_log ? print_r($e, true) : @json_encode($e, JSON_PRETTY_PRINT);
        @error_log($log_data . "\n\n", 3, $loc . "/{$file_name}");
    }

}

if (!function_exists('lg')) {

    function lg($e, $loc = __DIR__, $file_name = '')
    {
        jl($e, $loc, $file_name, true);
    }

}

if (!function_exists('jc')) {

    function jc($data, $loc = __DIR__, $file_name = 'log.json')
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($loc . "/{$file_name}", $json);
    }

}

function hide_phone($phone)
{
    return substr($phone, 0, -4) . "****";
}

if (!function_exists('main_path')) {

    /**
     * Get the path to the main folder.
     *
     * @param  string  $path
     * @return string
     */
    function main_path($path = '')
    {
        return dirname(app()->make('path')) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

}

function generateRandomString($length = 15)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function br2nl($input)
{
    return preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n", "", str_replace("\r", "", htmlspecialchars_decode($input))));
}

if (!function_exists('dataready')) {

    function dataready($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}

if (!function_exists('slugify')) {

    function slugify($text)
    {
      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '', $text);
    
      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);
    
      // trim
      $text = trim($text, '-');
    
      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);
    
      // lowercase
      $text = strtolower($text);
    
      if (empty($text)) {
        return 'n-a';
      }
    
      return $text;
    }

}