<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QueryResults;

class QueryResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $data = QueryResults::where('customer_query_id', $request->customer_query_id)->get();
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $data
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
            $resultData = [
                'concentration' => $request->concentration,
                'remarks' => $request->remarks,
                'lab_test_id' => $request->lab_test_id,
                'lab_test_parameter_id' => $request->lab_test_parameter_id,
                'customer_id' => $request->customer_id,
                'customer_query_id' => $request->customer_query_id,
                'sample_image_path' => $request->sample_image_path,
                'sample_collected' => $request->sample_collected
            ];
            $result = QueryResults::create($resultData);
            return response()->json([
                'success' => true,
                'message' => 'Query Result has been added successfully',
                'data'    => $result   
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $resultUpdateData = [
                'concentration' => $request->concentration,
                'remarks' => $request->remarks,
                'lab_test_id' => $request->lab_test_id,
                'lab_test_parameter_id' => $request->lab_test_parameter_id,
                'customer_id' => $request->customer_id,
                'customer_query_id' => $request->customer_query_id,
                'sample_image_path' => $request->sample_image_path,
                'sample_collected' => $request->sample_collected
            ];

            if(QueryResults::where('id', $id)->update($resultUpdateData)){
                return response()->json([
                    'success' => true,
                    'message' => 'Query Result has been updated successfully'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'No Query Result needs to be updated'
            ], 400);

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
        //
    }
}
