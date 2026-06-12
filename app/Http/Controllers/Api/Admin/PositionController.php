<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::latest()->get();
        return response()->json([
            'success' => true,
            'data' => $positions
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $position = Position::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Posisi berhasil ditambahkan.',
            'data' => $position
        ], 201);
    }

    public function show($id)
    {
        $position = Position::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $position
        ]);
    }

    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $position->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Posisi berhasil diperbarui.',
            'data' => $position
        ]);
    }

    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return response()->json([
            'success' => true,
            'message' => 'Posisi berhasil dihapus.'
        ]);
    }
}
