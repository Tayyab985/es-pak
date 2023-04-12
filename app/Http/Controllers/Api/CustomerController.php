<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customers;
use App\Models\Locations;
use App\Models\ContactPerson;
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
                'data' => Customers::with('locations', 'contactPersons')->get()
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
                $cus = $request->all();
                $customerArray = [
                    'company_name' => $cus["company_name"],
                    'company_address' => $cus['company_address'],
                    'company_phone' => $cus["company_phone"],
                    'company_email' => $cus["company_email"],
                ];
                $customerArray['generated_id'] = rand(100000, 999999);
                $customerArray['password'] = rand(100000, 999999);
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

                foreach($cus["contact_persons"] as $contactPersonKey => $contact_persons){
                    $contactPerson = [
                        'name' => $contact_persons["name"],
                        'phone_number' => $contact_persons["phone_number"],
                        'customer_id' => $customer->id
                    ];

                    ContactPerson::create($contactPerson);
                }

            
            return response()->json([
                'success' => true,
                'message' => 'Customer has been added successfully',
                'data' => Customers::with('locations', 'contactPersons')->findOrFail($customer->id)
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

            $customer = Customers::with('locations', 'contactPersons')->findOrFail($id);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
                $cus = $request->all();

                $customerArray = [
                    'company_name' => $cus["company_name"],
                    'company_address' => $cus['company_address'],
                    'company_phone' => $cus["company_phone"],
                    'company_email' => $cus["company_email"],
                    'password' => $cus["password"],
                ];
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

                foreach($cus["contact_persons"] as $contactPersonKey => $contact_persons){
                    $contactPerson = [
                        'name' => $contact_persons["name"],
                        'phone_number' => $contact_persons["phone_number"],
                        'customer_id' => $id
                    ];

                    ContactPerson::where('id', $contact_persons['id'])->update($contactPerson);
                }
            

                foreach($cus["to_delete_locations"] as $locationKey => $location_id){
                    Locations::where('id', $location_id)->delete();
                }

                foreach($cus["to_delete_contacts"] as $contactPersonKey => $contact_person_id){
                    ContactPerson::where('id', $contact_person_id)->delete();
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

            $customer = Customers::findOrFail($id);
            $customer->locations()->delete();
            $customer->contactPersons()->delete();
            $customer->delete();
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
