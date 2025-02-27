<?php

namespace console\interfaces;
interface GeneratorInterface
{
    public function generate($modelName, $path);
}