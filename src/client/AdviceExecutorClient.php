<?php

namespace muyomu\aop\client;

use ReflectionClass;
use ReflectionMethod;

interface AdviceExecutorClient
{
    public function beforeAdviceExecutor(ReflectionClass $class, ReflectionMethod $method, mixed $instance):void;
}