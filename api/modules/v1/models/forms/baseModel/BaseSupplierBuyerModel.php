<?php declare(strict_types=1);

namespace api\modules\v1\models\forms\baseModel;

use yii\base\Model;

abstract class BaseSupplierBuyerModel extends Model
{
    public $id;
    public $group; // Yetkazib beruvchi yoki xaridor guruhi uchun.
    public $code; // Yetkazib beruvchi yoki xaridor kodi.
    public $name; // Yetkazib beruvchi yoki xaridor nomi
    public $full_name; // Yetkazib beruvchi yoki xaridor to'liq nomi
    public $name_eng; // Ingliz tilidagi nomi
    public $stock_percentage; // Yaroqlilik zaxirasi foizi
    public $stock_expiry; // Yaroqlilik muddati
    public $legal_entity; // Yuridik/jismoniy shaxs
    public $inn; // Soliq to'lovchining identifikatsiya raqami
    public $kpp; // Kompaniya ro'yxatidan o'tgan kod
    public $okpo; // Korxona kodlari klassifikatori
    public $is_supplier; // Yetkazib beruvchi
    public $is_buyer; // Xaridor
    public $main_delivery_address; // Asosiy yetkazib berish manzili
    public $depositor; // Omborchi
    public $contract_number; // Shartnoma raqami
    public $contract_date; // Shartnoma sanasi
    public $bank_details; // Bank rekvizitlari
    public $contact_info; // Aloqa ma'lumotlari
    public $additional_details; // Qo'shimcha rekvizitlar

    public $parent_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group', 'code', 'name', 'full_name'], 'required'],
            [['stock_percentage'], 'number'],
            [['stock_expiry', 'id', 'parent_id'], 'integer'],
            [['legal_entity', 'is_supplier', 'is_buyer', 'depositor'], 'boolean'],
            [['contract_date'], 'date', 'format' => 'php:Y-m-d'],
            [['bank_details', 'contact_info', 'additional_details'], 'string'],
            [['group', 'name', 'full_name', 'name_eng', 'main_delivery_address'], 'string', 'max' => 255],
            [['code', 'contract_number'], 'string', 'max' => 100],
            [['inn', 'kpp', 'okpo'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'group' => 'Группа поставщика / покупателя',
            'code' => 'Код поставщика / покупателя',
            'name' => 'Наименование поставщика / покупателя',
            'full_name' => 'Полное наименование поставщика / покупателя',
            'name_eng' => 'Наименование (англ.)',
            'stock_percentage' => 'Процент запаса годности',
            'stock_expiry' => 'Срок запаса годности',
            'legal_entity' => 'Юр/ФизЛицо',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'okpo' => 'ОКПО',
            'parent_id' => 'Parent Id',
            'is_supplier' => 'Поставщик)', // (Да/Нет)
            'is_buyer' => 'Покупатель', // (Да/Нет)
            'main_delivery_address' => 'Основной адрес доставки',
            'depositor' => 'Поклажедатель', // (Да/Нет)
            'contract_number' => 'Договор номер',
            'contract_date' => 'Договор Дата',
            'bank_details' => 'Банковские реквизиты',
            'contact_info' => 'Контактная информация',
            'additional_details' => 'Дополнительные реквизиты',
        ];
    }

}
