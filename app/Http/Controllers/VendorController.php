<?php

namespace App\Http\Controllers;

use App\Exports\vendorExport;
use App\Imports\vendorImport;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Yajra\DataTables\DataTables;

class VendorController extends Controller
{
    protected $vendor;
    public function __construct(Vendor $vendor){
        $this->vendor=$vendor;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vendor.index',[
            'title'=>'Vendor'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.create',[
            'title'=>'Create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:100|unique:vendors,name',
            'description'=>'nullable|max:500'
        ],[
            'name.required'=>'Nama vendor wajib di isi',
            'name.max'=>'Nama vendor maksimum 100 karakter',
            'name.unique'=>'Nama vendor sudah digunakan',
            'description.max'=>'Deskripsi maksimum 500 karakter'
        ]);
        $this->vendor->Store([
            'name'=>$request->name,
            'description'=>$request->description
        ]);
        return redirect('vendor')->with('sukses','Vendor berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->vendor->Show($id);
        return view('vendor.show',[
            'title'=>$data->name,
            'data'=>$data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:100',
            'description'=>'nullable|max:500'
        ],[
            'name.required'=>'Nama vendor wajib di isi',
            'name.max'=>'Nama vendor maksimum 100 karakter',
            'description.max'=>'Deskripsi maksimum 500 karakter'
        ]);
        $this->vendor->Edit($id,[
            'name'=>$request->name,
            'description'=>$request->description
        ]);
        return redirect('vendor')->with('sukses','Vendor berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->vendor->Trash($id);
        return back()->with('sukses','Vendor berhasil di hapus');
    }
    public function api(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->vendor->Index(); // Ambil data vendor
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $url = url('vendor/' . $row->id);
                    return '<div class="d-flex">
                                <a href="' . $url .'" class="btn btn-success btn-sm">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <form action="' . $url . '" method="POST" id="vendor" class="ml-1">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="button" class="btn btn-danger btn-sm" onclick="vendorDelete()">
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
        Excel::import(new vendorImport, $request->file('file'));
        return redirect('vendor')->with('sukses','Data berhasil di import');
    }
    public function export(Request $request){
        $filter = $request->filter;
        return Excel::download(new vendorExport($filter), 'data-vendor-dicetak-pada-'.now()->format('Y-m-d-H-i-s').'.xlsx');
    }
}
