@extends('layouts.app')
@section('main')
    <div class="card border">
        <div class="card-header d-flex justify-content-between">
            <h4>Tambah Transaksi</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('transaction') }}" method="post">
                @csrf
                <div class="row mb-2">
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">Produk</label>
                        <select class="form-select" aria-label="Default select example" name="product">
                            <option value="">Pilih Produk</option>
                            @foreach ($produk as $produk)
                                <option value="{{ $produk->id }}">{{ $produk->vendor->name }} - {{ $produk->name }}</option>
                            @endforeach
                        </select>
                        @error('product')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">QTY</label>
                        <input type="text" inputmode="numeric" class="form-control" id="exampleFormControlInput1" name="quantity">
                        @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
