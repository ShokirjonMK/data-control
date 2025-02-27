<?php

namespace console\services;

use console\interfaces\GeneratorInterface;
use ReflectionClass;

class DefinitionsModelGenerator implements GeneratorInterface
{
    public function generate($modelName, $path)
    {
        $modelClass = "common\\models\\$modelName";
        $model = new $modelClass;
        $requiredFields = [];
        $swaggerProperties = [];
        $allFields = [];

        // Parse model rules
        foreach ($model->rules() as $rule) {
            $fields = (array)$rule[0];
            $validator = $rule[1];

            foreach ($fields as $field) {
                if ($validator === 'required') {
                    $requiredFields[] = $field;
                }

                if (!in_array($field, $allFields)) {
                    $allFields[] = $field;
                    $fieldType = 'string'; // Default type is string

                    // Check the validator for field type
                    if ($validator === 'integer') {
                        $fieldType = 'integer';
                    } elseif ($validator === 'boolean') {
                        $fieldType = 'boolean';
                    }

                    // Add Swagger property
                    $swaggerProperties[] = " * @SWG\\Property(property=\"$field\", type=\"$fieldType\")\n";
                }
            }
        }

        $requiredFieldsStr = !empty($requiredFields) ? implode('", "', array_unique($requiredFields)) : '';
        $requiredFieldsStr = $requiredFieldsStr ? "{\"$requiredFieldsStr\"}" : '{}';
        $swaggerPropertiesStr = implode('', $swaggerProperties);

        // Generate content for Swagger definition
        $content = <<<PHP
<?php

namespace api\\modules\\v1\\models\\definitions;

/**
 * @SWG\Definition(required={$requiredFieldsStr})
 *
$swaggerPropertiesStr
 */
class {$modelName}
{

}

PHP;

        // Write to the file
        file_put_contents("$path/{$modelName}.php", $content);
    }
}
