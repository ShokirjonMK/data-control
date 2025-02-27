<?php declare (strict_types = 1);

namespace common\attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Repository
{
    public function __construct(public string $repositoryClass) {}
}