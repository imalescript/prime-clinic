<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        $patientId = $this->route('id');
        
        return [
            'cedula' => [
                'required',
                'string',
                'max:20',
                Rule::unique('patients')->ignore($patientId),
            ],
            'first_name'         => 'required|string|max:100',
            'last_name'          => 'required|string|max:100',
            'birth_date'         => 'required|date',
            'gender'             => 'required|in:Masculino,Femenino,Otro',
            'email' => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('patients')->ignore($patientId),
            ],
            'phone'              => 'nullable|string|max:20',
            'blood_type'         => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'address'            => 'nullable|string',
            'allergies'          => 'nullable|string',
            'chronic_conditions' => 'nullable|string',
        ];
    }
}
