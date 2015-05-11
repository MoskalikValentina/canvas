<?php
/**
 * Product object
 */

namespace Samovar\Engine;


class Product {
    private $product_data = [];

    /*
     * Construct product object
     * @params $product_data Associative array
     */
    public function __construct(Array $product_data){
        $this->product_data = $product_data;
    }

    /*
     * Return data as array or as string
     * @param $data_name String Name of data param for return. Use optional
     * return Array with all data or string with field
     */
    public function get_data($data_name = ''){
        if($data_name !== ''){
            $res = $this->product_data[$data_name];
        } else {
            $res = $this->product_data;
        }
        return $res;
    }
} 