<?php

namespace App\Http\Controllers;

use App\Exports\transactionExport;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    protected $transaction;
    protected $product;
    public function __construct(Transaction $transaction, Product $product){
        $this->transaction=$transaction;
        $this->product=$product;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaction.index',[
            'title'=>'Transaksi'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaction.create',[
            'title'=>'Create',
            'produk'=>Product::with('vendor')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product'=>'required',
            'quantity'=>'required|numeric'
        ],[
            'product.required'=>'Produk wajib di pilih',
            'quantity.required'=>'Quantitas wajib di isi'
        ]);
        $produk = $this->product->Show($request->product);
        $this->transaction->Store([
            'vendor_id'=>$produk->vendor_id,
            'product_id'=>$request->product,
            'quantity'=>$request->quantity,
            'total_payment'=>$produk->unit_selling * $request->quantity
        ]);
        $this->product->Edit($request->product,[
            'stock'=>$produk->stock - $request->quantity
        ]);
        return redirect('transaction')->with('sukses','Transaksi berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->transaction->Show($id);
        return view('transaction.show',[
            'title'=>$data->product->name,
            'data'=>$data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity'=>'required|numeric'
        ],[
            'quantity.required'=>'Quantitas wajib di isi'
        ]);
        $data = $this->transaction->Show($id);
        $produk = $this->product->Show($data->product_id);
        $this->transaction->Edit($id,[
            'quantity'=>$request->quantity,
            'total_payment'=>$produk->unit_selling * $request->quantity
        ]);
        $this->product->Edit($data->product_id,[
            'stock'=>$produk->stock - $request->quantity
        ]);
        return redirect('transaction')->with('sukses','Transaksi berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->transaction->Trash($id);
        return back()->with('sukses','Transaksi berhasil di hapus');
    }
    public function api(Request $request){
        if ($request->ajax()) {
            $data=$this->transaction->Index();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('vendor',function($row){
                return $row->vendor->name;
            })
            ->addColumn('produk',function($row){
                return $row->product->name;
            })
            ->addColumn('action', function ($row) {
                $url = url('transaction/' . $row->id);
                return '<div class="d-flex">
                            <a href="' . $url .'" class="btn btn-success btn-sm">
                                <i class="ti ti-pencil"></i>
                            </a>
                            <form action="' . $url . '" method="POST" id="transaction" class="ml-1">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="button" class="btn btn-danger btn-sm" onclick="transactionDelete()">
                    <i class="ti ti-trash"></i>
                </button>

                        </div>';
            })
            ->rawColumns(['action']) // Menyatakan bahwa kolom aksi berisi HTML
            ->make(true);
        }
    }
    public function export(Request $request){
        $filter = $request->filter;
        return Excel::download(new transactionExport($filter), 'data-transaksi-dicetak-pada-'.now()->format('Y-m-d-H-i-s').'.xlsx');
    }
}
