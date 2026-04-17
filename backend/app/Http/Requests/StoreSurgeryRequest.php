<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSurgeryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id'      => 'required|exists:patients,id',
            'surgery_type_id' => 'required|exists:surgery_types,id',
            'scheduled_date'  => 'required|date', 
            'status' => [
                'required',
                Rule::in(['Pendiente', 'Realizada', 'Atrasada', 'Cancelada']),
            ],
            'execution_date' => [
                'nullable',
                'date',
                'required_if:status,Realizada',
                'after_or_equal:scheduled_date'
            ],
            'observations'    => 'nullable|string|max:1000',
        ];
    }
}