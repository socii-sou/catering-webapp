<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CapacitySettingRequest extends FormRequest
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
        $capacitySettingId = $this->route('capacity_setting')?->id;

        return [
            // tanggal boleh kosong -> artinya ini pengaturan default/global
            'tanggal' => [
                'nullable',
                'date',
                Rule::unique('capacity_settings', 'tanggal')->ignore($capacitySettingId),
            ],
            'kapasitas_maks_pax' => ['required', 'integer', 'min:1'],
        ];
    }
}