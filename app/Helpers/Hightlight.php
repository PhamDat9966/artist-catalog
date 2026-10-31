<?php
namespace App\Helpers;
use Illuminate\Support\Str;

class Hightlight{
    public static function show($input , $paramsSearch , $field ){
        if($paramsSearch['value'] == null) return $input;
        if($paramsSearch['field'] == 'all' || $paramsSearch['field'] == $field ){
            return preg_replace("/" . preg_quote($paramsSearch['value'],"/") . "/i",'<span class="highlight">$0</span>', $input);
        }
        return $input;
    }

    public static function showContent($input , $paramsSearch , $field ){
        if($paramsSearch['value'] == null) return Str::words(strip_tags($input), 120, '...');
        if($paramsSearch['field'] == 'all' || $paramsSearch['field'] == $field ){
            $inputSeach = preg_replace("/" . preg_quote($paramsSearch['value'],"/") . "/i",'<span class="highlight">$0</span>', $input);
            return Str::words(strip_tags($inputSeach), 240, '...');;
        }
        return Str::words(strip_tags($input), 120, '...');
    }

    public static function showRSS($input , $paramsSearch ){
        if($paramsSearch == 'null') return $input;
        if($paramsSearch == 'all' || $paramsSearch != null ){
            return preg_replace("/" . preg_quote($paramsSearch,"/") . "/i",'<span class="highlight">$0</span>', $input);
        }
        return $input;
    }

    public static function showWithColor($input , $paramsSearch , $field, $attrID){
        if($paramsSearch['value'] == null) return $input;
        if($paramsSearch['field'] == 'all' || $paramsSearch['field'] == $field ){
            return preg_replace("/" . preg_quote($paramsSearch['value'],"/") . "/i",'<span class="highlight" style="background: #d5ff05;">$0</span>', $input);
        }
        return $input;
    }
}
