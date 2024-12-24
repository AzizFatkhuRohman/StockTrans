@extends('layouts.app')
@section('main')
    <div class="card border">
        <div class="card-header d-flex justify-content-between">
            <h4>Tambah Produk</h4>
        </div>
        <div class="card-body">
            <form action="{{url('product')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Vendor</label>
                    <select class="form-select" aria-label="Default select example" name="vendor">
                        <option value="">Pilih vendor</option>
                        @foreach ($vendor as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      </select>
                    @error('vendor')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="code">
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Harga beli (satuan)</label>
                        <input type="text" inputmode="numeric" class="form-control" id="exampleFormControlInput1" name="unit_purchase">
                        @error('unit_purchase')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Harga jual (satuan)</label>
                        <input type="text" inputmode="numeric" class="form-control" id="exampleFormControlInput1" name="unit_selling">
                        @error('unit_selling')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Stok</label>
                        <input type="text" inputmode="numeric" class="form-control" id="exampleFormControlInput1" name="stock">
                        @error('stock')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                    @error('description')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
