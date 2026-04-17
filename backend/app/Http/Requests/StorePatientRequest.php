<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'cedula'             => 'required|string|max:20|unique:patients,cedula',
            'first_name'         => 'required|string|max:100',
            'last_name'          => 'required|string|max:100',
            'birth_date'         => 'required|date|before:today',
            'gender'             => 'required|in:Masculino,Femenino,Otro',
            'email'              => 'nullable|email|max:150|unique:patients,email',
            'phone'              => 'nullable|string|max:20',
            'blood_type'         => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'address'            => 'nullable|string',
            'allergies'          => 'nullable|string',
            'chronic_conditions' => 'nullable|string',
        ];
    }
}
