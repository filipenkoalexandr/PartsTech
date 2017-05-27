<?php


namespace AppBundle\Aggregate;


abstract class AbstractProductAggregate
{
    protected function substitutionTypes(array $types)
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);
        foreach ($properties as $var){
            foreach ($types as $type){
                if($this->{$var->getName()} instanceof $type){
                    $this->{$var->getName()} = $type;
                }
            }
        }
    }
}