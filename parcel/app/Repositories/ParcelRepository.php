<?php

namespace App\Repositories;


use App\Models\Parcel;
use App\Interfaces\RepositoryInterface;

class ParcelRepository implements RepositoryInterface
{
    public function store(array $data)
    {
        $parcel = Parcel::create($data);

        return $parcel;
    }

    public function show($id, array $append = null)
    {
        if (is_null($append)) {
            return Parcel::findOrFail($id);
        }

        return Parcel::with($append)->findOrFail($id);
    }

    public function update($parcel, array $data)
    {
        $parcel->fill($data);

        $parcel->save();

        return $parcel;
    }
}