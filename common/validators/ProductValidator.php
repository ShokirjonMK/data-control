<?php declare(strict_types=1);

namespace common\validators;

use common\models\Product;
use Yii;
use yii\validators\Validator;

class ProductValidator extends Validator
{
    public function init(): void
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Product data is incorrect.';
        }
    }

    public function validateAttribute($model, $attribute): void
    {
        $data = $model->$attribute;

        if (!is_array($data)) {
            $this->addError($model, $attribute,  'Data must be in array format.');
            return;
        }

        foreach ($data as $index => $productData) {
            $productModel = new Product();
            $productModel->attributes = $productData;

            if (!$productModel->validate()) {
                foreach ($productModel->getErrors() as $field => $errors) {
                    foreach ($errors as $error) {
                        $this->addError($model, $attribute, Yii::t('app', "Product_{index}: {field} : {error}", [
                            'index' => $index + 1,
                            'field' => $field,
                            'error' => $error,
                        ]));
                    }
                }
            }
        }
    }

    public function validateValue($value): bool
    {
        if (empty($value)) {
            $this->addError($value, 'value', 'Value cannot be empty.');
            return false;
        }
        return true;
    }
}
