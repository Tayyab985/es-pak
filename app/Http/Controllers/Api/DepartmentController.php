<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Departments;
use Exception;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => Departments::all()
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),

            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        try{
            $department = Departments::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Department has been added successfully',
                'data' => $department
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);    
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $department = Departments::with('operator')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $department
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
               
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $department = Departments::with('operator')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $department
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
               
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, string $id)
    {
        try{
            $departmentUpdatedData = ['name' => $request->name];
            Departments::where('id', $id)->update($departmentUpdatedData);
            return response()->json([
                'success' => true,
                'message' => 'Department has been updated successfully'
            ]);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            Departments::where('id', $id)->with('operator')->delete();
            return response()->json([
                'success' => true,
                'message' => 'Department has been deleted',
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
