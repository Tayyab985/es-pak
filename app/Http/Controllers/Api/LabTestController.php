<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabTestRequest;
use App\Models\LabTestParameterLimit;
use App\Models\LabTestParameters;
use App\Models\LabTests;
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
                'data' => LabTests::with('labTestParameters.limits')->get()
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
                $lab = $request->all();
                $labDataArray = ['name' => $lab['name']];
                $labTest = LabTests::create($labDataArray);
                if(isset($lab['parameters']))
                {
                    foreach($lab['parameters'] as $parameterKey => $parameter)
                    {
                        $labParameterDataArray = [
                            'name' => $parameter['name'],
                            'method' => $parameter['method'],
                            'equipment' => $parameter['equipment'],
                            'uncertainty' => $parameter['uncertainty'],
                            'units' => $parameter['units'],
                            'lab_test_id' => $labTest->id
                        ];
    
                        $labTestParamerter = LabTestParameters::create($labParameterDataArray);
                        

                        if(isset($parameter['limits']))
                        {
                            foreach($parameter['limits'] as $limitKey => $limit){
                                $limitArray = [
                                    'min_value' => $limit['min_value'], 
                                    'max_value' =>  $limit['max_value'],
                                    'limit_type_enum' => $limit['limit_type_enum'],
                                    'lab_test_parameter_id' => $labTestParamerter->id
                                ];
                                LabTestParameterLimit::create($limitArray);
                            }
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
            $labTest = LabTests::with('labTestParameters.limits')->findOrFail($id);
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
            $labTest = LabTests::with('labTestParameters.limits')->findOrFail($id);
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
                $lab = $request->all();
                $labDataArray = ['name' => $lab['name']];
                $labTest = LabTests::where('id', $id)->update($labDataArray);
                if(isset($lab['parameters']))
                {
                    foreach($lab['parameters'] as $parameterKey => $parameter)
                    {
                        $labParameterDataArray = [
                            'name' => $parameter['name'],
                            'method' => $parameter['method'],
                            'equipment' => $parameter['equipment'],
                            'uncertainty' => $parameter['uncertainty'],
                            'units' => $parameter['units'],
                            'lab_test_id' => $labTest->id
                        ];
    
                        $labTestParamerter = LabTestParameters::where('id', $parameter->id)->update($labParameterDataArray);
                       

                        if(isset($parameter['limits']))
                        {
                            foreach($parameter['limits'] as $limitKey => $limit){
                                $limitArray = [
                                    'min_value' => $limit['min_value'], 
                                    'max_value' =>  $limit['max_value'],
                                    'limit_type_enum' => $limit['limit_type_enum'],
                                    'lab_test_parameter_id' => $labTestParamerter->id
                                ];
                                LabTestParameterLimit::where('id', $limit->id)->update($limitArray);
                            }
                        }
                        
                    }
                }
                
         
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
            
            $labTest = LabTests::findOrFail($id);
            $labTest->labTestParameters()->each(function ($labTestParameter){
                $labTestParameter->limits()->delete();
            });
            $labTest->labTestParameters()->delete();
            $labTest->delete();
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
