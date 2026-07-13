<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isPenjual() ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $paketId = $this->route('paket')?->id;

        return [
            'nm_paket' => ['required', 'string', 'max:100', Rule::unique('pakets', 'nm_paket')->ignore($paketId)],
            'harga_paket' => ['required', 'numeric', 'min:0'],
            'jumlah_lauk_pilihan' => ['required', 'integer', 'min:1'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'status_aktif' => ['boolean'],
        ];
    }
}