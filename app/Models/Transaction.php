<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory,HasUuids;
    protected $guarded = [];
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function Index(){
        return $this->with('vendor','product')->latest();
    }
    public function Show($id){
        return $this->with('vendor','product')->find($id);
    }
    public function Store($data){
        return $this->create($data);
    }
    public function Edit($id,$data){
        return $this->find($id)->update($data);
    }
    public function Trash($id){
        return $this->find($id)->delete();
    }
}
