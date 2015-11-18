<?php

namespace SlimMicroService\Adapter;

interface AdapterInterface
{
    public function create($request);
    public function read($request);
    public function update($request);
    public function delete($request);
}
