<?php

namespace App\Exports;

use App\Models\Customer;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class customerExport implements FromCollection, WithHeadings
{
    protected $filter;
    public function __construct($filter){
        $this->filter = $filter;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Customer::query();
        if ($this->filter === 'Bulan ini') {
            $query->whereMonth('created_at',Carbon::now()->month);
        } elseif($this->filter === 'Tahun ini') {
            $query->whereYear('created_at',Carbon::now()->year);
        } else{
            $query;
        }
        $query->select('name');
        return $query->get();
    }
    public function headings(): array{
        return [
            'name'
        ];
    }
}

