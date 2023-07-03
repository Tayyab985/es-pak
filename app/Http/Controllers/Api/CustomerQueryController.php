<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerQueries;
use App\Models\OperatorsWorked;
use App\Models\QueryResults;
use App\Models\QueryTests;
use Exception;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class CustomerQueryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            return response()->json([
                'success' => true,
                'message' => "",
                "data" => CustomerQueries::with('customer', 'customer.contactPersons', 'queryTests', 'queryTests.labTest', 'operatorsWorked', 'queryResults', 'queryResults.operator')->get()
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
            foreach($request->all() as $customerQuery){
                $customerQueryData = [
                    'customer_id' => $customerQuery['customer_id'],
                    'current_state' => $customerQuery['current_state'],
                ];

                $customerQureyInserted = CustomerQueries::create($customerQueryData);

                foreach($customerQuery['queryTests'] as $customerQueryTests){
                    $params = [
                        'lab_test_id' => $customerQueryTests['lab_test_id'],
                        'lab_test_parameter_ids' => $customerQueryTests['lab_test_parameter_ids'],
                        'customer_query_id' => $customerQureyInserted->id
                    ];

                    QueryTests::create($params);
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Query has been saved successfully"
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
            $customerQuery = CustomerQueries::where('id', $id)->with('customer', 'customer.contactPersons', 'queryTests', 'queryTests.labTest', 'operatorsWorked', 'queryResults', 'queryResults.operator')->get();
            return response()->json([
                'success' => true,
                'message' => "",
                "data" => $customerQuery
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $customerQuery = CustomerQueries::where('id', $id)->with('customer', 'customer.contactPersons', 'queryTests', 'queryTests.labTest', 'operatorsWorked', 'queryResults', 'queryResults.operator')->get();
            return response()->json([
                'success' => true,
                'message' => "",
                "data" => $customerQuery
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            foreach($request->all() as $customerQuery){
                $customerQueryData = [
                    'customer_id' => $customerQuery['customer_id'],
                    'current_state' => $customerQuery['current_state'],
                ];

                $customerQureyInserted = CustomerQueries::where('id', $id)->update($customerQueryData);

                foreach($customerQuery['queryTests'] as $customerQueryTests){
                    $params = [
                        'lab_test_id' => $customerQueryTests['lab_test_id'],
                        'lab_test_parameter_ids' => $customerQueryTests['lab_test_parameter_ids'],
                        'customer_query_id' => $id
                    ];

                    QueryTests::where('id', $customerQueryTests['id'])->update($params);
                }

                if(isset($customerQuery['operators_worked'])){
                    foreach($customerQuery['operators_worked'] as $operatorWorked){
                        if(isset($operatorWorked->id)){
                            $params = [
                                'operator_id' => $operatorWorked->operator_id,
                                'role' => $operatorWorked->role,
                                'customer_query_id' => $id
                            ];
        
                            OperatorsWorked::where('id', $operatorWorked->id)->update($params);
                        }else{
                            $params = [
                                'operator_id' => $operatorWorked->operator_id,
                                'role' => $operatorWorked->role,
                                'customer_query_id' => $customerQureyInserted->id
                            ];
        
                            OperatorsWorked::create($params);
                        }
                    }
                }

                if(isset($customerQuery['results'])){
                    foreach($customerQuery['results'] as $queryResult){
                        $params = [
                            "concentration" => $queryResult->concentration,
                            "remarks" => $queryResult->remarks,
                            "lab_test_id" => $queryResult->lab_test_id,
                            "lab_test_parameter_id" => $queryResult->lab_test_parameter_id,
                            "customer_id" => $queryResult->customer_id,
                            "customer_query_id" => $queryResult->customer_query_id,
                            "sample_image_path" => $queryResult->sample_image_path,
                            "sample_collected" => $queryResult->sample_collected,
                            "operator_id" => $queryResult->operator_id
                        ];
                        if(isset($queryResult->id)){
                            QueryResults::where('id', $queryResult->id)->update($params);
                        }else{
                            QueryResults::create($params);
                        }
                    }
                }
                foreach($customerQuery["to_delete_query_tests"] as $queryTestKey => $test_id){
                    $queryTest = QueryTests::findOrFail($test_id);
                    $queryTest->delete();
                }

            }



            return response()->json([
                'success' => true,
                'message' => "Query has been updated successfully"
            ]); 
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            $customerQuery = CustomerQueries::findOrFail($id);
            $customerQuery->queryTests()->delete();
            $customerQuery->delete();
            return response()->json([
                'success' => true,
                'message' => 'Customer Query has been deleted',
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400); 
        }
    }
}
