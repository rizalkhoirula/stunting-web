@extends('admin.layout.layout')

@section('title', 'Data Penghitungan Detail')

@section('title-bar', 'Data Penghitungan Detail')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Alternatif</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table id="test-1" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Anak</th>
                                        @foreach ($kriteria_list as $data_kriteria)
                                        <th>{{ $data_kriteria->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anak_list as $anak)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $anak->name }}</td>
                                        @foreach ($kriteria_list as $data_kriteria)
                                        @php
                                        // Ambil bobot dari data alternatif berdasarkan id anak dan id kriteria
                                        $bobot = $data_alternatif[$anak->id][$data_kriteria->id] ?? 'N/A';
                                        @endphp
                                        <td>{{ $bobot }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Kriteria</h4>
                </div>
                <div class="table-responsive">
                    <table id="test-2" class="display min-w850">
                        <thead>
                            <tr>
                                <th>Detail</th>
                                @foreach ($kriteria as $data )
                                <th>{{ $data->name }}</th>
                                @endforeach

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Bobot</td>
                                @foreach ($kriteria as $data )
                                <td>{{ $data->bobot }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>Jenis</td>
                                @foreach ($kriteria as $data )
                                <td>{{ $data->jenis }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Normalisasi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table id="test-3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Anak</th>
                                        @foreach ($kriteria_list as $kriteria)
                                        <th>{{ $kriteria->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_tampil_normalisasi as $data_normalisasi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data_normalisasi['anak'] }}</td>
                                        @foreach ($kriteria_list as $kriteria)
                                        @php
                                        $bobot = $data_normalisasi['data'][$kriteria->id] ?? null;
                                        @endphp
                                        <td>{{ $bobot !== null ? number_format($bobot, 2) : '-' }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Anak & Nilai Bobot</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="test-4" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anak</th>
                                    <th>Nama Ibu</th>
                                    <th>Kriteria</th>
                                    <th>Nilai Akhir</th>
                                    <th>Klasifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_akhir as $index => $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data['nama_anak'] }}</td>
                                    <td>{{ $data['nama_ibu'] }}</td>
                                    <td>
                                        <!-- Menampilkan Kriteria dan Sub-Kriteria -->
                                        @foreach ($data['kriteria'] as $kriteria => $sub_kriteria)
                                        <strong>{{ $kriteria }}:</strong> {{ $sub_kriteria }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ number_format($data['nilai_akhir'], 4) }}</td> <!-- Membulatkan nilai akhir hingga 4 angka desimal -->
                                    <td>{{ $data['klasifikasi'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    $('#test-1').DataTable({
        autoWidth: true
        , dom: 'Bfrtip'
        , ordering: false,

        lengthMenu: [
            [10, 25, 50, -1]
            , ['10 rows', '25 rows', '50 rows', 'Show all']
        ],

        buttons: [{
                extend: 'colvis'
                , className: 'btn btn-primary btn-sm'
                , text: 'Column Visibility'
            , },

            {

                extend: 'pageLength'
                , className: 'btn btn-primary btn-sm'
                , text: 'Page Length',
                // columns: ':gt(0)'
            },

            {
                extend: 'excel'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },


            {
                extend: 'pdf'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },

            {
                extend: 'print'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },



        ]
    , });
    $('#test-2').DataTable({
        autoWidth: true
        , dom: 'Bfrtip'
        , ordering: false
        , lengthMenu: [
            [10, 25, 50, -1]
            , ['10 rows', '25 rows', '50 rows', 'Show all']
        ],

        buttons: [{
                extend: 'colvis'
                , className: 'btn btn-primary btn-sm'
                , text: 'Column Visibility',

            },

            {

                extend: 'pageLength'
                , className: 'btn btn-primary btn-sm'
                , text: 'Page Length',
                // columns: ':gt(0)'
            },

            {
                extend: 'excel'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },


            {
                extend: 'pdf'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },

            {
                extend: 'print'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },



        ]
    , });
    $('#test-3').DataTable({
        autoWidth: true
        , dom: 'Bfrtip'
        , ordering: false
        , lengthMenu: [
            [10, 25, 50, -1]
            , ['10 rows', '25 rows', '50 rows', 'Show all']
        ],

        buttons: [{
                extend: 'colvis'
                , className: 'btn btn-primary btn-sm'
                , text: 'Column Visibility',


            },

            {

                extend: 'pageLength'
                , className: 'btn btn-primary btn-sm'
                , text: 'Page Length',
                // columns: ':gt(0)'
            },

            {
                extend: 'excel'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },


            {
                extend: 'pdf'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },

            {
                extend: 'print'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },



        ]
    , });
    $('#test-4').DataTable({
        autoWidth: true
        , dom: 'Bfrtip'
        , ordering: false
        , lengthMenu: [
            [10, 25, 50, -1]
            , ['10 rows', '25 rows', '50 rows', 'Show all']
        ],

        buttons: [{
                extend: 'colvis'
                , className: 'btn btn-primary btn-sm'
                , text: 'Column Visibility',


            },

            {

                extend: 'pageLength'
                , className: 'btn btn-primary btn-sm'
                , text: 'Page Length',
                // columns: ':gt(0)'
            },

            {
                extend: 'excel'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },


            {
                extend: 'pdf'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },

            {
                extend: 'print'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },



        ]
    , });

</script>
@endsection
