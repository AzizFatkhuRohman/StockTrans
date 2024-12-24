@extends('layouts.app')
@section('main')
    <div class="card border">
        <div class="card-header d-flex justify-content-between">
            <h4>Ubah Transaksi</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('transaction/'.$data->id) }}" method="post">
                @csrf
                @method('put')
                <div class="row mb-2">
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">Produk</label>
                        <input type="text" inputmode="numeric" class="form-control" id="exampleFormControlInput1" value="{{$data->vendor->name}} - {{$data->product->name}}" readonly>
                        @error('product')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">QTY</label>
                        <input type="text" inputmode="numeric" class="form-control" id="exampleFormControlInput1" name="quantity" value="{{$data->quantity}}">
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
