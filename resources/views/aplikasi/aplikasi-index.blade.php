@extends('layouts.app')

@section('title', $title)

@push('style')
    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.min.css" />
    <style>
        div.dataTables_length,
        div.dataTables_filter {
            display: none !important;
        }

        table.dataTable tbody td.dataTables_empty {
            text-align: center;
            vertical-align: middle;
        }

    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $title }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">{{ $title }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @role('superadmin|admin-aplikasi|operator-aplikasi')                            
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                {{-- Kiri: Tombol Add --}}
                                <div class="mb-2">
                                    @role('superadmin|admin-aplikasi|operator-aplikasi')
                                    <a href="{{ route('admin.application.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add
                                    </a>
                                    @endrole
                                </div>

                                {{-- Kanan: Tombol Export --}}
                                <form id="exportForm" method="GET" action="{{ route('admin.application.export') }}">
                                    <input type="hidden" name="opd" id="exportOPD">
                                    <input type="hidden" name="layanan" id="exportLayanan">
                                    <input type="hidden" name="tahun" id="exportTahun">
                                    <input type="hidden" name="status" id="exportStatus">
                                    <input type="hidden" name="search" id="exportSearch">

                                    <button type="submit" class="btn btn-success mb-3 ml-2">
                                        <i class="fas fa-file-excel"></i> Export Excel
                                    </button>
                                </form>
                            </div>


                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <div class="form-inline mb-2">
                                    <label for="customLength" class="mr-2 mb-0">Tampilkan</label>
                                    <select id="customLength" class="form-control form-control-sm" style="height: 40px;">
                                        <option value="5">5</option>
                                        <option value="10" selected>10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>

                                <div class="d-flex flex-wrap mb-2 justify-content-end align-items-center" style="gap: 0.5rem;">
                                    <div class="form-group mb-0">
                                        <select id="filterOPD" class="form-control form-control-sm select2" style="width: 220px;">
                                            <option value="">-- Semua OPD --</option>
                                            @foreach ($opds as $opd)
                                                <option value="{{ strtolower($opd->nama) }}">{{ $opd->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-0">
                                        <select id="filterLayanan" class="form-control form-control-sm select2" style="min-width: 180px;">
                                            <option value="">-- Semua Layanan --</option>
                                            @foreach ($layanans as $layanan)
                                                <option value="{{ strtolower($layanan->layanan_app) }}">{{ $layanan->layanan_app }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-0">
                                        <select id="filterTahun" class="form-control form-control-sm select2" style="min-width: 140px;">
                                            <option value="">-- Semua Tahun --</option>
                                            @php
                                                $currentYear = now()->year;
                                            @endphp
                                            @for ($year = $currentYear; $year >= 2005; $year--)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="form-group mb-0">
                                        <select id="filterStatus" class="form-control form-control-sm select2" style="min-width: 140px;">
                                            <option value="">-- Semua Status --</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-0">
                                        <input type="text" id="customSearch" class="form-control form-control-sm" style="min-width: 200px;" placeholder="Cari...">
                                    </div>
                                </div>
                            </div>
                            @endrole

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Nama Aplikasi</th>
                                            <th>OPD/Perumda/Kelurahan/Desa</th>
                                            <th>Tahun Pembuatan</th>
                                            <th>Status</th>
                                            <th>Aset Tak Berwujud</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($applications as $application)
                                            <tr data-opd="{{ strtolower($application->opd->nama) }}"
                                                data-layanan="{{ strtolower($application->layananapp->layanan_app ?? '') }}"
                                                data-tahun="{{ $application->tahun_buat }}"
                                                data-status="{{ $application->status == 1 ? 'aktif' : 'tidak aktif' }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <!-- <a href="{{ route('admin.sdmpengembang.index', $application->id) }}" class="btn btn-primary btn-sm" title="Vendor">
                                                        <i class="fas fa-handshake"></i>
                                                    </a> -->

                                                    @role('superadmin|admin-aplikasi|operator-aplikasi|viewer-aplikasi')
                                                        <a href="{{ route('admin.application.show', $application->id) }}"
                                                            class="btn btn-dark btn-sm" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endrole
                                                    @role('superadmin|admin-aplikasi|operator-aplikasi')
                                                        <a href="{{ route('admin.application.edit', $application->id) }}"
                                                            class="btn btn-light btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endrole
                                                    @role('superadmin|admin-aplikasi')
                                                        <form
                                                            action="{{ route('admin.application.destroy', $application->id) }}"
                                                            method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-light btn-sm show_confirm"
                                                                title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endrole
                                                </td>
                                                <td>{{ $application->nama_app }}</td>
                                                <td>{{ $application->opd->nama }}</td>
                                                <td>{{ $application->tahun_buat }}</td>
                                                <td>
                                                    @if ($application->status == 1)
                                                        <span class="badge badge-success">Aktif</span>
                                                    @else
                                                        <span class="badge badge-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>{{ $application->aset_takberwujud == 1 ? 'Ya' : 'Tidak' }}</td>
                                            </tr>
                                        @endforeach
                                            <tfoot>
                                                <tr id="noDataRow" style="display: none;">
                                                    <td colspan="7" class="text-center">No data available in table</td>
                                                </tr>
                                            </tfoot>
                                    </tbody>
                                    <tfoot>
                                        <tr id="noDataRow" style="display: none;">
                                            <td colspan="7" class="text-center">No data available in table</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">

    <style>
        .select2-selection__rendered {
        line-height: 36px !important; /* atur sesuai tinggi */
        width: 200px !important;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;       /* sesuaikan tinggi */
            display: flex !important;
            width: 195px !important;
            align-items: center !important;
        }
    </style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
<!-- JS -->
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>


<script>
        $('#filterOPD, #filterLayanan, #filterTahun, #filterStatus').select2({
        width: 'style',
        // placeholder: "-- Pilih --",
        allowClear: true
    });
    
    let table;
    let allRows = [];
    let currentLimit = 10;

    function applyCustomFilterAndLimit() {
    let filterTahun = $('#filterTahun').val();
    let filterStatus = $('#filterStatus').val().toLowerCase();
    let filterOPD = $('#filterOPD').val().toLowerCase();
    let filterLayanan = $('#filterLayanan').val().toLowerCase();
    let searchText = $('#customSearch').val().toLowerCase();

    $('#myTable tbody tr').each(function () {
        let row = $(this);
        let opd = row.data('opd') || '';
        let layanan = row.data('layanan') || '';
        let tahun = row.data('tahun') || '';
        let status = row.data('status') || '';
        let text = row.text().toLowerCase();

        let match =
            (filterTahun === "" || tahun == filterTahun) &&
            (filterStatus === "" || status == filterStatus) &&
            (filterOPD === "" || opd.includes(filterOPD)) &&
            (filterLayanan === "" || layanan.includes(filterLayanan)) &&
            (searchText === "" || text.includes(searchText));

        row.toggle(match);
    });

    table.draw(); // perbarui pagination
    }

    $(document).ready(function () {
    table = $('#myTable').DataTable({
        paging: true,
        searching: false,
        lengthChange: false,
        info: true
    });

    // Simpan semua baris awal
    allRows = $('#myTable tbody tr').clone();

        // Trigger saat filter berubah
        $('#filterTahun, #filterStatus, #filterOPD, #filterLayanan, #customSearch').on('input change', function () {
            applyCustomFilterAndLimit();
        });

        // Trigger saat limit baris diubah
        $('#customLength').on('change', function () {
        table.page.len(parseInt($(this).val())).draw();
        applyCustomFilterAndLimit();
        });

        // Initial render
        applyCustomFilterAndLimit();

        // Kirim filter ke input hidden saat submit export
        $('#exportForm').on('submit', function () {
            $('#exportOPD').val($('#filterOPD').val());
            $('#exportLayanan').val($('#filterLayanan').val());
            $('#exportTahun').val($('#filterTahun').val());
            $('#exportStatus').val($('#filterStatus').val());
            $('#exportSearch').val($('#customSearch').val());
        });

    });
</script>
@endpush