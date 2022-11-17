<?php

namespace muyomu\aop;

use Exception;
use muyomu\aop\advice\FrameWork;
use muyomu\aop\advicetype\AfterAdvice;
use muyomu\aop\advicetype\BeforeAdvice;
use muyomu\aop\advicetype\BeforeCatchAdvice;
use muyomu\aop\advicetype\Hystrix;
use muyomu\aop\advicetype\ReturnedAdvice;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class FrameWorkClient implements FrameWork
{

    /**
     * @throws ReflectionException
     */
    public function aopExecutor(ReflectionClass $class, mixed $instance, ReflectionMethod $method, mixed $args): mixed
    {
        $beforeAdvice = $method->getAttributes(BeforeAdvice::class);
        $afterAdvice = $method->getAttributes(AfterAdvice::class);
        $returnedAdvice = $method->getAttributes(ReturnedAdvice::class);
        $beforeCatchAdvice = $method->getAttributes(BeforeCatchAdvice::class);
        $Hystrix = $method->getAttributes(Hystrix::class);

        if (!empty($beforeAdvice)){
            $advice = $beforeAdvice[0]->newInstance();
            $adviceClass = $advice->getAdviceClassName();
            $adviceClass_class = new ReflectionClass($adviceClass);
            $adviceClass_instance = $adviceClass_class->newInstance();
            $adviceClass_handle = $adviceClass_class->getMethod("adviceHandle");
            $adviceClass_handle->invoke($adviceClass_instance,$args);
        }

        try {
            $data = $method->invokeArgs($instance,$args);
        }catch (Exception $exception){
            if (!empty($beforeCatchAdvice)){
                $advice = $beforeCatchAdvice[0]->newInstance();
                $adviceClass = $advice->getAdviceClassName();
                $adviceClass_class = new ReflectionClass($adviceClass);
                $adviceClass_instance = $adviceClass_class->newInstance();
                $adviceClass_handle = $adviceClass_class->getMethod("adviceHandle");
                $adviceClass_handle->invoke($adviceClass_instance,$args);
            }
            if(!empty($Hystrix)){
                $advice = $Hystrix[0]->newInstance();
                $adviceClass = $advice->getAdviceClassName();
                $adviceClass_class = new ReflectionClass($adviceClass);
                $adviceClass_instance = $adviceClass_class->newInstance();
                $adviceClass_handle = $adviceClass_class->getMethod("getData");
                return $adviceClass_handle->invoke($adviceClass_instance,$args);
            }
            throw $exception;
        }

        if (!empty($afterAdvice)){
            $advice = $afterAdvice[0]->newInstance();
            $adviceClass = $advice->getAdviceClassName();
            $adviceClass_class = new ReflectionClass($adviceClass);
            $adviceClass_instance = $adviceClass_class->newInstance();
            $adviceClass_handle = $adviceClass_class->getMethod("adviceHandle");
            $adviceClass_handle->invoke($adviceClass_instance,$args);
        }

        if (!empty($returnedAdvice)){
            $advice = $returnedAdvice[0]->newInstance();
            $adviceClass = $advice->getAdviceClassName();
            $adviceClass_class = new ReflectionClass($adviceClass);
            $adviceClass_instance = $adviceClass_class->newInstance();
            $adviceClass_handle = $adviceClass_class->getMethod("adviceHandle");
            $adviceClass_handle->invoke($adviceClass_instance,$args);
        }
        return $data;
    }
}