<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',[
            'title'=>'Dashboard'
        ]);
    }
    public function profile(){
        return view('profile',[
            'title'=>Auth::user()->name,
            'data'=>User::find(Auth::user()->id)
        ]);
    }
    public function ubahProfile(Request $request, $id){
        $request->validate([
            'name'=>'required|max:50',
            'email'=>'required|max:50'
        ],[
            'name.required'=>'Nama wajib diisi!',
            'name.max'=>'Nama maksimum 50 karakter',
            'email.required'=>'Email wajib diisi',
            'email.max'=>'Email maksimum 50 karakter'
        ]);
        User::find($id)->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);
        return back()->with('sukses','Profil berhasil diubah');
    }
    public function ubahPassword(Request $request, $id){
        $val = Validator::make($request->all(),[
            'password'=>'required|min:8|confirmed'
        ],[
            'password.required'=>'Password wajib diisi',
            'password.min'=>'Password minimum 8 karakter',
            'password.confirmed'=>'Password konfirmasi tidak sama'
        ]);
        if ($val->fails()) {
            return back()->withErrors($val)->with('gagal','Kesalahan Input');
        }
        User::find($id)->update([
            'password'=>Hash::make($request->password)
        ]);
        return back()->with('sukses','Password berhasil diubah');
    }
}
