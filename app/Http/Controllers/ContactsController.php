<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        // Sends query to the contact model
        $contacts = Contact::query(); 
        // Takes the name parameter from request
        if ($name = $request->get('name')) {
            // Where name contains the name that comes from the request
            $contacts = $contacts->where('name', 'like', "%$name%");
        }
        // Takes data from DataBase
        return  $contacts->orderBy('name')->get();
    
        
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try {
        // Validate checks the incoming data as we want them
            $validatedData = $this->validate($request, [
                // 'name' must be sent because it is required and must be a string
                'name' => 'required|string',
               // 'type' must be sent because it is required, must be a string and have the value Work, Cellphone or Home
                'type' => 'required|string|in:Work,Cellphone,Home',
                // 'number' must be sent because it is required and must be a string. Meanwhile it must be UNIQUE in the contacts table in the number column
                'number' => 'required|string|unique:contacts,number'
            ]);

            // Creating contact with the data that comes in the request
            $contact = Contact::query()->create ([
                'name'=> $request->get('name'),
                'type'=> $request->get('type'),
                'number'=>$request->get('number')
            ]);
            // Responds with the newly created contact
            return response()->json([
                'data' => $contact
            ], 200);
        } catch (\Exception $e) {
            // In case an error occurs, it makes the handle exception which throws php and formats the error message
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        // Returns 'data' from contact
        return response()->json(['data' => $contact], 200);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        try {
            // Validate checks the incoming data as we want them. If we do update, we will exclude the current value of the number in the control
            $validatedData = $this->validate($request, [
                'name' => 'required|string',
                'type' => 'required|string|in:Work,Cellphone,Home',
                'number' => 'required|string|unique:contacts,number,' . $contact->id,
            ]);
         // 'name', 'type' and 'number' of the existing contact that will be updated, overlap with those that come in request
            $contact->name = $request->get('name');
            $contact->type = $request->get('type');
            $contact->number = $request->get('number');
        //    Saves changes in Database
            $contact->save();
            // Returns the updated contact
            return response()->json([
                'data' => $contact->fresh()
            ], 200);
        } catch (\Exception $e) {
            // In case an error occurs, it makes the handle exception which throws php and formats the error message
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        // Deletes the 'contact' parameter
        try {
            $contact->delete();
            return response()->json([], 204);
        } catch (\Exception $e) {
            // In case an error occurs, it makes the handle exception which throws php and formats the error message
            return response()->json([
                'message' => $e->getMesssage()
            ], 400);
        }
    }
}
