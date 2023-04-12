<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customers;
use App\Models\Locations;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
                'data' => Customers::all()
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
            foreach($request->all() as $customerKey => $cus){
                $customerArray = [
                    'company_name' => $cus["company_name"],
                    'company_address' => $cus['company_address'],
                    'company_phone' => $cus["company_phone"],
                    'company_email' => $cus["company_email"],
                    'generated_id' => $cus["generated_id"]
                ];
                $customerArray['password'] = rand(100, 10000);
                $customer = Customers::create($customerArray);

                foreach($cus["locations"] as $locationKey => $locations){
                    $location = [
                        'street1' => $locations["street1"],
                        'street2' => $locations["street2"],
                        'city' => $locations["city"],
                        'region' => $locations["region"],
                        'customer_id' => $customer->id
                    ];

                    Locations::create($location);
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Customer has been added successfully',
                'data' => Customers::with('location')->findOrFail($customer->id)
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

            $customer = Customers::with('location', 'contactPersons')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $customer
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

            $customer = Customers::with('location')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $customer
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
            foreach($request->all() as $customerKey => $cus){
                $customerArray = [
                    'company_name' => $cus["company_name"],
                    'company_address' => $cus['company_address'],
                    'company_phone' => $cus["company_phone"],
                    'company_email' => $cus["company_email"],
                    'generated_id' => $cus["generated_id"]
                ];
                $customerArray['password'] = rand(100, 10000);
                Customers::where('id', $id)->update($customerArray);

                foreach($cus["locations"] as $locationKey => $locations){
                    $location = [
                        'street1' => $locations["street1"],
                        'street2' => $locations["street2"],
                        'city' => $locations["city"],
                        'region' => $locations["region"],
                        'customer_id' => $id
                    ];

                    Locations::where('id', $locations['id'])->update($location);
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Customer has been updated successfully',
                'data' => ''
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

            $customer = Customers::where('id', $id)->with('location')->delete();
            return response()->json([
                'success' => true,
                'message' => 'Customer has been deleted',
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400); 
        }
    }
}
