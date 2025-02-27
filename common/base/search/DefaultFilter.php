<?php declare(strict_types=1);

namespace common\base\search;

use common\base\search\interfaces\FilterInterface;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class DefaultFilter implements FilterInterface
{

    /**
     * List of attributes that should be filtered using LIKE.
     */
    private array $likeFilters = ['name', 'description'];

    public function apply(ActiveQuery $query, ActiveRecord $model): void
    {
        $filters = Yii::$app->request->get();

        foreach ($filters as $attribute => $value) {
            // Get the table and its attributes
            [$tableName, $validAttributes] = $this->resolveTableAndAttributes($attribute, $model);

            if ($tableName && in_array($attribute, $validAttributes) && $value !== '') {
                // Check if the attribute is in likeFilters and apply the appropriate filter
                if (in_array($attribute, $this->likeFilters)) {
                    $query->andFilterWhere(['ilike', "$tableName.$attribute", '%' . $value . '%', false]);
                } else {
                    $query->andFilterWhere(["$tableName.$attribute" => $value]);
                }
            }
        }
    }

    /**
     * Resolve the table name and attributes for a given attribute.
     * @param string $attribute
     * @param ActiveRecord $model
     * @return array
     */
    private function resolveTableAndAttributes(string $attribute, ActiveRecord $model): array
    {
        if (str_contains($attribute, '.')) {
            [$modelName, $attr] = explode('.', $attribute, 2);
            $modelInstance = $this->getTableNameFromModelName($modelName);

            if ($modelInstance) {
                return [$modelInstance->tableName(), $modelInstance->attributes()];
            }
        }

        return [$model->tableName(), $model->attributes()];
    }

    /**
     * Get the table name from a model name.
     * @param string $modelName
     * @return ActiveRecord|null
     */
    private function getTableNameFromModelName(string $modelName): ?ActiveRecord
    {
        // Convert model name from snake_case to CamelCase
        $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $modelName)));
        $modelClass = 'common\\models\\' . $className;

        // Check if the class exists and return an instance
        return class_exists($modelClass) ? new $modelClass() : null;
    }
}
