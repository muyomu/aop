<?php

namespace muyomu\aop\utility;

use muyomu\aop\advicetype\BeforeAdvice;
use muyomu\aop\client\AdviceExecutorClient;
use ReflectionClass;
use ReflectionMethod;

class AdviceExecutor implements AdviceExecutorClient
{

    public function beforeAdviceExecutor(ReflectionClass $class,ReflectionMethod $method, mixed $instance): void
    {
        $beforeAdvice = $method->getAttributes(BeforeAdvice::class);
        if (!empty($beforeAdvice)){
            $advice = $beforeAdvice[0]->newInstance();
            $adviceClass = $advice->getAdviceClassName();
            $adviceClass_class = new ReflectionClass($adviceClass);
            $adviceClass_instance = $adviceClass_class->newInstance();
            if ($adviceClass_instance instanceof \muyomu\aop\advice\BeforeAdvice){
                if ($adviceClass_instance instanceof $class){
                    $adviceClass_handle = $adviceClass_class->getMethod("adviceHandle");
                    $adviceClass_handle->invoke($adviceClass_instance);
                }else{

                }
            }else{

            }

        }
    }
}