<?php

namespace App\Http\Controllers;

use App\Models\Patient; 
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class PatientController extends Controller
{
    public function index(): JsonResponse
    {
        $patients = Patient::with(['user', 'surgery'])->get();
        return response()->json($patients);
    }

    public function show(Patient $patient) {
    return response()->json($patient);
    }
    
    public function store(StorePatientRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $patient = Patient::create($data);
        return response()->json([
            'message' => 'Paciente registrado con éxito',
            'patient' => $patient
        ], 201);
    }

    public function update(UpdatePatientRequest $request, Patient $patient): JsonResponse
    {
        $patient->update($request->validated());
    
        return response()->json([
            'message' => 'Paciente actualizado con éxito',
            'patient' => $patient
        ]);
    }

    public function destroy(Patient $patient): JsonResponse
    {
        $patient->delete();
        return response()->json(['message' => 'Paciente eliminado correctamente']);
    }
}