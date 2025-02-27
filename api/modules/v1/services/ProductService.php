<?php

namespace api\modules\v1\services;

use common\models\Product;

class ProductService
{
    private ProductQueue $productQueue;

    public function __construct(ProductQueue $productQueue)
    {
        $this->productQueue = $productQueue;
    }

    /**
     * Mahsulot statusini yangilash va `product_ids` jadvalini tozalash.
     * 1 user da tin, phone, name, contract_number
     */
    public function markProductsAsDelivered(): bool
    {
        $productIds = $this->productQueue->getProductIds();

        if (!$productIds) {
            return false;
        }

        Product::updateAll(['status' => Product::STATUS_DELIVERED], ['id' => $productIds]);

        $this->productQueue->clearProductIds();

        return true;
    }
}