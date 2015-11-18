<?php

namespace SlimMicroService\Factory;

class FactoryAdapter
{
    public static function build($type)
    {
        return new \SlimMicroService\Adapter\AdapterDoctrine;
    }
}
