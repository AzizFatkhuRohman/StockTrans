@extends('layouts.app')
@section('main')
    <div class="card border">
        <div class="card-header d-flex justify-content-between">
            <h4>Edit Vendor</h4>
        </div>
        <div class="card-body">
            <form action="{{url('vendor/'.$data->id)}}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama vendor</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name" value="{{$data->name}}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">{{$data->description}}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
