<?php

namespace App\Exports;

use App\Models\Vendor;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class vendorExport implements FromCollection, WithHeadings
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
        $query = Vendor::query();
        if ($this->filter === 'Bulan ini') {
            $query->whereMonth('created_at',Carbon::now()->month);
        } elseif($this->filter === 'Tahun ini') {
            $query->whereYear('created_at',Carbon::now()->year);
        } else{
            $query;
        }
        $query->select('name','description');
        return $query->get();
    }
    public function headings(): array{
        return [
            'name','description'
        ];
    }
}
