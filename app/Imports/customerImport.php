<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class customerImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Customer([
            'name'=>$row['name']
        ]);
    }
}
