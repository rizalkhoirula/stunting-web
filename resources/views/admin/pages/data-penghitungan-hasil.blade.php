@extends('admin.layout.layout')

@section('title', 'Data Penghitungan Hasil')

@section('title-bar', 'Data Penghitungan Hasil')

@section('content')
<div class="container-fluid">
    <!-- row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Penghitungan Hasil</h4>
                </div>

                <div class="table-responsive">
                    <table id="test" class="display min-w850">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anak</th>
                                <th>Nama Ibu</th>
                                <th>Kriteria</th>
                                <th>Nilai Akhir</th>
                                <th>Klasifikasi</th>
                                <th>Action</th>
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
                                <td>
                                    @if($data['klasifikasi'] == 'Berpotensi Stunting')
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#AddBantuan{{ $data['id_anak'] }}">Tambahkan Bantuan</button>
                                    @else
                                    <button class="btn btn-success btn-sm" disabled>Tambahkan Bantuan</button>
                                    @endif
                                </td>

                                <div class="modal fade" id="AddBantuan{{ $data['id_anak'] }}">"
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Bantuan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                </button>
                                            </div>
                                            <form action="/add-bantuan" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    @csrf

                                                    <input type="hidden" name="id_anak" value="{{ $data['id_anak'] }}">

                                                    <div class="form-group">
                                                        <label>Jenis Bantuan</label>
                                                        <div class="dropdown bootstrap-select form-control default-select form-control-sm">
                                                            <select name="id_bantuan" class="form-control default-select form-control-sm">
                                                                <option selected disabled>Pilih Bantuan</option>
                                                                @foreach ($bantuan as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label>Jumlah</label>
                                                            <input type="text" name="jumlah" class="form-control" placeholder="Test">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@if(Session::get('store'))
<script>
    toastr.success("Data Berhasil Ditambahkan", "Info", {
        timeOut: 5000
        , closeButton: !0
        , debug: !1
        , newestOnTop: !0
        , progressBar: !0
        , positionClass: "toast-top-right"
        , preventDuplicates: !0
        , onclick: null
        , showDuration: "300"
        , hideDuration: "1000"
        , extendedTimeOut: "1000"
        , showEasing: "swing"
        , hideEasing: "linear"
        , showMethod: "fadeIn"
        , hideMethod: "fadeOut"
        , tapToDismiss: !1
    })

</script>
@endif

@if(Session::get('update'))
<script>
    toastr.success("Data Berhasil Diubah", "Info", {
        timeOut: 5000
        , closeButton: !0
        , debug: !1
        , newestOnTop: !0
        , progressBar: !0
        , positionClass: "toast-top-right"
        , preventDuplicates: !0
        , onclick: null
        , showDuration: "300"
        , hideDuration: "1000"
        , extendedTimeOut: "1000"
        , showEasing: "swing"
        , hideEasing: "linear"
        , showMethod: "fadeIn"
        , hideMethod: "fadeOut"
        , tapToDismiss: !1
    })

</script>
@endif

@if(Session::get('destroy'))
<script>
    toastr.success("Data Berhasil Dihapus", "Info", {
        timeOut: 5000
        , closeButton: !0
        , debug: !1
        , newestOnTop: !0
        , progressBar: !0
        , positionClass: "toast-top-right"
        , preventDuplicates: !0
        , onclick: null
        , showDuration: "300"
        , hideDuration: "1000"
        , extendedTimeOut: "1000"
        , showEasing: "swing"
        , hideEasing: "linear"
        , showMethod: "fadeIn"
        , hideMethod: "fadeOut"
        , tapToDismiss: !1
    })

</script>
@endif
<script>
    $('#test').DataTable({
        autoWidth: true,
        // "lengthMenu": [
        //     [16, 32, 64, -1],
        //     [16, 32, 64, "All"]
        // ]
        dom: 'Bfrtip',


        lengthMenu: [
            [10, 25, 50, -1]
            , ['10 rows', '25 rows', '50 rows', 'Show all']
        ],

        buttons: [{
                extend: 'colvis'
                , className: 'btn btn-primary btn-sm'
                , text: 'Column Visibility',
                // columns: ':gt(0)'


            },

            {

                extend: 'pageLength'
                , className: 'btn btn-primary btn-sm'
                , text: 'Page Length',
                // columns: ':gt(0)'
            },


            // 'colvis', 'pageLength',

            {
                extend: 'excel'
                , className: 'btn btn-primary btn-sm'
                , exportOptions: {
                    columns: [0, ':visible']
                }
            },

            // {
            //     extend: 'csv',
            //     className: 'btn btn-primary btn-sm',
            //     exportOptions: {
            //         columns: [0, ':visible']
            //     }
            // },
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

            // 'pageLength', 'colvis',
            // 'copy', 'csv', 'excel', 'print'

        ]
    , });

</script>
@endsection
