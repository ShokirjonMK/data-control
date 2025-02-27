<?php

namespace api\modules\v1\models\definitions;

/**
 * @SWG\Definition(
 *     required={"order_items", "order_id", "full_name", "phone", "address", "region"},
 *     description="Order ma'lumotlari, buyurtmaning holatlari va yetkazib berish uchun zarur maydonlar"
 * )
 *
 * @SWG\Property(
 *     property="order_id",
 *     type="integer",
 *     example=1220011,
 *     description="Buyurtma ID'si, har bir buyurtma uchun noyob raqam"
 * )
 * @SWG\Property(
 *     property="order_status",
 *     type="integer",
 *     example=1,
 *     readOnly=false,
 *     description="Buyurtma holati:
 *                  1 - Pending (Buyurtma qabul qilingan, lekin hali tasdiqlanmagan),
 *                  2 - Confirmed (Buyurtma tasdiqlandi va bajarishga tayyor),
 *                  3 - Canceled (Buyurtma bekor qilindi),
 *                  4 - Completed (Buyurtma muvaffaqiyatli bajarildi)"
 * )
 * @SWG\Property(
 *     property="delivery_status",
 *     type="integer",
 *     example=1,
 *     readOnly=true,
 *     description="Yetkazib berish holati:
 *                  1 - Not Shipped (Buyurtma hali jo'natilmagan),
 *                  2 - Shipped (Buyurtma jo'natildi),
 *                  3 - In Transit (Buyurtma yo'lda),
 *                  4 - Delivered (Buyurtma mijozga yetkazildi),
 *                  5 - Failed (Yetkazib berishda muammo yuzaga keldi)"
 * )
 * @SWG\Property(
 *     property="fulfillment_status",
 *     type="integer",
 *     example=1,
 *     readOnly=true,
 *     description="Buyurtmani bajarish holati:
 *                  1 - Unfulfilled (Buyurtma hali bajarilmagan),
 *                  2 - Processing (Buyurtma bajarilmoqda),
 *                  3 - Fulfilled (Buyurtma bajarildi va yetkazishga tayyor)"
 * )
 * @SWG\Property(
 *     property="full_name",
 *     type="string",
 *     example="Jon Done",
 *     description="Mijozning to'liq ismi"
 * )
 * @SWG\Property(
 *     property="phone",
 *     type="string",
 *     example="+998900000000",
 *     description="Mijozning telefon raqami"
 * )
 * @SWG\Property(
 *     property="address",
 *     type="string",
 *     example="123 Main Street",
 *     description="Mijozning manzili"
 * )
 * @SWG\Property(
 *     property="region",
 *     type="string",
 *     example="Toshkent",
 *     description="Hudud yoki viloyat"
 * )
 * @SWG\Property(
 *     property="country",
 *     type="string",
 *     readOnly=true,
 *     example="Uzbekistan",
 *     description="Davlat nomi"
 * )
 * @SWG\Property(
 *     property="city",
 *     type="string",
 *     example="Toshkent shahar",
 *     description="Shahar nomi"
 * )
 * @SWG\Property(
 *     property="zip",
 *     type="string",
 *     example="100200",
 *     description="Pochta indeksi"
 * )
 * @SWG\Property(
 *     property="order_items",
 *     type="array",
 *     description="Buyurtma mahsulotlari ro'yxati",
 *     @SWG\Items(
 *         type="object",
 *         required={"product_id", "quantity", "price"},
 *         @SWG\Property(
 *             property="product_id",
 *             type="integer",
 *             example=1,
 *             description="Mahsulot ID'si, har bir mahsulot uchun noyob"
 *         ),
 *         @SWG\Property(
 *             property="quantity",
 *             type="integer",
 *             example=1,
 *             description="Buyurtma miqdori (mahsulot soni)"
 *         ),
 *         @SWG\Property(
 *             property="price",
 *             type="integer",
 *             example=100000,
 *             description="Mahsulot narxi (1 dona uchun)"
 *         )
 *     )
 * )
 */
class Order
{

}
