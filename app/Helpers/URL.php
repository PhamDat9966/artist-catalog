<?php
namespace App\Helpers;
use Illuminate\Support\Str;
class URL{
    public static function linkCategoryArticle($id,$name){
        $id   = (int)$id;
        $nameCategory = Str::slug($name);
        $nameCategory = 'category-'.$nameCategory; // Đây là 1 lỗi cực kỳ vớ vẩn, chưa tìm ra được cách giải quyết, tạm thời phải dùng đến kết nối chuỗi 'category-'
        return route('categoryArticle/index',[
            'category_id'   =>  $id,
            'category_name' =>  $nameCategory

        ]);

    }

    public static function linkArticle($id,$name){
        $name = Str::slug($name);
        return route('article/index',[
            'article_id'   =>  $id ,
            'article_name' =>  $name
        ]);
    }

    public static function linkMenu($url,$name){
        $parts = explode('-', $url);
        $prefix = $parts[0];
        if($prefix == 'category'){
            $id     = $parts[1];
            $nameCategory = Str::slug($name);
            $nameCategory = 'category-'.$nameCategory; // Đây là 1 lỗi cực kỳ vớ vẩn, chưa tìm ra được cách giải quyết, tạm thời phải dùng đến kết nối chuỗi 'category-'
            return route('category/index',[
                'category_id'   =>  $id,
                'category_name' =>  $nameCategory

            ]);
        }
    }
}
