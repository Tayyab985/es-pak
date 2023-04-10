<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperatorRequest;
use App\Models\Operators;
use Exception;
use Illuminate\Http\Request;

class OperatorController extends Controller
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
                'data'    => Operators::all()   
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
    public function store(OperatorRequest $request)
    {
        try{
            $operator = Operators::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Operator has been added successfully',
                'data'    => $operator   
            ]);
        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),   
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $operators = Operators::with('department')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $operators
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
            $operators = Operators::with('depatment')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $operators
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
    public function update(OperatorRequest $request, string $id)
    {
        try{
            $operatorUpdatedData = [
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'role' => $request->role,
                'department_id' => $request->department_id
            ];
            if(!empty($request->password)  || $request->password != NULL){
                $operatorUpdatedData['password'] = $request->password;
            }
            Operators::where('id', $id)->update($operatorUpdatedData);
            return response()->json([
                'success' => true,
                'message' => 'Operater has been updated successfully'
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
            Operators::where('id', $id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Operator has been deleted',
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
