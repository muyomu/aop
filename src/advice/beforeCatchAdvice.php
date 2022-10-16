<?php

namespace muyomu\aop\advice;

interface beforeCatchAdvice
{
    public function adviceHandle(mixed $argv):void;
}