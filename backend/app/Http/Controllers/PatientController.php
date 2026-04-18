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

    public function show($id): JsonResponse
    {
        $patient = Patient::findOrFail($id);
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

    public function update(UpdatePatientRequest $request, $id): JsonResponse
    {
        $patient = Patient::findOrFail($id);
        $data = $request->validated();
        $patient->update($data);
        return response()->json([
            'message' => 'Información del paciente actualizada correctamente',
            'patient' => $patient
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return response()->json(['message' => 'Paciente eliminado correctamente']);
    }
}