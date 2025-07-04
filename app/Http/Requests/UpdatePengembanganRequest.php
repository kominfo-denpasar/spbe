<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePengembanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'application_id' => ['required'],
            'tahun_pengembangan' => ['required', 'date_format:Y'],
            'riwayat_pengembangan' => ['nullable', 'string', 'max:65535'],
            'fitur' => ['required', 'string', 'max:65535'],
            'nda' => ['nullable', 'file', 'mimes:pdf', 'max:10000'],
            'doc_perancangan' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'surat_mohon' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'kak' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'sop' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'doc_pentest' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'doc_uat' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'video_penggunaan' => ['nullable', 'url:http,https'],
            'buku_manual' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'katplatform_id' => ['required'],
            'katdb_id' => ['required'],
            'bahasaprogram_id' => ['required'],
            'frameworkapp_id' => ['required'],
            'capture_frontend' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:100000'],
            'capture_backend' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:100000'],
            'user_id' => ['required'],

            'application_id' => ['sometimes'],
            'nama_pengembang' => ['sometimes', 'string'],
            'alamat_pengembang' => ['nullable', 'string', 'min:5', 'max:1000'],
            'nohp_pengembang' => ['sometimes', 'string', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'nokantor_pengembang' => ['nullable', 'numeric', 'digits_between:10,13'],
            'email_pengembang' => ['nullable', 'email', 'unique:users,email'],

        ];
    }
}
