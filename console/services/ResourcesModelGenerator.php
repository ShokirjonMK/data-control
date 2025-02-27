<?php

namespace console\services;

use console\interfaces\GeneratorInterface;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class ResourcesModelGenerator implements GeneratorInterface
{
    public function generate($modelName, $path)
    {
        // Fetch model attributes using reflection
        $modelClass = "common\\models\\$modelName";
        $model = new $modelClass;
        $fields = [];

        foreach ($model->rules() as $rule) {
            $fields = array_merge($fields, (array)$rule[0]);
        }
        $fields = array_unique($fields); // Ensure unique fields
        $fieldsStr = implode("', '", $fields);
        $fieldsStr = "'id', '" . $fieldsStr . "'";

        $lowerModelName = strtolower($modelName);

        // Create dynamic resource model content
        $content = <<<PHP
<?php

namespace api\\modules\\v1\\resources;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class {$modelName} extends \\common\\models\\{$modelName} implements Linkable
{
    public function fields()
    {
        return [$fieldsStr];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['{$lowerModelName}/view', 'id' => \$this->id], true)
        ];
    }
}

PHP;

        // Write to the file
        file_put_contents("$path/{$modelName}.php", $content);
    }
}
