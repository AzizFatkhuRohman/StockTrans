<?php

namespace App\Http\Controllers;

use App\Exports\customerExport;
use App\Imports\customerImport;
use App\Models\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    protected $customer;
    public function __construct(Customer $customer){
        $this->customer=$customer;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customer.index',[
            'title'=>'Customer'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create',[
            'title'=>'Create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:100|unique:customers,name'
        ],[
            'name.required'=>'Nama customer wajib di isi',
            'name.max'=>'Nama customer wajib di isi',
            'name.unique'=>'Nama customer sudah digunakan'
        ]);
        $this->customer->Store([
            'name'=>$request->name
        ]);
        return redirect('customer')->with('sukses','Customer berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->customer->Show($id);
        return view('customer.show',[
            'title'=>$data->name,
            'data'=>$data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:100|unique:customers,name'
        ],[
            'name.required'=>'Nama customer wajib di isi',
            'name.max'=>'Nama customer wajib di isi',
            'name.unique'=>'Nama customer sudah digunakan'
        ]);
        $this->customer->Store([
            'name'=>$request->name
        ]);
        return redirect('customer')->with('sukses','Customer berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->customer->Trash($id);
        return back()->with('sukses','Customer berhasil di hapus');
    }
    public function api(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->customer->Index(); // Ambil data vendor
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $url = url('customer/' . $row->id);
                    return '<div class="d-flex">
                                <a href="' . $url .'" class="btn btn-success btn-sm">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <form action="' . $url . '" method="POST" id="customer" class="ml-1">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="button" class="btn btn-danger btn-sm" onclick="cusDelete()">
                        <i class="ti ti-trash"></i>
                    </button>

                            </div>';
                })
                ->rawColumns(['action']) // Menyatakan bahwa kolom aksi berisi HTML
                ->make(true);
        }
    }
    public function import(Request $request){
        $val = Validator::make($request->all(),[
            'file'=>'required|file|mimes:xlsx,xls'
        ],[
            'file.required'=>'File wajib di isi',
            'file.mimes'=>'Format yang di izinkan xlsx,xls'
        ]);
        if ($val->fails()) {
            return back()->withErrors($val)->with('gagal','Kesalahan Input!');
        }
        Excel::import(new customerImport, $request->file('file'));
        return redirect('customer')->with('sukses','Data berhasil di import');
    }
    public function export(Request $request){
        $filter = $request->filter;
        return Excel::download(new customerExport($filter), 'data-customer-dicetak-pada-'.now()->format('Y-m-d-H-i-s').'.xlsx');
    }
}
