<?php

namespace api\modules\v1\models\definitions;

/**
 * @SWG\Definition(required={"group", "code", "name", "full_name"})
 *
 * @SWG\Property(property="group", type="string")
 * @SWG\Property(property="code", type="string")
 * @SWG\Property(property="name", type="string")
 * @SWG\Property(property="full_name", type="string")
 * @SWG\Property(property="name_eng", type="string")
 * @SWG\Property(property="stock_percentage", type="number")
 * @SWG\Property(property="stock_expiry", type="integer")
 * @SWG\Property(property="legal_entity", type="boolean")
 * @SWG\Property(property="inn", type="string")
 * @SWG\Property(property="kpp", type="string")
 * @SWG\Property(property="okpo", type="string")
 * @SWG\Property(property="is_supplier", type="boolean")
 * @SWG\Property(property="is_buyer", type="boolean")
 * @SWG\Property(property="main_delivery_address", type="string")
 * @SWG\Property(property="depositor", type="boolean")
 * @SWG\Property(property="contract_number", type="string")
 * @SWG\Property(property="contract_date", type="date")
 * @SWG\Property(property="bank_details", type="string")
 * @SWG\Property(property="contact_info", type="string")
 * @SWG\Property(property="additional_details", type="string")
 */
class Purveyor
{

}
