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
        $contacts = Contact::query(); 
        
        if ($name = $request->get('name')) {
            $contacts = $contacts->where('name', 'like', "%$name%");
        }
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
           
            $validatedData = $this->validate($request, [
                'name' => 'required|string',
                'type' => 'required|string|in:Work,Cellphone,Home',
                'number' => 'required|string|unique:contacts,number'
            ]);

            $contact = Contact::query()->create ([
                'name'=> $request->get('name'),
                'type'=> $request->get('type'),
                'number'=>$request->get('number')
            ]);
            
            return response()->json([
                'data' => $contact
            ], 200);
        } catch (\Exception $e) {
            
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
            $validatedData = $this->validate($request, [
                'name' => 'required|string',
                'type' => 'required|string|in:Work,Cellphone,Home',
                'number' => 'required|string|unique:contacts,number,' . $contact->id,
            ]);

            $contact->name = $request->get('name');
            $contact->type = $request->get('type');
            $contact->number = $request->get('number');
           
            $contact->save();
            
            return response()->json([
                'data' => $contact->fresh()
            ], 200);
        } catch (\Exception $e) {
            
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
        try {
            $contact->delete();
            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMesssage()
            ], 400);
        }
    }
}
