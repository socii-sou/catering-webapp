<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePesananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isPelanggan() ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nama_acara' => ['required', 'string', 'max:150'],
            'tipe_acara' => ['nullable', 'string', 'max:100'],
            'alamat_pengiriman' => ['required', 'string', 'max:1000'],
            'gubukan_id' => ['nullable', 'exists:gubukans,id'],
            'tgl_acara' => ['required', 'date', 'after_or_equal:tomorrow'],
            'jumlah_pax' => ['required', 'integer', 'min:1'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'bukti_bayar' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5120'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.paket_id' => ['required', 'exists:pakets,id'],
            'items.*.jml_paket' => ['required', 'integer', 'min:1'],
            'items.*.lauk_ids' => ['required', 'array', 'min:1'],
            'items.*.lauk_ids.*' => ['exists:lauks,id'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('gubukan_id') && (int) $this->input('jumlah_pax', 0) < 100) {
                $validator->errors()->add('jumlah_pax', 'Minimal pemesanan paket dengan Gubukan adalah 100 porsi.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'tgl_acara.after_or_equal' => 'Tanggal acara minimal besok (H+1 dari hari ini).',
            'items.required' => 'Pesanan harus berisi minimal 1 paket.',
        ];
    }
}