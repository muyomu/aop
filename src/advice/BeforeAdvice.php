<?php

namespace muyomu\aop\advice;

interface BeforeAdvice
{
    public function adviceHandle(mixed $argv):void;
}