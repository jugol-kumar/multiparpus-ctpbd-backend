<?php


use App\Models\BusinessSetting;


if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $setting = BusinessSetting::where('type', $key)->first();
        return $setting == null ? $default : $setting->value;
    }
}



if (! function_exists('showPrices')) {
    function showPrices($product)
    {
        $lowest_price = $product->buying_price;
        $highest_price = $product->buying_price;

        if (true) {
            foreach ($product->stocks as $key => $stock) {
                if($lowest_price > $stock->price){
                    $lowest_price = $stock->price;
                }
                if($highest_price < $stock->price){
                    $highest_price = $stock->price;
                }
            }
        }
        $lowest_price = floatval($lowest_price);
        $highest_price = floatval($highest_price);

        if($lowest_price == $highest_price){
            return formatPrice($lowest_price);
        }
        else{
            return formatPrice($lowest_price).' - '.formatPrice($highest_price);
        }
    }
}

if(! function_exists('formatPrice')){
    function formatPrice($price): string
    {
        return get_setting('pre', false) ? get_setting('currency_symbol').$price : $price.get_setting('currency_symbol');
    }
}
























