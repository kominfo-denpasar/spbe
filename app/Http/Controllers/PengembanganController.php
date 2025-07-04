<?php

namespace App\Http\Controllers;

use App\Models\Pengembangan;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengembanganRequest;
use App\Http\Requests\UpdatePengembanganRequest;
use App\Models\Application;
use App\Models\Bahasaprogram;
use App\Models\Frameworkapp;
use App\Models\Katdb;
use App\Models\Katplatform;
use App\Models\Sdmpengembang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class PengembanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Application $application)
    {
        // $pengembangans = Pengembangan::where('application_id', $application->id)->get();

        // return view('pengembangan.pengembangan-index', compact('application', 'pengembangans'), [
        //     'title' => 'Pengembangan Aplikasi'
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Application $application)
    {
        $katplatforms = Katplatform::all();
        $katdbs = Katdb::all();
        $bhsprograms = Bahasaprogram::all();
        $frameworkapps = Frameworkapp::all();

        return view('pengembangan.pengembangan-create', compact('application', 'katplatforms', 'katdbs', 'bhsprograms', 'frameworkapps'), [
            'title' => 'Pengembangan Aplikasi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePengembanganRequest $request)
    {
        DB::transaction(function () use ($request) {
        $validated = $request->validated();

            if ($request->hasFile('nda')) {
                $ndaPath = $request->file('nda')->store('pengembangan/ndas', 'public');
                $validated['nda'] = $ndaPath;
            }

            if ($request->hasFile('doc_perancangan')) {
                $doc_perancanganPath = $request->file('doc_perancangan')->store('pengembangan/perancangans', 'public');
                $validated['doc_perancangan'] = $doc_perancanganPath;
            }

            if ($request->hasFile('surat_mohon')) {
                $surat_mohonPath = $request->file('surat_mohon')->store('pengembangan/surat-mohons', 'public');
                $validated['surat_mohon'] = $surat_mohonPath;
            }

            if ($request->hasFile('kak')) {
                $kakPath = $request->file('kak')->store('pengembangan/kaks', 'public');
                $validated['kak'] = $kakPath;
            }

            if ($request->hasFile('sop')) {
                $sopPath = $request->file('sop')->store('pengembangan/sops', 'public');
                $validated['sop'] = $sopPath;
            }

            if ($request->hasFile('doc_pentest')) {
                $doc_pentestPath = $request->file('doc_pentest')->store('pengembangan/pentests', 'public');
                $validated['doc_pentest'] = $doc_pentestPath;
            }

            if ($request->hasFile('doc_uat')) {
                $doc_uatPath = $request->file('doc_uat')->store('pengembangan/uats', 'public');
                $validated['doc_uat'] = $doc_uatPath;
            }

            if ($request->hasFile('buku_manual')) {
                $buku_manualPath = $request->file('buku_manual')->store('pengembangan/buku-manuals', 'public');
                $validated['buku_manual'] = $buku_manualPath;
            }

            if ($request->hasFile('capture_frontend')) {
                $capture_frontendPath = $request->file('capture_frontend')->store('pengembangan/capture-frontends', 'public');
                $validated['capture_frontend'] = $capture_frontendPath;
            }

            if ($request->hasFile('capture_backend')) {
                $capture_backendPath = $request->file('capture_backend')->store('pengembangan/capture-backends', 'public');
                $validated['capture_backend'] = $capture_backendPath;
            }

            // submit pengembangan 
            $newPengembangan = Pengembangan::create($validated);

            Sdmpengembang::create([
                'pengembangan_id' => $newPengembangan->id, //get from $pengembangan->id
                'nama_pengembang' => $request->input('nama_pengembang'),
                'alamat_pengembang' => $request->input('alamat_pengembang'),
                'nohp_pengembang' => $request->input('nohp_pengembang'),
                'nokantor_pengembang' => $request->input('nokantor_pengembang'),
                'email_pengembang' => $request->input('email_pengembang'),
            ]);
        });

        return redirect()->route('admin.application.show', $request->application_id)
            ->with('success', 'Data telah tersimpan dengan sukses!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Pengembangan $pengembangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application, Pengembangan $pengembangan)
    {
        $katplatforms = Katplatform::all();
        $katdbs = Katdb::all();
        $bhsprograms = Bahasaprogram::all();
        $frameworkapps = Frameworkapp::all();

        $vendor = \App\Models\Sdmpengembang::where('pengembangan_id', $pengembangan->id)->first();

        return view('pengembangan.pengembangan-edit', compact('application', 'pengembangan', 'katplatforms', 'katdbs', 'bhsprograms', 'frameworkapps', 'vendor'), [
            'title' => 'Pengembangan Aplikasi'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Application $application, UpdatePengembanganRequest $request, Pengembangan $pengembangan)
    {
        DB::transaction(function () use ($request, $pengembangan) {
            $validated = $request->validated();

            if ($request->hasFile('nda')) {
                Storage::disk('public')->delete($pengembangan->nda);

                $ndaPath = $request->file('nda')->store('pengembangan/ndas', 'public');
                $validated['nda'] = $ndaPath;
            }

            if ($request->hasFile('doc_perancangan')) {
                Storage::disk('public')->delete($pengembangan->doc_perancangan);

                $doc_perancanganPath = $request->file('doc_perancangan')->store('pengembangan/perancangans', 'public');
                $validated['doc_perancangan'] = $doc_perancanganPath;
            }

            if ($request->hasFile('surat_mohon')) {
                Storage::disk('public')->delete($pengembangan->surat_mohon);

                $surat_mohonPath = $request->file('surat_mohon')->store('pengembangan/surat-mohons', 'public');
                $validated['surat_mohon'] = $surat_mohonPath;
            }

            if ($request->hasFile('kak')) {
                Storage::disk('public')->delete($pengembangan->kak);

                $kakPath = $request->file('kak')->store('pengembangan/kaks', 'public');
                $validated['kak'] = $kakPath;
            }

            if ($request->hasFile('sop')) {
                Storage::disk('public')->delete($pengembangan->sop);

                $sopPath = $request->file('sop')->store('pengembangan/sops', 'public');
                $validated['sop'] = $sopPath;
            }

            if ($request->hasFile('doc_pentest')) {
                Storage::disk('public')->delete($pengembangan->doc_pentest);

                $doc_pentestPath = $request->file('doc_pentest')->store('pengembangan/pentests', 'public');
                $validated['doc_pentest'] = $doc_pentestPath;
            }

            if ($request->hasFile('doc_uat')) {
                Storage::disk('public')->delete($pengembangan->doc_uat);

                $doc_uatPath = $request->file('doc_uat')->store('pengembangan/uats', 'public');
                $validated['doc_uat'] = $doc_uatPath;
            }

            if ($request->hasFile('buku_manual')) {
                Storage::disk('public')->delete($pengembangan->buku_manual);

                $buku_manualPath = $request->file('buku_manual')->store('pengembangan/buku-manuals', 'public');
                $validated['buku_manual'] = $buku_manualPath;
            }

            if ($request->hasFile('capture_frontend')) {
                Storage::disk('public')->delete($pengembangan->capture_frontend);

                $capture_frontendPath = $request->file('capture_frontend')->store('pengembangan/capture-frontends', 'public');
                $validated['capture_frontend'] = $capture_frontendPath;
            }

            if ($request->hasFile('capture_backend')) {
                Storage::disk('public')->delete($pengembangan->capture_backend);

                $capture_backendPath = $request->file('capture_backend')->store('pengembangan/capture-backends', 'public');
                $validated['capture_backend'] = $capture_backendPath;
            }

            $pengembangan->update($validated);

            $vendor = Sdmpengembang::where('pengembangan_id', $pengembangan->id)->first();
            if ($vendor) {
                // Update jika data vendor sudah ada
            $vendor->update([
                'nama_pengembang' => $request->input('nama_pengembang'),
                'alamat_pengembang' => $request->input('alamat_pengembang'),
                'nohp_pengembang' => $request->input('nohp_pengembang'),
                'nokantor_pengembang' => $request->input('nokantor_pengembang'),
                'email_pengembang' => $request->input('email_pengembang'),
            ]);
        } else {
            // Insert jika belum ada
            Sdmpengembang::create([
                'pengembangan_id' => $pengembangan->id,
                'nama_pengembang' => $request->input('nama_pengembang'),
                'alamat_pengembang' => $request->input('alamat_pengembang'),
                'nohp_pengembang' => $request->input('nohp_pengembang'),
                'nokantor_pengembang' => $request->input('nokantor_pengembang'),
                'email_pengembang' => $request->input('email_pengembang'),
            ]);
        }
        });
        return redirect()->route('admin.application.show', $request->application_id)->with('success', 'Perubahan data telah berhasil dilakukan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application, Pengembangan $pengembangan)
    {
        // dd($application->id);
        DB::transaction(function () use ($pengembangan) {

            // Hapus file PDF jika ada
            // if ($pengembangan->bukti_monev && Storage::exists($pengembangan->bukti_monev)) {
            //     Storage::delete($pengembangan->bukti_monev);
            // }

            // // Hapus file jika ada
            // $files = [
            //     $pengembangan->nda,
            //     $pengembangan->doc_perancangan,
            //     $pengembangan->surat_mohon,
            //     $pengembangan->kak,
            //     $pengembangan->sop,
            //     $pengembangan->doc_pentest,
            //     $pengembangan->doc_uat,
            //     $pengembangan->buku_manual,
            //     $pengembangan->capture_frontend,
            //     $pengembangan->capture_backend,
            // ];

            // foreach ($files as $file) {
            //     if ($file && Storage::disk('public')->exists($file)) {
            //         Storage::disk('public')->delete($file);
            //     }
            // }

            // Hapus SDM pengembang where sdmpengembang.pengembangan_id = $pengembangan->id
            $pengembangan->sdmpengembang()->delete();

            // Hapus data pengembangan
            $pengembangan->delete();
        });

        return redirect()->route('admin.application.show', $application->id)
            ->with('success', 'Penghapusan data sukses dilakukan.');
    }
}
