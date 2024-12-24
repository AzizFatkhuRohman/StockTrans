<?php

namespace App\Imports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class vendorImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Vendor([
            'name'=>$row['name'],
            'description'=>$row['description']
        ]);
    }
}
