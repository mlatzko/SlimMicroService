<?php

namespace SlimMicroService\Adapter;

use SlimMicroService\Adapter\AdapterAbstract;

class AdapterDoctrine extends AdapterAbstract
{
    public function create($request)
    {

    }

    public function read($request)
    {
        return array('id' => 1, 'name' => 'Mathias Latzko');
    }

    public function update($request)
    {

    }

    public function delete($reques)
    {

    }
}
