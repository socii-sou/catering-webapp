<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GubukanRequest extends FormRequest
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
        $gubukanId = $this->route('gubukan')?->id;

        return [
            'nama_gubukan' => ['required', 'string', 'max:100', Rule::unique('gubukans', 'nama_gubukan')->ignore($gubukanId)],
            'harga_gubukan' => ['required', 'numeric', 'min:0'],
            'kapasitas_orang' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['boolean'],
        ];
    }
}