<?php declare(strict_types=1);

namespace api\modules\v1\models\forms\baseModel;

use yii\base\Model;

abstract class BaseProductModel extends Model
{
    public $id; // Mahsulot ID'si (asosiy kalit)
    public $group; // Mahsulot guruhi
    public $code; // Mahsulot kodi
    public $name; // Mahsulot nomi
    public $full_name; // Mahsulotning to'liq nomi
    public $gtin; // GTIN (Global Trade Item Number - xalqaro savdo birligi raqami)
    public $article; // Mahsulot artikuli (artikul raqami)
    public $nomenclature_type; // Nomenklatura turi (mahsulotning turi)
    public $unit; // O'lchov birligi (masalan, kg, dona, litr)
    public $shelf_life_stock; // Yaroqlilik zaxirasi (mahsulotning maksimal saqlash muddati)
    public $abc_class; // ABC sinfi (ABC tahlili bo'yicha mahsulot klassifikatsiyasi)
    public $kis_code; // KIS kodi (Kompyuter axborot tizimi kodi)
    public $comment; // Izoh (qo'shimcha izoh yoki sharh)
    public $is_set; // To'plam (komplektmi yoki yo'qmi)
    public $weight; // Og'irlik (mahsulotning og'irligi)
    public $net_weight; // Netto og'irlik (qadoqdagi sof og'irlik)
    public $min_shelf_life_stock; // Minimal yaroqlilik zaxirasi (qabul qilish paytidagi minimal saqlash muddati)
    public $name_eng; // Inglizcha nom (mahsulotning ingliz tilidagi nomi)
    public $tsd_name; // TSD nomi (terminal yoki skanerlarda ishlatiladigan nom)
    public $volume; // Hajm (mahsulot hajmi)
    public $net_volume; // Netto hajm (qadoqdagi sof hajm)
    public $shelf_life_deviation_days; // Yaroqlilik muddatining chetlashishi kunlarda (maximal og'ish)
    public $shelf_life_period; // Yaroqlilik zaxirasi muddati (mahsulotning yaroqlilik muddati)
    public $min_shelf_life_period; // Minimal yaroqlilik zaxirasi muddati (qabul qilish paytidagi minimal yaroqlilik muddati)
    public $shelf_life_deviation_period; // Yaroqlilik muddatining chetlashishi davri (maksimal og'ish davri)
    public $depositor; // Omborchi (mahsulot uchun javobgar omborchi)
    public $seasonal_abc_coefficient; // Mavsumiy ABC koeffitsienti (mavsumiy mahsulotlarning ABC tahlili bo'yicha koeffitsienti)
    public $specification; // Spetsifikatsiya (mahsulot tavsifi yoki texnik talablari)
    public $storage_period_days; // Saqlash muddati kunlarda (mahsulotning maksimal saqlash muddati)
    public $default_status; // Sukut bo'yicha status (mahsulotning boshlang'ich holati)
    public $temperature_mode; // Harorat rejimi (mahsulotni saqlash harorati)
    public $base_packaging; // Asosiy o'ram (mahsulotning asosiy qadoqlanishi)
    public $billing_packaging; // Billing uchun o'ram (billing jarayonida foydalaniladigan o'ram)
    public $report_packaging; // Hisobot uchun o'ram (hisobotlar uchun ishlatiladigan o'ram)

    public $supplier_buyer_id;

    public function rules()
    {
        return [
            [['group', 'code', 'name', 'full_name', 'gtin', 'article',
                'nomenclature_type', 'unit', 'shelf_life_stock', 'kis_code',
                'is_set', 'weight', 'net_weight', 'volume', 'net_volume', 'specification',
                'temperature_mode', 'base_packaging', 'supplier_buyer_id'
            ], 'required'],

            [['group', 'code', 'name', 'full_name', 'gtin', 'article',
                'nomenclature_type', 'unit', 'abc_class',
                'kis_code', 'comment', 'name_eng', 'tsd_name',
                'depositor', 'default_status', 'temperature_mode',
                'base_packaging', 'billing_packaging', 'report_packaging',
            ], 'string'],

            [['shelf_life_stock', 'min_shelf_life_stock', 'weight', 'net_weight',
                'volume', 'net_volume', 'seasonal_abc_coefficient'
            ], 'number'],

            [['shelf_life_deviation_days', 'shelf_life_period', 'min_shelf_life_period',
                'shelf_life_deviation_period', 'storage_period_days', 'id', 'supplier_buyer_id'
            ], 'integer'],

            [['is_set'], 'boolean'],

            [['specification'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'group' => 'Группа товара',
            'code' => 'Код товара',
            'name' => 'Наименование товара',
            'full_name' => 'Полное наименование товара',
            'gtin' => 'GTIN',
            'article' => 'Артикул товара',
            'nomenclature_type' => 'Вид номенклатуры',
            'unit' => 'Единица измерения',
            'shelf_life_stock' => 'Запас годности',
            'abc_class' => 'Класс ABC',
            'kis_code' => 'Код КИС',
            'comment' => 'Комментарий',
            'is_set' => 'Комплект',
            'weight' => 'Масса',
            'net_weight' => 'Масса (нетто)',
            'min_shelf_life_stock' => 'Минимальный запас годности',
            'name_eng' => 'Наименование (англ.)',
            'tsd_name' => 'Наименование ТСД',
            'volume' => 'Объем',
            'net_volume' => 'Объем (нетто)',
            'shelf_life_deviation_days' => 'Отклонение срока годности (в днях)',
            'shelf_life_period' => 'Период запаса годности',
            'min_shelf_life_period' => 'Период минимального запаса годности',
            'shelf_life_deviation_period' => 'Период отклонения срока годности',
            'depositor' => 'Поклажедатель',
            'seasonal_abc_coefficient' => 'Сезонный коэффициент ABC',
            'specification' => 'Спецификация',
            'storage_period_days' => 'Срок хранения (в днях)',
            'default_status' => 'Статус по умолчанию',
            'temperature_mode' => 'Температурный режим',
            'base_packaging' => 'Базовая упаковка',
            'billing_packaging' => 'Упаковка для биллинга',
            'report_packaging' => 'Упаковка для отчетов',
        ];
    }
}