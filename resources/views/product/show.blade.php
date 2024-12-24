@extends('layouts.app')
@section('main')
    <div class="card border">
        <div class="card-header d-flex justify-content-between">
            <h4>Ubah Produk</h4>
        </div>
        <div class="card-body">
            <form action="{{url('product/'.$data->id)}}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Vendor</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="{{$data->vendor->name}}" readonly>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="code" value="{{$data->code}}">
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="name" value="{{$data->name}}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Harga beli (satuan)</label>
                        <input type="text" inputmode="numeric" class="form-control" id="exampleFormControlInput1" name="unit_purchase" value="{{$data->unit_purchase}}">
                        @error('unit_purchase')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Harga jual (satuan)</label>
                        <input type="text" inputmode="numeric" class="form-control" id="exampleFormControlInput1" name="unit_selling" value="{{$data->unit_selling}}">
                        @error('unit_selling')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Stok</label>
                        <input type="text" inputmode="numeric" class="form-control" id="exampleFormControlInput1" name="stock" value="{{$data->stock}}" readonly>
                        @error('stock')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">{{$data->description}}</textarea>
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
