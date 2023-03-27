<?php

namespace App\Helpers;
use App\Services\TelegramService;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Request;

class Helper
{
    public static function PushError($exception)
    {   
        try {
            $html = '<b>[Lỗi] : </b><code>' . $exception->getMessage() . '</code>';
            $html .= '<b>[File] : </b><code>' . $exception->getFile() . '</code>';
            $html .= '<b>[Line] : </b><code>' . $exception->getLine() . '</code>';
            $html .= '<b>[Request] : </b><code>' . json_encode(request()->all()) . '</code>';
            $html .= '<b>[URL] : </b><a href="'. url()->full() .'">' . url()->full() . '</a>';
            TelegramService::sendMessage($html);
        } catch (\Throwable $th) {
            TelegramService::sendMessage($exception);
        }
    }

    public static function Crawl($html)
    {
        return new Crawler($html);
    }

    public static function FindByClass($crawl, $class)
    {
        return $crawl->filter($class);
    }

    public static function convert($instance , $str) 
    {
        $params = explode('.', $str);
        if($params == 1) {
            return $instance;
        } else {
            $obj = $instance;
            foreach($params as $key => $param) {
                if(!$key) {
                    continue;
                }
                if (strpos($param, "[") != false && strpos($param, "]") != false) {
                    $numberArray = Helper::GetContentBetweenString($param,"[","]");
                    $param = str_replace("[" . $numberArray . "]", "", $param);
                    $obj = $obj->{$param}[$numberArray];
                }else{
                    $obj = $obj->{$param};
                }
            }
        }
        return $obj;
    }

    public static function GetContentBetweenString($string, $start, $end, $isLast=false)
    {
        $string = ' ' . $string;
        if($isLast)
            $ini = strrpos($string, $start);
        else
            $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        if($isLast)
            $len = strpos($string, $end, $ini) - $ini;
        else
            $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    
}
