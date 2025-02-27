<?php

namespace backend\controllers;

use common\controllers\BaseController;
use Yii;
use yii\web\Controller;

class MigrationGeneratorController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGenerate()
    {
        $tableName = Yii::$app->request->post('tableName');
        $columnsRaw = Yii::$app->request->post('columns', []);

        if (!$tableName || empty($columnsRaw)) {
            Yii::$app->session->setFlash('error', 'Table name and columns are required.');
            return $this->redirect(['index']);
        }

        $columns = $this->restructureColumns($columnsRaw);

        $migrationName = 'm' . date('ymd_His') . '_create_' . $tableName . '_table';
        $migrationPath = Yii::getAlias('@common/migrations/db') . "/{$migrationName}.php";

        $migrationContent = $this->generateMigrationContent($tableName, $columns, $migrationName);
        file_put_contents($migrationPath, $migrationContent);

        Yii::$app->session->setFlash('success', "Migration '{$migrationName}' created successfully.");
        return $this->redirect(['index']);
    }

    private function restructureColumns($columnsRaw)
    {
        $columns = [];
        $temp = [];

        foreach ($columnsRaw as $index => $item) {

            $key = key($item);
            $value = $item[$key];

            $temp[$key] = $value;

            if (count($temp) === 7) {
                $columns[] = $temp;
                $temp = [];
            }
        }

        return $columns;
    }

    private function generateMigrationContent($tableName, $columns, $migrationName)
    {
        $columnDefinitions = "";
        $foreignKeys = "";

        $dropForeignKey = "";



        foreach ($columns as $column) {
            $name = $column['name'];
            $type = $column['type'];
            $length = !empty($column['length']) ? "({$column['length']})" : "";
            $null = $column['nullable'] === 'true' ? 'null' : 'notNull';
            $default = !empty($column['default']) ? "->defaultValue('{$column['default']}')" : "";
            $columnDefinitions .= "            '$name' => \$this->$type$length->$null()$default,\n";

            if (!empty($column['foreign_table']) && !empty($column['foreign_column'])) {
                $foreignKeys .= "        \$this->addForeignKey(
                    'fk_{$tableName}_{$name}', 
                    '{$tableName}', 
                    '{$name}', 
                    '{$column['foreign_table']}', 
                    '{$column['foreign_column']}'
                );\n";

                $dropForeignKey .= "  \$this->dropForeignKey('fk_{$tableName}_{$name}', '{$column['foreign_table']}');\n";
            }


        }

        return <<<PHP
<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%{$tableName}}}`.
 */
class {$migrationName} extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \$this->createTable('{{%{$tableName}}}', [
        'id' => \$this->primaryKey(),
$columnDefinitions
        ]);

$foreignKeys
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Foreign keysni tushirish
$dropForeignKey

        \$this->dropTable('{{%{$tableName}}}');
    }
}
PHP;
    }
}
