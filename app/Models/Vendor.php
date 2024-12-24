<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory,HasUuids;
    protected $guarded = [];
    public function product(){
        return $this->hasMany(Product::class);
    }
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
    public function Index(){
        return $this->latest();
    }
    public function Show($id){
        return $this->find($id);
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
