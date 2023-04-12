<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactPersonRequest;
use App\Models\ContactPerson;
use Exception;
use Illuminate\Http\Request;

class ContactPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{    
            return response()->json([
                "success" => true,
                'message' => "",
                "data" => ContactPerson::all()
            ]);

        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
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
    public function store(ContactPersonRequest $request)
    {
        try{    

            return response()->json([
                "success" => true,
                'message' => "Contact person has been saved",
                "data" => ContactPerson::create($request->all())
            ]);

        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{    

            return response()->json([
                "success" => true,
                'message' => "",
                "data" => ContactPerson::with('customers')->findOrFail($id)
            ]);

        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{    

            return response()->json([
                "success" => true,
                'message' => "",
                "data" => ContactPerson::with('customers')->findOrFail($id)
            ]);

        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try
        {    
            if(ContactPerson::where('id', $id)->update($request->all())){
                return response()->json([
                    "success" => true,
                    'message' => "Contact person has been updated successfully"
                ]);
            }
            else{
                return response()->json([
                    "success" => false,
                    "message" => 'No contact person needs to be updated'
                ], 400);
            }
            

        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{    
            if(ContactPerson::where('id', $id)->delete())
            {
                return response()->json([
                    "success" => true,
                    'message' => "Contact Perspon has been deleted"
                ]);
            }else
            {
                return response()->json([
                    "success" => false,
                    'message' => "No contact person found for deleting"
                ], 400);
            }
            

        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 400);
        }
    }
}
