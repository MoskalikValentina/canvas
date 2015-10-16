<?php

/**
 * Class TextFormatter
 *
 * Helper class for text formatting
 */

class TextFormatter {
    /**
     * @param string $value Base price
     * @param int $count Count of charts in group
     * @return string
     */
    public function addSpaceToPrice($value, $count = 3){
        $price = str_replace(' ', '', $value);
        $fprice = '';
        $price_ln = strlen($price);
        if($price_ln > $count){
            for($i = $price_ln; $i >= 0; $i--){
                $tmp = $i % $count === 0 ? ' ' : '';
                $fprice =$fprice . $tmp . substr($price, $price_ln - $i, 1);
            }
        } else {
            $fprice = $price;
        }
        return $fprice;
    }
} 