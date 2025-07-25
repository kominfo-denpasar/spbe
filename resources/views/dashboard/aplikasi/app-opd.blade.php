<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Perangkat Daerah Pengelola Aplikasi</h4>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-bordered table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama Perangkat Daerah</th>
                                    <th class="text-center">Aplikasi</th>
                                    <th class="text-center">Wilayah</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($opds as $opd)
                                    <tr>
                                        <td class="text-center">{{ $opd->nama }}</td>
                                        <td class="text-center">
                                            {{ $opd->applications->count() }}
                                        </td>
                                        <td class="text-center">
                                            <div class="justify-content-center gap-2">
                                                <div class="badge badge-secondary text-dark">
                                                    Pusat : {{ $opd->pusat_count ?? 0 }}
                                                    <i class="fas fa-building"></i>
                                                </div>
                                                <div class="badge badge-secondary text-dark">
                                                    Lokal : {{ $opd->lokal_count ?? 0 }}
                                                    <i class="fas fa-home"></i>
                                                </div>
                                                <div class="badge badge-secondary text-dark">
                                                    Desa : {{ $opd->desa_count ?? 0 }}
                                                    <i class="fas fa-tree"></i>
                                                </div>
                                                <div class="badge badge-secondary text-dark">
                                                    Lainnya : {{ $opd->lainnya_count ?? 0 }}
                                                    <i class="fas fa-globe"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="badge badge-secondary text-dark">
                                                {{ $opd->aktif_count ?? 0 }}
                                                <i class="fas fa-check-circle text-success"></i>
                                            </div>
                                            <div class="badge badge-secondary text-dark">
                                                {{ $opd->nonaktif_count ?? 0 }}
                                                <i class="fas fa-times-circle text-danger"></i>
                                            </div>
                                        </td>
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

@push('scripts')
    <!-- Data Tables -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $("#myTable").dataTable({
            "searching": true,
            "ordering": false
        });
    </script>
@endpush
