<?php

namespace api\modules\v1\models\forms\baseModel;

use yii\base\Model;

abstract class BaseStatusModel extends Model
{
    public $status;

    abstract protected function getStatusField(): string;

    abstract protected function getModelClass(): string;

    public function rules(): array
    {
        return [
            [['status'], 'required'],
            [['status'], 'validateStatusData'],
        ];
    }

    public function validateStatusData($attribute, $params): void
    {
        if (!is_array($this->status)) {
            $this->addError($attribute, 'Status data must be an array.');
            return;
        }

        foreach ($this->status as $item) {
            if (!isset($item['id'], $item['status']) || !is_int($item['id']) || !is_string($item['status'])) {
                $this->addError($attribute, 'Each item must contain integer "id" and string "status" fields.');
                return;
            }

            if ($item['id'] <= 0) {
                $this->addError($attribute, 'Each "id" must be a positive integer greater than 0.');
                return;
            }
        }
    }

    public function editData(): void
    {
        $statusField = $this->getStatusField();
        $modelClass = $this->getModelClass();

        $idsToUpdate = array_column(array_filter($this->status, function ($item) {
            return $item['status'] === 'ok';
        }), 'id');

        if (!empty($idsToUpdate)) {
            $modelClass::updateAll(
                [$statusField => $modelClass::STATUS_DELIVERED],
                ['id' => $idsToUpdate, $statusField => $modelClass::STATUS_NEW]
            );
        }
    }
}
