<?php
/*
 * created by Muxtorov Tulqin
 */
namespace console\controllers;

use console\interfaces\GeneratorInterface;
use console\services\CrudControllerGenerator;
use console\services\DefinitionsModelGenerator;
use console\services\ResourcesModelGenerator;
use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;

// docker compose exec php console/yii crud-swagger-generator/generate  common\\models\\Article

class CrudSwaggerGeneratorController extends Controller
{
    public function actionGenerate($modelClass): void
    {
        if (!class_exists($modelClass)) {
            $this->stderr("Model class '$modelClass' not found.\n");
            return;
        }

        $reflector = new \ReflectionClass($modelClass);
        $modelName = $reflector->getShortName();

        $resourcesPath = Yii::getAlias('@api/modules/v1/resources');
        $definitionsPath = Yii::getAlias('@api/modules/v1/models/definitions');
        $controllerPath = Yii::getAlias('@api/modules/v1/controllers');

        FileHelper::createDirectory($resourcesPath);
        FileHelper::createDirectory($definitionsPath);
        FileHelper::createDirectory($controllerPath);

        $this->generateFile(new ResourcesModelGenerator(), $modelName, $resourcesPath);
        $this->generateFile(new DefinitionsModelGenerator(), $modelName, $definitionsPath);
        $this->generateFile(new CrudControllerGenerator(), $modelName, $controllerPath);

        $this->stdout("Files for '$modelName' have been generated.\n");
    }

    private function generateFile(GeneratorInterface $generator, string $modelName, string $path): void
    {
        if ($generator instanceof ResourcesModelGenerator ||
            $generator instanceof DefinitionsModelGenerator ||
            $generator instanceof CrudControllerGenerator
        )
        {
            $generator->generate($modelName, $path);
        }
    }

}
