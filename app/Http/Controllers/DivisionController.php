<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    public function all(){
        $divisions = Division::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Divisions retrieved successfully',
            'data' => $divisions,
        ], 200);
    }
    /**
     * Menampilkan daftar semua divisi.
     */
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $per_page = $request->per_page ?? 10;
        $search = $request->search;

        $divisions = Division::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate($per_page, ['*'], 'page', $page);

        return response()->json([
            'status' => 'success',
            'message' => 'Divisions retrieved successfully',
            'data' => $divisions,
        ], 200);
    }

    /**
     * Menyimpan divisi baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:divisions,name',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $division = Division::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Division created successfully',
            'data' => $division,
        ], 201);
    }

    /**
     * Menampilkan detail divisi tertentu, termasuk daftar penggunanya.
     */
    public function show(Division $division)
    {
        // Mengambil divisi beserta daftar penggunanya (eager loading)
        $division->load('users'); 
        return response()->json($division);
    }

    /**
     * Mengupdate divisi tertentu.
     */
    public function update(Request $request, Division $division)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:divisions,name',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $division->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Division updated successfully',
            'data' => $division,
        ]);
    }

    /**
     * Menghapus divisi tertentu.
     */
    public function destroy(Division $division)
    {
        $division->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Division deleted successfully',
        ]);
    }
}
