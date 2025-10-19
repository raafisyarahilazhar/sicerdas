<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        $userId  = optional($this->user())->id;
        $section = $this->input('_section'); // 'profile' | 'demografi'

        // rules user
        $userRules = [
            'name'   => ['required','string','max:255'],  // default: wajib
            'nik'    => ['nullable','string','max:16', Rule::unique('users','nik')->ignore($userId)],
            'email'  => ['nullable','email', Rule::unique('users','email')->ignore($userId)],
            'phone'  => ['nullable','string','max:20'],
            'alamat' => ['nullable','string','max:65535'],
            'rt_id'  => ['nullable','exists:rts,id'],
            'rw_id'  => ['nullable','exists:rws,id'],
        ];

        // kalau kiriman dari form demografi, 'name' tidak wajib
        if ($section === 'demografi') {
            $userRules['name'] = ['sometimes','string','max:255'];
        }

        // rules residents/demografi
        $demoRules = [
            'birth_date'      => ['nullable','date'],
            'gender'          => ['nullable', Rule::in(array_keys(config('demography.gender_labels')))],
            'kk_number'       => ['nullable','string','max:32'],
            'education_level' => ['nullable', Rule::in(config('demography.education_levels'))],
            'occupation'      => ['nullable','string','max:255'],
            'religion'        => ['nullable', Rule::in(config('demography.religions'))],
            'marital_status'  => ['nullable', Rule::in(config('demography.marital_statuses'))],
            'income_bracket'  => ['nullable', Rule::in(config('demography.income_brackets'))],
            'disability_status'=> ['nullable','boolean'],
            'blood_type'      => ['nullable', Rule::in(config('demography.blood_types'))],
            'citizenship'     => ['nullable', Rule::in(config('demography.citizenships'))],
            'lat'             => ['nullable','numeric'],
            'lng'             => ['nullable','numeric'],
        ];

        return $userRules + $demoRules;
    }

}
