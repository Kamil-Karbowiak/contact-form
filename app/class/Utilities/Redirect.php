<?php
namespace ContactForm\Utilities;

class Redirect
{
    public static function redirect($url, $data = [], $statusCode = 303)
    {
        if(!empty($data)){
            $url .= self::prepareParams($data);
        }
        header('Location: ' . '/contactForm/'.$url,$statusCode);
        die();
    }
    private static function prepareParams($data)
    {
        $tempArray = [];
        foreach($data as $key => $value){
            $tempArray[] = $key."=".$value;
        }
        return "?".implode('&', $tempArray);
    }
}