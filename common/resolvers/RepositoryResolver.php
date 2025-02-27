<?php declare(strict_types=1);

namespace common\resolvers;

use common\attributes\Repository;
use Exception;
use ReflectionClass;
use ReflectionException;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;

class RepositoryResolver
{
    /**
     * @throws ReflectionException
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     * @throws Exception
     */
    public static function resolve(string $modelClass): object
    {
        $reflection = new ReflectionClass($modelClass);
        $attributes = $reflection->getAttributes(Repository::class);

        if (!empty($attributes)) {
            $repositoryClass = $attributes[0]->newInstance()->repositoryClass;
            return Yii::$container->get($repositoryClass);
        }

        throw new Exception("Repository attribute not found for $modelClass");
    }

}