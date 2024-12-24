<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class productExport implements FromCollection,WithHeadings
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
        // Mulai query dari model Product dengan relasi 'vendor'
        $query = Product::with('vendor'); // Mengambil relasi vendor

        // Filter berdasarkan bulan ini
        if ($this->filter === 'Bulan ini') {
            $query->whereMonth('products.created_at', Carbon::now()->month);
        // Filter berdasarkan tahun ini
        } elseif ($this->filter === 'Tahun ini') {
            $query->whereYear('products.created_at', Carbon::now()->year);
        } else{
            $query;
        }

        // Ambil kolom yang diperlukan dari Product dan Vendor dengan Join
        $query->select(
            'products.name as product_name', // Alias untuk name produk
            'products.code',
            'products.unit_purchase',
            'products.unit_selling',
            'products.stock',
            'products.description',
            'products.created_at',
            'products.updated_at',
            'vendors.name as vendor_name'
        )
        // Pastikan melakukan join dengan tabel vendor
        ->join('vendors', 'products.vendor_id', '=', 'vendors.id');

        // Ambil data produk beserta informasi vendor
        return $query->get()->map(function($product) {
            return [
                'product_name' => $product->product_name,               // Nama produk
                'vendor_name' => $product->vendor_name ?? '',           // Kode vendor
                'unit_purchase' => $product->unit_purchase,             // Unit pembelian
                'unit_selling' => $product->unit_selling,               // Unit penjualan
                'stock' => $product->stock,                             // Stok
                'description' => $product->description,                 // Deskripsi
                'created_at' => $product->created_at->format('Y-m-d H:i:s'),  // Tanggal dibuat
                'updated_at' => $product->updated_at->format('Y-m-d H:i:s')   // Tanggal diperbarui
            ];
        });
    }

    /**
     * Menentukan header kolom untuk file Excel.
     * @return array
     */
    public function headings(): array
    {
        return [
            'Product Name',      // Nama produk
            'Vendor Name',       // Nama vendor
            'Vendor Code',       // Kode vendor
            'Unit Purchase',     // Unit Pembelian
            'Unit Selling',      // Unit Penjualan
            'Stock',             // Stok
            'Description',       // Deskripsi
            'Created At',        // Tanggal dibuat
            'Updated At'         // Tanggal diperbarui
        ];
    }
}
