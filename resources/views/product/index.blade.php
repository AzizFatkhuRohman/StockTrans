@extends('layouts.app')
@section('main')
    <div class="card border">
        <div class="card-header d-flex justify-content-between">
            <h4>List Produk</h4>
           <div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Export Excel
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Export Excel</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('product/export') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <select class="form-select" aria-label="Default select example" name="filter" required>
                                        <option value="">Pilih Filter</option>
                                        <option value="Bulan ini">Bulan ini</option>
                                        <option value="Tahun ini">Tahun ini</option>
                                        <option value="Semua">Semua</option>
                                      </select>
                                      @error('filter')
                                          <span class="text-danger">{{$message}}</span>
                                      @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <a href="{{ url('product/create') }}" rel="noopener noreferrer" class="btn btn-primary"><i
                    class="ti ti-plus"></i></a>
           </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="productTable">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Vendor</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            // Inisialisasi DataTables
            $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('apiproduct') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'vendor',
                        name: 'vendor'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    } // Kolom aksi
                ]
            });
        });
    </script>
    <script>
        function proDelete() {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin menghapus ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('product').submit();
                }
            });
        }
      </script>
@endsection
