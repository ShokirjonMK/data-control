<?php

namespace api\modules\v1\services;

use Yii;

class ProductQueue
{
    /**
     * `product_ids` jadvaliga mahsulot IDlarini qo'shish.
     */
    public function addProductIds(array $productIds): bool
    {
        if (empty($productIds)) {
            return false;
        }

        $productIdsJson = json_encode($productIds);

        Yii::$app->db->createCommand()->insert('product_ids', ['ids' => $productIdsJson])->execute();

        return true;
    }

    /**
     * `product_ids` jadvalidan mahsulot IDlarini olish.
     */
    public function getProductIds(): ?array
    {
        $productIdsJson = Yii::$app->db->createCommand('SELECT ids FROM product_ids')->queryScalar();

        if (!$productIdsJson) {
            return null;
        }

        return json_decode($productIdsJson, true);
    }

    /**
     * `product_ids` jadvalidan barcha yozuvlarni o'chirish.
     */
    public function clearProductIds(): void
    {
        Yii::$app->db->createCommand()->delete('product_ids')->execute();
    }
}