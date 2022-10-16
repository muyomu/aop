<?php

namespace muyomu\aop\advice;

interface AfterAdvice
{
    public function adviceHandle(mixed $argv):void;
}