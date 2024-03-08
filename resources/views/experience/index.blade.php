@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h2>Job Application Form</h2>
                </div>
                <div class="card-body">
                    <a href="{{ route('experience.create') }}" class="btn btn-primary">Add Job Application</a>
                    <div class="table-responsive p-0">
                        <table id="my-table" class="my-table table table-hover w-100">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>No KTP</th>
                                    <th>Alamat</th>
                                    <th>Educations Experience</th>
                                    <th>Works Experience</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/dataTables5/js/dataTables.js') }}"></script>
    <script src="{{ asset('assets/dataTables5/js/dataTables.bootstrap5.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.fn.DataTable.ext.pager.numbers_length = 5;
            $('.my-table').DataTable({
                processing: true,
                serverSide: true,
                pagingType: 'full_numbers',
                scrollY: "50vh",
                scrollCollapse: true,
                scrollX: true,
                ajax: '{{ route('experience.index') }}',
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="ni ni-bold-right pgn-1" style="color: #5e72e4"></span>',
                        sPrevious: '<span class="ni ni-bold-left pgn-2" style="color: #5e72e4"></span>',
                        sFirst: '<span class="pgn-3" style="color: #5e72e4">First</span>',
                        sLast: '<span class="pgn-4" style="color: #5e72e4">Last</span>',
                    }
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        className: 'text-center',
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'images',
                        name: 'images',
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                    },
                    {
                        data: 'no_ktp',
                        name: 'no_ktp',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                    },
                    {
                        data: 'educations',
                        name: 'educations',
                    },
                    {
                        data: 'work_experiences',
                        name: 'work_experiences',
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                ],
                columnDefs: [{
                    defaultContent: "-",
                    targets: "_all"
                }],

            });
        });
    </script>
@endsection
