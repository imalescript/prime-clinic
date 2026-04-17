<?php

namespace App\Http\Controllers;

use App\Models\Surgery;
use App\Http\Requests\StoreSurgeryRequest;
use App\Http\Requests\UpdateSurgeryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class SurgeryController extends Controller
{
    public function index(): JsonResponse
    {
        $surgeries = Surgery::with(['patient', 'type']);
        return response()->json($surgeries);
    }

    public function show($id): JsonResponse
    {
        $surgery = Surgery::findOrFail($id);
        return response()->json($surgery);
    }

    public function store(StoreSurgeryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $surgery = Surgery::create($data);
        return response()->json([
            'message' => 'Cirugía programada con éxito',
            'surgery' => $surgery
        ], 201);
    }

    public function update(UpdateSurgeryRequest $request, $id): JsonResponse
    {
        $surgery = Surgery::findOrFail($id);
        $surgery->update($request->validated());
        return response()->json([
            'message' => 'Cirugía actualizada correctamente',
            'surgery' => $surgery
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $surgery = Surgery::findOrFail($id);
        $surgery->delete();
        return response()->json([
            'message' => 'Cirugía eliminada del sistema'
        ]);
    }
}