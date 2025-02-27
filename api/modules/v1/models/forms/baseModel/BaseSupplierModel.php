<?php declare(strict_types=1);

namespace api\modules\v1\models\forms\baseModel;

use yii\base\Model;

abstract class BaseSupplierModel extends Model
{
    public $id;
    // Yetkazib berish bo'yicha asosiy ma'lumotlar
    public $number; // Yetkazib berish raqami
    public $date; // Yetkazib berish sanasi
    public $counterparty; // Kontragent (yukni yetkazib beruvchi tashkilot)
    public $arrival_date; // Yuk qabul qilingan sana
    public $comment; // Izoh yoki sharh
    public $vehicle_model; // Transport vositasining modeli
    public $vehicle_number; // Transport vositasining davlat raqami
    public $driver_name; // Haydovchining to'liq ismi
    public $driver_document; // Haydovchiga tegishli hujjat (pasport, litsenziya va h.k.)
    public $contract_number; // Shartnoma raqami
    public $contract_date; // Shartnoma tuzilgan sana
    public $nomenclature; // Nomenklatura (yukning turi yoki mahsulotlar ro‘yxati)
    public $quantity; // Mahsulot miqdori
    public $price; // Mahsulotning bir dona yoki birlik narxi
    public $total_amount; // Jami summa (narx * miqdor)

    // Yetkazib berish tafsilotlari (SupplierDetails)
    public $kis_number; // KIS tizimidagi buyurtma raqami
    public $kis_date; // KIS tizimida buyurtma kiritilgan sana
    public $accept_by_places; // Yuk joylari bo‘yicha qabul qilish (true/false)
    public $vehicle_type; // Transport vositasi turi (masalan, yuk mashinasi, avtobus)
    public $vat_rate; // QQS stavkasi (foizda)
    public $vat_amount; // QQS summasi
    public $price_includes_vat; // Narxga QQS kiritilganmi (true/false)
    public $discount_amount; // Chegirma summasi
    public $under_delivery_percent; // Yetkazib berilmagan mahsulot foizi
    public $over_delivery_percent; // Ortiqcha yetkazib berilgan mahsulot foizi

    // Yuk qadoqlanishi bo‘yicha ma'lumotlar (SupplierPackage)
    public $nomenclature_package; // Nomenklatura qadoqlanishi turi
    public $package_quantity; // Qadoqlar soni

    public function rules()
    {
        return [
            [['number', 'date', 'counterparty', 'nomenclature', 'quantity', 'price', 'total_amount'], 'required'],
            [['date', 'arrival_date', 'kis_date', 'contract_date'], 'date', 'format' => 'php:Y-m-d'],
            [['quantity', 'package_quantity'], 'integer'],
            [['price', 'total_amount', 'vat_rate', 'vat_amount', 'discount_amount', 'under_delivery_percent', 'over_delivery_percent'], 'number'],
            [['number', 'counterparty', 'vehicle_model', 'vehicle_number', 'driver_name', 'driver_document', 'contract_number', 'nomenclature', 'nomenclature_package'], 'string', 'max' => 255],
            [['comment'], 'string'],
            [['accept_by_places', 'price_includes_vat'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'number' => 'Номер поставки',
            'date' => 'Дата поставки',
            'counterparty' => 'Контрагент',
            'arrival_date' => 'Дата поступления',
            'comment' => 'Комментарий',
            'vehicle_model' => 'Модель транспортного средства',
            'vehicle_number' => 'Госномер транспортного средства',
            'driver_name' => 'ФИО водителя',
            'driver_document' => 'Документ водителя',
            'contract_number' => 'Номер договора',
            'contract_date' => 'Дата договора',
            'nomenclature' => 'Номенклатура',
            'quantity' => 'Количество',
            'price' => 'Цена',
            'total_amount' => 'Общая сумма',

            // SupplierDetails maydonlari
            'kis_number' => 'Номер КИС',
            'kis_date' => 'Дата КИС',
            'accept_by_places' => 'Приемка по грузовым местам',
            'vehicle_type' => 'Тип транспортного средства',
            'vat_rate' => 'Ставка НДС',
            'vat_amount' => 'Сумма НДС',
            'price_includes_vat' => 'Цена включает НДС',
            'discount_amount' => 'Сумма скидки',
            'under_delivery_percent' => 'Процент недопоставки',
            'over_delivery_percent' => 'Процент перепоставки',

            // SupplierPackage maydonlari
            'nomenclature_package' => 'Упаковка номенклатуры',
            'package_quantity' => 'Количество упаковок',
        ];
    }

}