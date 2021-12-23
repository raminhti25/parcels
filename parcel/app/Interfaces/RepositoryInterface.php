<?php

namespace App\Interfaces;


interface RepositoryInterface
{
    public function store(array $data);
    public function show($id, array $append = null);
    public function update($parcel, array $data);
}