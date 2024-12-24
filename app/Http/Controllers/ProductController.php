<?php

namespace App\Http\Controllers;

use App\Exports\productExport;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    protected $product;
    public function __construct(Product $product){
        $this->product=$product;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product.index',[
            'title'=>'Product'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create',[
            'title'=>'Create',
            'vendor'=>Vendor::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required|max:6|unique:products,code',
            'name'=>'required|max:100',
            'unit_purchase'=>'required|numeric',
            'unit_selling'=>'required|numeric',
            'stock'=>'required|numeric',
            'description'=>'nullable|max:500'
        ],[
            'code.required'=>'Kode wajib di isi',
            'code.max'=>'Kode maksimum 6 karakter',
            'code.unique'=>'Kode sudah digunakan',
            'name.required'=>'Nama produk wajib di isi',
            'name.max'=>'Nama produk maksimum 100 karakter',
            'unit_purchase.required'=>'Harga beli wajib di isi',
            'unit_selling.required'=>'Harga jual wajib di isi',
            'stock.required'=>'Stok wajib di isi',
            'stock.numeric'=>'Stok wajib menggunakan angka',
            'description.max'=>'Deskripsi maksimum 500 karakter'
        ]);
        $this->product->Store([
            'vendor_id'=>$request->vendor,
            'code'=>$request->code,
            'name'=>$request->name,
            'unit_purchase'=>$request->unit_purchase,
            'unit_selling'=>$request->unit_selling,
            'stock'=>$request->stock,
            'description'=>$request->description
        ]);
        return redirect('product')->with('sukses','Produk berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->product->Show($id);
        return view('product.show',[
            'title'=>$data->name,
            'data'=>$data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code'=>'required|max:6',
            'name'=>'required|max:100',
            'unit_purchase'=>'required|numeric',
            'unit_selling'=>'required|numeric',
            'description'=>'nullable|max:500'
        ],[
            'code.required'=>'Kode wajib di isi',
            'code.max'=>'Kode maksimum 6 karakter',
            'name.required'=>'Nama produk wajib di isi',
            'name.max'=>'Nama produk maksimum 100 karakter',
            'unit_purchase.required'=>'Harga beli wajib di isi',
            'unit_selling.required'=>'Harga jual wajib di isi',
            'description.max'=>'Deskripsi maksimum 500 karakter'
        ]);
        $this->product->Edit($id,[
            'code'=>$request->code,
            'name'=>$request->name,
            'unit_purchase'=>$request->unit_purchase,
            'unit_selling'=>$request->unit_selling,
            'description'=>$request->description
        ]);
        return redirect('product')->with('sukses','Produk berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->product->Trash($id);
        return back()->with('sukses','Produk berhasil di hapus');
    }
    public function api(Request $request){
        if ($request->ajax()) {
            $data = $this->product->Index();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('vendor',function($row){
                return $row->vendor->name;
            })
            ->addColumn('action', function ($row) {
                $url = url('product/' . $row->id);
                return '<div class="d-flex">
                            <a href="' . $url .'" class="btn btn-success btn-sm">
                                <i class="ti ti-pencil"></i>
                            </a>
                            <form action="' . $url . '" method="POST" id="product" class="ml-1">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="button" class="btn btn-danger btn-sm" onclick="proDelete()">
                    <i class="ti ti-trash"></i>
                </button>

                        </div>';
            })
            ->rawColumns(['vendor','action'])
            ->make(true);
        }
    }
    public function export(Request $request){
        $filter = $request->filter;
        return Excel::download(new productExport($filter), 'data-produk-dicetak-pada-'.now()->format('Y-m-d-H-i-s').'.xlsx');
    }
}
