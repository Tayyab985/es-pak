<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerQueries;
use App\Models\QueryParameters;
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
                "data" => CustomerQueries::with('queryParams')->get()
            ], 400);
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
                    'lab_test_ids' => $customerQuery['lab_test_ids'],
                    'current_state' => $customerQuery['current_state'],
                    'operators_id' => $customerQuery['operators_id']
                ];

                $customerQureyInserted = CustomerQueries::create($customerQueryData);

                foreach($customerQuery['queryParameters'] as $customerQueryParams){
                    $params = [
                        'lab_test_id' => $customerQueryParams['lab_test_id'],
                        'lab_test_parameter_ids' => $customerQueryParams['lab_test_parameter_ids'],
                        'customer_query_id' => $customerQureyInserted->id
                    ];

                    QueryParameters::create($params);
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Query has been saved successfully"
            ], 400); 
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $customerQuery = CustomerQueries::where('id', $id)->with('queryParams')->get();
            return response()->json([
                'success' => true,
                'message' => "",
                "data" => $customerQuery
            ], 400);
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
                    'lab_test_ids' => $customerQuery['lab_test_ids'],
                    'current_state' => $customerQuery['current_state'],
                    'operators_id' => $customerQuery['operators_id']
                ];

                $customerQureyInserted = CustomerQueries::where('id', $id)->update($customerQueryData);

                foreach($customerQuery['queryParameters'] as $customerQueryParams){
                    $params = [
                        'lab_test_id' => $customerQueryParams['lab_test_id'],
                        'lab_test_parameter_ids' => $customerQueryParams['lab_test_parameter_ids'],
                        'customer_query_id' => $customerQureyInserted->id
                    ];

                    QueryParameters::where('id', $customerQueryParams['id'])->update($params);
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Query has been updated successfully"
            ], 400); 
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
        //
    }
}
