<?php

namespace muyomu\aop\advice;

interface ReturnedAdvice
{
    public function adviceHandle(mixed $argv):void;
}