<?php

namespace backend\controllers;

use common\controllers\BaseController;
use Yii;
use yii\web\Controller;

class MigrationController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRunUp()
    {
        $output = $this->runCommand('migrate/up --interactive=0');
        return $this->render('index', ['output' => $output]);
    }

    public function actionRunDown()
    {
        $output = $this->runCommand('migrate/down 1 --interactive=0');
        return $this->render('index', ['output' => $output]);
    }

    public function actionNewMigration()
    {
        $name = Yii::$app->request->post('name');
        if ($name) {
            $output = $this->runCommand("migrate/create $name");
            return $this->render('index', ['output' => $output]);
        }
        return $this->render('index', ['output' => 'Please provide a migration name.']);
    }

    public function actionGenerate()
    {
        $tableName = Yii::$app->request->post('tableName');
        $columns = Yii::$app->request->post('columns', []);

        if (!$tableName || empty($columns)) {
            Yii::$app->session->setFlash('error', 'Table name and columns are required.');
            return $this->redirect(['index']);
        }

        $migrationName = 'm' . date('ymd_His') . '_create_' . $tableName . '_table';
        $migrationPath = Yii::getAlias('@console/migrations') . "/{$migrationName}.php";

        $migrationContent = $this->generateMigrationContent($tableName, $columns);
        file_put_contents($migrationPath, $migrationContent);

        Yii::$app->session->setFlash('success', "Migration '{$migrationName}' created successfully.");
        return $this->redirect(['index']);
    }

    private function runCommand($command)
    {
        $cmd = "php $command";
        $output = [];
        exec($cmd, $output);
        return implode("\n", $output);
    }
}