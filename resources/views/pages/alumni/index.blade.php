@extends('layouts.app')

@section('title', 'Alumni')
@section('desc', 'Di halaman ini anda bisa mengelola alumni. ')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Daftar Alumni</h4>
            <div class="card-header-action">
                <a href="{{ route('alumni.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    Add New
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped w-100" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Tahun Lulus</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            var datatable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: {
                    url: "{!! url()->current() !!}"
                },
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'ALL']
                ],
                responsive: true,
                order: [
                    [0, 'desc'],
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'foto',
                        name: 'foto'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'prodi',
                        name: 'prodi'
                    },
                    {
                        data: 'tahunLulus',
                        name: 'tahunLulus'
                    }
                ],
                columnDefs: [{
                    "targets": 1,
                    "render": function(data, type, row, meta) {
                        let img = ``;
                        if (data) {
                            img = `storage/${data}`;
                        }

                        return `<a href="{{ asset('/') }}${img}" target="_blank"><img alt="image" src="{{ asset('/') }}${img}"  width="100"></a>`;
                    }
                }, {
                    "targets": 2,
                    "render": function(data, type, row, meta) {
                        return `
                        ${data}
                        <form action="{{ url('/alumni') }}/${row.crypt_id}" method="POST" class="table-links">
                            @method('DELETE')
                            @csrf
                            <a
                                href="{{ url('/alumni') }}/${row.crypt_id}/edit"
                                class="btn btn-sm"
                            >
                                Edit
                            </a>
                            <button
                                type="submit"
                                class="text-danger btn-delete btn btn-sm"
                            >
                                Delete
                            </button>
                        </form>
                    `;
                    }
                }, ],
                rowId: function(a) {
                    return a;
                },
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                },
            });
        });
    </script>
@endpush()
