<?php

namespace muyomu\aop\advice;

use ReflectionClass;
use ReflectionMethod;

interface FrameWork
{
    public function aopExecutor(mixed $instance, ReflectionMethod $method,mixed $args):mixed;
}