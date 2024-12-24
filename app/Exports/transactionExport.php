<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class transactionExport implements FromCollection,WithHeadings
{
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Mengambil koleksi data transaksi yang diekspor.
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Mulai query dari model Transaction dengan relasi 'vendor' dan 'product'
        $query = Transaction::with(['vendor', 'product']);

        // Filter berdasarkan bulan ini
        if ($this->filter === 'Bulan ini') {
            $query->whereMonth('transactions.created_at', Carbon::now()->month);
        // Filter berdasarkan tahun ini
        } elseif ($this->filter === 'Tahun ini') {
            $query->whereYear('transactions.created_at', Carbon::now()->year);
        }else{
            $query;
        }

        // Ambil kolom yang diperlukan dari Transaction, Vendor, dan Product
        $query->select(
            'transactions.quantity',
            'transactions.total_payment',
            'transactions.created_at',
            'vendors.name as vendor_name',
            'products.name as product_name'
        )
        // Pastikan melakukan join dengan tabel vendor dan produk
        ->join('vendors', 'transactions.vendor_id', '=', 'vendors.id')
        ->join('products', 'transactions.product_id', '=', 'products.id');

        // Ambil data transaksi beserta informasi vendor dan produk
        return $query->get()->map(function ($transaction) {
            return [
                'vendor_name' => $transaction->vendor_name,       // Nama vendor
                'product_name' => $transaction->product_name,     // Nama produk
                'quantity' => $transaction->quantity,                       // Jumlah barang
                'total_payment' => $transaction->total_payment,   // Total pembayaran
                'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),  // Tanggal transaksi
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
            'Vendor Name',   // Nama vendor
            'Product Name',  // Nama produk
            'Quantity',      // Jumlah barang
            'Total Payment', // Total pembayaran
            'Created At'     // Tanggal transaksi
        ];
    }
}
