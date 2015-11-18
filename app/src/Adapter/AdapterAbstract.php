<?php

namespace SlimMicroService\Adapter;

use SlimMicroService\Adapter\AdapterInterface;

abstract class AdapterAbstract implements AdapterInterface
{
    protected function getArguments($request)
    {
        $args       = array();
        $attributes = $request->getAttributes();

        if(TRUE === isset($attributes['route'])){
            $args = $attributes['route']->getArguments();
        }

        return $args;
    }
}
