<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LaukRequest extends FormRequest
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
        $laukId = $this->route('lauk')?->id;

        return [
            'nama_lauk' => ['required', 'string', 'max:100', Rule::unique('lauks', 'nama_lauk')->ignore($laukId)],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'status_aktif' => ['boolean'],
        ];
    }
}