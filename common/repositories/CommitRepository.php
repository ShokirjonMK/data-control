<?php declare(strict_types=1);

namespace common\repositories;

use common\models\Commit;
use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;

class CommitRepository
{
    private Commit $model;

    public function __construct()
    {
        $this->model = new Commit();
    }

    public function findById(int $id): ?Commit
    {
        return $this->model::findOne($id);
    }

    public function findAll(): array
    {
        return $this->model::find()->all();
    }

    /**
     * @throws Exception
     */
    public function save(Commit $book): bool
    {
        if (!$book->validate()) {
            return false;
        }
        return $book->save();
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function delete(int $id): bool
    {
        $book = $this->findById($id);
        if (!$book) {
            return false;
        }
        return $book->delete() !== false;
    }
}