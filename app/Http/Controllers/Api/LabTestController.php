<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabTestRequest;
use App\Models\LabTestParameters;
use App\Models\LabTests;
use App\Models\Units;
use Exception;
use Illuminate\Http\Request;

class LabTestController extends Controller
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
                'data' => LabTests::all()
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
    public function store(Request $request)
    {
        try{
            foreach($request->all() as $labKey => $lab){
                $labDataArray = ['name' => $lab['name']];
                $labTest = LabTests::create($labDataArray);

                foreach($lab['parameters'] as $parameterKey => $parameter)
                {
                    $labParameterDataArray = [
                        'name' => $parameter['name'],
                        'method' => $parameter['method'],
                        'equipment_used' => $parameter['equipment_used'],
                        'uncertainity' => $parameter['uncertanity'],
                        'lab_test_id' => $labTest->id
                    ];

                    $labTestParamerter = LabTestParameters::create($labParameterDataArray);

                    foreach($parameter['units'] as $unitKey => $unit){
                      $unitArray = ['name' => $unit['name'], 'lab_test_parameter_id' =>  $labTestParamerter->id];
                      
                      Units::create($unitArray);
                    }
                }
            }
            

            return response()->json([
                'success' => true,
                'message' => 'Lab Test has been added successfully'
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
            $labTest = LabTests::with('labTestParameters')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $labTest
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
            $labTest = LabTests::with('labTestParameters')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $labTest
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
    public function update(Request $request, string $id)
    {
        try{
            $labTestUpdatedData = ['name' => $request->name];
            LabTests::where('id', $id)->update($labTestUpdatedData);
            return response()->json([
                'success' => true,
                'message' => 'Lab Test has been updated successfully'
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
            LabTests::where('id', $id)->with('labTestParameters')->delete();
            return response()->json([
                'success' => true,
                'message' => 'Lab Test has been deleted',
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
