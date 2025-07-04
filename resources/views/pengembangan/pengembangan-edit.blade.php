@extends('layouts.app')

@section('title', $title)

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $title }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">{{ $title }}</div>
                <div class="breadcrumb-item">Edit Data</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate=""
                            action="{{ route('admin.pengembangan.update', ['application' => $application->id, 'pengembangan' => $pengembangan]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            {{-- <div class="card-header">
                            <h4>{{ __($title) }}</h4>
                        </div> --}}
                            <div class="card-body">
                                <input type="hidden" class="form-control @error('application_id') is-invalid @enderror"
                                    name="application_id" value="{{ old('application_id', $application->id) }}" readonly
                                    autocomplete="application_id" placeholder="{{ __('ID Application') }}">
                                <input type="hidden" class="form-control @error('user_id') is-invalid @enderror"
                                    name="user_id" value="{{ old('user_id', auth()->user()->id) }}" required readonly
                                    autocomplete="user_id" placeholder="{{ __('ID User') }}">
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('Nama Aplikasi') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('application_id', $application->nama_app) }}" disabled>
                                </div>
                                <div class="form-group col-md-2 col-12">
                                    <label>{{ __('Tahun Pengembangan') }}</label>
                                    <select class="form-control select2 @error('tahun_pengembangan') is-invalid @enderror"
                                        name="tahun_pengembangan" required autocomplete="tahun_pengembangan">
                                        {{-- <option>-</option> --}}
                                        @for ($i = date('Y'); $i >= 2005; $i--)
                                            <option value="{{ $i }}"
                                                {{ old('tahun_pengembangan', $pengembangan->tahun_pengembangan) == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('tahun_pengembangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div id="riwayat_pengembangan" class="form-group col-md-8 col-12">
                                    <label>{{ __('Riwayat Pengembangan') }}</label>
                                    <textarea class="form-control @error('riwayat_pengembangan') is-invalid @enderror" name="riwayat_pengembangan"
                                        id="riwayat_pengembangan" autocomplete="riwayat_pengembangan" placeholder="{{ __('Riwayat Pengembangan') }}"
                                        style="height: 150px;">{{ old('riwayat_pengembangan', $pengembangan->riwayat_pengembangan) }}</textarea>
                                    @error('riwayat_pengembangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div id="fitur" class="form-group col-md-8 col-12">
                                    <label>{{ __('Fitur') }}</label>
                                    <textarea class="form-control @error('fitur') is-invalid @enderror" required name="fitur" id="fitur"
                                        autocomplete="fitur" placeholder="{{ __('Fitur') }}" style="height: 150px;">{{ old('fitur', $pengembangan->fitur) }}</textarea>
                                    @error('fitur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('NDA') }}</label>
                                    @if (!empty($pengembangan->nda))
                                        <div class="mb-0 d-block">
                                            <a href="{{ asset(Storage::url($pengembangan->nda)) }}" target="_blank">
                                                <i class="fas fa-file-alt"></i> View Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('nda') is-invalid @enderror"
                                        name="nda" autocomplete="nda">
                                    <small id="nda" class="form-text text-muted">
                                        file ekstensi .pdf dengan maksimal size 10MB
                                    </small>
                                    @error('nda')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('Dokumen Perancangan') }}</label>
                                    @if (!empty($pengembangan->doc_perancangan))
                                        <div class="mb-0 d-block">
                                            <a href="{{ asset(Storage::url($pengembangan->doc_perancangan)) }}"
                                                target="_blank">
                                                <i class="fas fa-file-alt"></i> View Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file"
                                        class="form-control @error('doc_perancangan') is-invalid @enderror"
                                        name="doc_perancangan" autocomplete="doc_perancangan">
                                    <small id="doc_perancangan" class="form-text text-muted">
                                        file ekstensi .pdf dengan maksimal size 100MB
                                    </small>
                                    @error('doc_perancangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('Surat Permohonan') }}</label>
                                    @if (!empty($pengembangan->surat_mohon))
                                        <div class="mb-0 d-block">
                                            <a href="{{ asset(Storage::url($pengembangan->surat_mohon)) }}"
                                                target="_blank">
                                                <i class="fas fa-file-alt"></i> View Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('surat_mohon') is-invalid @enderror"
                                        name="surat_mohon" autocomplete="surat_mohon">
                                    <small id="surat_mohon" class="form-text text-muted">
                                        file ekstensi .pdf dengan maksimal size 100MB
                                    </small>
                                    @error('surat_mohon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('KAK') }}</label>
                                    @if (!empty($pengembangan->kak))
                                        <div class="mb-0 d-block">
                                            <a href="{{ asset(Storage::url($pengembangan->kak)) }}" target="_blank">
                                                <i class="fas fa-file-alt"></i> View Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('kak') is-invalid @enderror"
                                        name="kak" autocomplete="kak">
                                    <small id="kak" class="form-text text-muted">
                                        file ekstensi .pdf dengan maksimal size 100MB
                                    </small>
                                    @error('kak')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('SOP') }}</label>
                                    @if (!empty($pengembangan->sop))
                                        <div class="mb-0 d-block">
                                            <a href="{{ asset(Storage::url($pengembangan->sop)) }}" target="_blank">
                                                <i class="fas fa-file-alt"></i> View Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('sop') is-invalid @enderror"
                                        name="sop" autocomplete="sop">
                                    <small id="sop" class="form-text text-muted">
                                        file ekstensi .pdf dengan maksimal size 100MB
                                    </small>
                                    @error('sop')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('Dokumen Pentest') }}</label>
                                    @if (!empty($pengembangan->doc_pentest))
                                        <div class="mb-0 d-block">
                                            <a href="{{ asset(Storage::url($pengembangan->doc_pentest)) }}"
                                                target="_blank">
                                                <i class="fas fa-file-alt"></i> View Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('doc_pentest') is-invalid @enderror"
                                        name="doc_pentest" autocomplete="doc_pentest">
                                    <small id="doc_pentest" class="form-text text-muted">
                                        file ekstensi .pdf dengan maksimal size 100MB
                                    </small>
                                    @error('doc_pentest')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('Dokumen UAT (User Acceptance Testing)') }}</label>
                                    @if (!empty($pengembangan->doc_uat))
                                        <div class="mb-0 d-block">
                                            <a href="{{ asset(Storage::url($pengembangan->doc_uat)) }}" target="_blank">
                                                <i class="fas fa-file-alt"></i> View Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('doc_uat') is-invalid @enderror"
                                        name="doc_uat" autocomplete="doc_uat">
                                    <small id="doc_uat" class="form-text text-muted">
                                        file ekstensi .pdf dengan maksimal size 100MB
                                    </small>
                                    @error('doc_uat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>{{ __('Video Penggunaan') }}</label>
                                    <input type="text"
                                        class="form-control @error('video_penggunaan') is-invalid @enderror"
                                        name="video_penggunaan"
                                        value="{{ old('video_penggunaan', $pengembangan->video_penggunaan) }}"
                                        autocomplete="video_penggunaan" placeholder="{{ __('Video Penggunaan') }}">
                                    <small id="video_penggunaan" class="form-text text-muted">
                                        link video dari youtube maupun link lainnya
                                    </small>
                                    @error('video_penggunaan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('Buku Manual') }}</label>
                                    @if (!empty($pengembangan->buku_manual))
                                        <div class="mb-0 d-block">
                                            <a href="{{ asset(Storage::url($pengembangan->buku_manual)) }}"
                                                target="_blank">
                                                <i class="fas fa-file-alt"></i> View Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('buku_manual') is-invalid @enderror"
                                        name="buku_manual" autocomplete="buku_manual">
                                    <small id="buku_manual" class="form-text text-muted">
                                        file ekstensi .pdf dengan maksimal size 100MB
                                    </small>
                                    @error('buku_manual')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 col-12">
                                    <label>{{ __('Kategori Platform *)') }}</label>
                                    <select class="form-control select2 @error('katplatform_id') is-invalid @enderror"
                                        name="katplatform_id" required autocomplete="katplatform_id">
                                        {{-- <option value="">-</option> --}}
                                        @forelse ($katplatforms as $katplatform)
                                            <option value="{{ $katplatform->id }}"
                                                {{ old('katplatform_id', $pengembangan->katplatform_id) == $katplatform->id ? 'selected' : '' }}>
                                                {{ $katplatform->kategori_platform }}
                                            </option>
                                        @empty
                                            <option value="">Tidak Ada Data</option>
                                        @endforelse
                                    </select>
                                    @error('katplatform_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 col-12">
                                    <label>{{ __('Kategori Database *)') }}</label>
                                    <select class="form-control select2 @error('katdb_id') is-invalid @enderror"
                                        name="katdb_id" required autocomplete="katdb_id">
                                        {{-- <option value="">-</option> --}}
                                        @forelse ($katdbs as $katdb)
                                            <option value="{{ $katdb->id }}"
                                                {{ old('katdb_id', $pengembangan->katdb_id) == $katdb->id ? 'selected' : '' }}>
                                                {{ $katdb->kategori_database }}
                                            </option>
                                        @empty
                                            <option value="">Tidak Ada Data</option>
                                        @endforelse
                                    </select>
                                    @error('katdb_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 col-12">
                                    <label>{{ __('Bahasa Program *)') }}</label>
                                    <select class="form-control select2 @error('bahasaprogram_id') is-invalid @enderror"
                                        name="bahasaprogram_id" required autocomplete="bahasaprogram_id">
                                        {{-- <option value="">-</option> --}}
                                        @forelse ($bhsprograms as $bhsprogram)
                                            <option value="{{ $bhsprogram->id }}"
                                                {{ old('bahasaprogram_id', $pengembangan->bahasaprogram_id) == $bhsprogram->id ? 'selected' : '' }}>
                                                {{ $bhsprogram->bhs_program }}
                                            </option>
                                        @empty
                                            <option value="">Tidak Ada Data</option>
                                        @endforelse
                                    </select>
                                    @error('bahasaprogram_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 col-12">
                                    <label>{{ __('Framework *)') }}</label>
                                    <select class="form-control select2 @error('frameworkapp_id') is-invalid @enderror"
                                        name="frameworkapp_id" required autocomplete="frameworkapp_id">
                                        {{-- <option value="">-</option> --}}
                                        @forelse ($frameworkapps as $frameworkapp)
                                            <option value="{{ $frameworkapp->id }}"
                                                {{ old('frameworkapp_id', $pengembangan->frameworkapp_id) == $frameworkapp->id ? 'selected' : '' }}>
                                                {{ $frameworkapp->framework_app }}
                                            </option>
                                        @empty
                                            <option value="">Tidak Ada Data</option>
                                        @endforelse
                                    </select>
                                    @error('frameworkapp_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('Capture Frontend') }}</label>
                                    @if (!empty($pengembangan->capture_frontend))
                                        <div class="mb-0 d-block">
                                            <a href="{{ asset(Storage::url($pengembangan->capture_frontend)) }}"
                                                target="_blank">
                                                <i class="fas fa-file-alt"></i> View Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file"
                                        class="form-control @error('capture_frontend') is-invalid @enderror"
                                        name="capture_frontend" autocomplete="capture_frontend">
                                    <small id="capture_frontend" class="form-text text-muted">
                                        file ekstensi jpg, jpeg dan png dengan maksimal size 10MB
                                    </small>
                                    @error('capture_frontend')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>{{ __('Capture Backend') }}</label>
                                    @if (!empty($pengembangan->capture_backend))
                                        <div class="mb-0 d-block">
                                            <a href="{{ asset(Storage::url($pengembangan->capture_backend)) }}"
                                                target="_blank">
                                                <i class="fas fa-file-alt"></i> View Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file"
                                        class="form-control @error('capture_backend') is-invalid @enderror"
                                        name="capture_backend" autocomplete="capture_backend">
                                    <small id="capture_backend" class="form-text text-muted">
                                        file ekstensi jpg, jpeg dan png dengan maksimal size 10MB
                                    </small>
                                    @error('capture_backend')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{--Field insert to Vendor --}}
                                <br>
                                <div class="section-title mt-0">Vendor</div>
                                <hr>
                                <div class="card-body">
                                    {{-- <input type="hidden" class="form-control @error('application_id') is-invalid @enderror"
                                        name="pengembangan_id" value="{{ old('pengembangan_id', $pengembangan->id) }}" readonly
                                        autocomplete="pengembangan_id" placeholder="{{ __('ID Pengembangan') }}">
                                    @error('pengembangan_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                    
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ __('Nama Vendor') }}</label>
                                        <input type="text"
                                            class="form-control @error('nama_pengembang') is-invalid @enderror"
                                            name="nama_pengembang"
                                            value="{{ old('nama_pengembang', $vendor?->nama_pengembang) }}"
                                            required autocomplete="nama_pengembang"
                                            placeholder="{{ __('Nama Vendor') }}">
                                        @error('nama_pengembang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div id="alamat_pengembang" class="form-group col-md-8 col-12">
                                        <label>{{ __('Alamat Vendor') }}</label>
                                        <textarea class="form-control @error('alamat_pengembang') is-invalid @enderror"
                                            name="alamat_pengembang"
                                            id="alamat_pengembang"
                                            autocomplete="alamat_pengembang"
                                            placeholder="{{ __('Alamat Vendor') }}"
                                            style="height: 100px;">{{ old('alamat_pengembang', $vendor?->alamat_pengembang) }}</textarea>
                                        @error('alamat_pengembang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{ __('No HP Vendor') }}</label>
                                        <input type="text"
                                            class="form-control @error('nohp_pengembang') is-invalid @enderror"
                                            name="nohp_pengembang"
                                            value="{{ old('nohp_pengembang', $vendor?->nohp_pengembang) }}"
                                            required autocomplete="nohp_pengembang"
                                            placeholder="{{ __('No HP Vendor') }}">
                                        @error('nohp_pengembang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-5 col-12">
                                        <label>{{ __('No Kantor Vendor') }}</label>
                                        <input type="text"
                                            class="form-control @error('nokantor_pengembang') is-invalid @enderror"
                                            name="nokantor_pengembang"
                                            value="{{ old('nokantor_pengembang', $vendor?->nokantor_pengembang) }}"
                                            autocomplete="nokantor_pengembang"
                                            placeholder="{{ __('No Kantor Vendor') }}">
                                        @error('nokantor_pengembang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-5 col-12">
                                        <label>{{ __('Email Vendor') }}</label>
                                        <input type="text"
                                            class="form-control @error('email_pengembang') is-invalid @enderror"
                                            name="email_pengembang"
                                            value="{{ old('email_pengembang', $vendor?->email_pengembang) }}"
                                            autocomplete="email_pengembang"
                                            placeholder="{{ __('Email Vendor') }}">
                                        @error('email_pengembang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-left">
                                <a href="{{ route('admin.application.show', $application->id) }}""
                                    class="btn btn-dark">{{ __('Back') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
@endpush
