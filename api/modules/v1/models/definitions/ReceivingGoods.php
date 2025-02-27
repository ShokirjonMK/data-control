<?php

namespace api\modules\v1\models\definitions;

/**
 * @SWG\Definition(required={"number", "date", "counterparty", "nomenclature", "quantity", "price", "total_amount"})
 *
 * @SWG\Property(property="number", type="string")
 * @SWG\Property(property="date", type="string")
 * @SWG\Property(property="counterparty", type="string")
 * @SWG\Property(property="nomenclature", type="string")
 * @SWG\Property(property="quantity", type="string")
 * @SWG\Property(property="price", type="string")
 * @SWG\Property(property="total_amount", type="string")
 * @SWG\Property(property="arrival_date", type="string")
 * @SWG\Property(property="kis_date", type="string")
 * @SWG\Property(property="contract_date", type="string")
 * @SWG\Property(property="package_quantity", type="integer")
 * @SWG\Property(property="vat_rate", type="string")
 * @SWG\Property(property="vat_amount", type="string")
 * @SWG\Property(property="discount_amount", type="string")
 * @SWG\Property(property="under_delivery_percent", type="string")
 * @SWG\Property(property="over_delivery_percent", type="string")
 * @SWG\Property(property="vehicle_model", type="string")
 * @SWG\Property(property="vehicle_number", type="string")
 * @SWG\Property(property="driver_name", type="string")
 * @SWG\Property(property="driver_document", type="string")
 * @SWG\Property(property="contract_number", type="string")
 * @SWG\Property(property="nomenclature_package", type="string")
 * @SWG\Property(property="comment", type="string")
 * @SWG\Property(property="accept_by_places", type="boolean")
 * @SWG\Property(property="price_includes_vat", type="boolean")

 */
class ReceivingGoods
{

}
