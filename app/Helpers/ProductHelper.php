<?php
namespace App\Helpers;

use Illuminate\Support\Str;
use Whoops\Exception\Formatter;

class ProductHelper{
    public static function xhtmlPhoneItem($item){

        $id              = $item['id'];
        $urlItem         = route('phoneItem',['id'=>$id]);
        $name            = $item['name'];
        $description     = $item['description'];
        $description     = strip_tags($description);
        $description     = html_entity_decode($description);

        $descriptionMini = Str::words($item['description'], 20, '...');
        // 1. Loại bỏ các thẻ HTML
        $descriptionMini = strip_tags($descriptionMini);
        // 2. Chuyển HTML entities về ký tự thuần
        $descriptionMini = "<strong style='color:red;'>".ucfirst($item['name']).': </strong> '.html_entity_decode($descriptionMini);

        //SET DEFAULT
        //Chọn giá từ phần tử đầu tiên của attribute_prices làm giá niên yết
        $originalPriceDefault       = $item['attribute_prices'][0]['price'];                //Giá khởi điểm
        $dataColorIdDefault         = $item['attribute_prices'][0]['color_id'];             //id màu khởi điểm
        $dataColorNameDefault       = $item['attribute_prices'][0]['color_name'];           //name màu khởi điểm
        $dataMaterialIdDefault      = $item['attribute_prices'][0]['material_id'];          //id dung lượng khởi điểm
        $dataMaterialNameDefault    = $item['attribute_prices'][0]['material_name'];        //name dung lượng khởi điểm

        $attributeDefault = $colorIdDefault  = null;

        foreach($item['attribute_prices'] as $attribute_price){
            //Trường hợp đã có set default chọn giá, màu sắc, dung lượng ở `productAttributePrice controller`
            if($attribute_price['default'] == 1){
                $dataColorIdDefault         = $attribute_price['color_id'];
                $dataColorNameDefault       = $attribute_price['color_name'];
                $dataMaterialIdDefault      = $attribute_price['material_id'];
                $dataMaterialNameDefault     = $attribute_price['material_name'];
                $originalPriceDefault       = $attribute_price['price'];

                $attributeDefault       = $colorIdDefault  = $attribute_price['color_id']; // Set color default
                $originalPriceDefault   = $attribute_price['price'];
                break;
            }
        }

        //price start:
        $saveTitle       = 0;
        $salePrice       = 0;
        switch ($item['price_discount_type']) {
            case 'percent':
                $saveTitle = '-'.$item['price_discount_percent'].'%';
                $salePrice = $originalPriceDefault - ($originalPriceDefault * $item['price_discount_percent']/100);
                break;
            case 'value':
                $saveTitle = '-'.$item['price_discount_value'].'$';
                $salePrice = $originalPriceDefault - $item['price_discount_value'];
                break;
        }

        $salePrice      = ($salePrice == 0) ? 'Mẫu đã hết hàng' : $salePrice;
        $isShowDollar   = is_numeric($salePrice) ? '$' : '';

        //media
        $imgArray        = json_decode($item['media'][0]['content'],true);

        if($colorIdDefault !== null){
            foreach($item['media'] as $elementMedia){
                if($elementMedia['attribute_value_id'] == $colorIdDefault){
                    $imgArray        = json_decode($elementMedia['content'],true);
                }
            }
        }
        $imgName         = $imgArray['name'];
        $imgAlt          = $imgArray['alt'];

        $image           = Template::showProductThumbInPhone('product',$imgName,$imgAlt);
        $imageURL        = ($imgName)? asset("images/product/$imgName") : '';

        //Add to Cart
        $urlAddToCart           = route('authsphone/addToCart');

        $xhtml        ='<div class="product-box">
                            <div class="img-wrapper">
                                <div class="lable-block">
                                    <span class="lable4 badge badge-danger"> '.$saveTitle.'</span>
                                </div>
                                <div class="front">
                                    <a href="'.$urlItem.'">
                                        '.$image.'
                                    </a>
                                </div>
                                <div class="cart-info cart-wrap">
                                    <a href="#" class="add-to-cart" title="Add to cart"
                                                data-id="'.$id.'"
                                                data-name="'.$name.'"
                                                data-color-id="'.$dataColorIdDefault.'"
                                                data-material-id="'.$dataMaterialIdDefault.'"
                                                data-color-name="'.$dataColorNameDefault.'"
                                                data-material-name="'.$dataMaterialNameDefault.'"
                                                data-url="'.$urlAddToCart.'"
                                                ><i class="ti-shopping-cart"></i>
                                    </a>
                                    <a href="#" title="Quick View">
                                        <i class="ti-search quick-view-btn" data-toggle="modal" data-target="#quick-view"
                                                                            data-id="'.$id.'"
                                                                            data-name="'.$name.'"
                                                                            data-description="'.$description.'"
                                                                            data-imageurl="'.$imageURL.'"
                                                                            data-price="'.$originalPriceDefault.'"
                                                                            data-sale-price="'.$salePrice.'"
                                                                            data-color-id="'.$dataColorIdDefault.'"
                                                                            data-material-id="'.$dataMaterialIdDefault.'"
                                                                            data-color-name="'.$dataColorNameDefault.'"
                                                                            data-material-name="'.$dataMaterialNameDefault.'"
                                                                            data-url-item="'.$urlItem.'"
                                                                            data-url-add-cart="'.$urlAddToCart.'"
                                                                            >
                                        </i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-detail">
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <a href="'.$urlItem.'"
                                    title="'.$item['name'].'">
                                    <h6>'.$descriptionMini.'</h6>
                                </a>
                                <h4 class="text-lowercase">'.$salePrice.' '.$isShowDollar.' <del>'.$originalPriceDefault.' '.$isShowDollar.'</del></h4>
                            </div>
                        </div>';
        return $xhtml;
    }

}
