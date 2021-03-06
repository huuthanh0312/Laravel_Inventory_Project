<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::all();
        return response()->json($customer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:customers|max:255',
            'email' => 'required',
            'phone' => 'required|unique:customers',

        ]);

        if($request->photo){
            $position = strpos($request->photo,';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1]; //get tail png, jpg, jpeg
            $img_name  =  time().'.'.$ext;    // merge image name  example.png
            $photo = Image::make($request->photo);
            $up_location = 'images/customer/';
            $image_url = $up_location.$img_name;      //merge path image
            $photo->save($image_url);
    
            $customer = new Customer(); 
            $customer->name = $request->name; 
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->photo = $image_url;
            $customer->save();
            return response()->json(['Insert Customer Successfully']);
        }else{
            $customer = new Customer(); 
            $customer->name = $request->name; 
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->save();
            return response()->json(['Insert Customer Successfully Not Photo']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required',

        ]);
        $customer = Customer::find($id); 
        $customer->name = $request->name; 
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;         
            
        $image = $request->newphoto;
        if($image){
            $position = strpos($image,';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1]; //get tail png, jpg, jpeg
            $img_name  =  time().'.'.$ext;    // merge image name  example.png
            $photo = Image::make($image);
            $up_location = 'images/customer/';
            $image_url = $up_location.$img_name;      //merge path image
            $success = $photo->save($image_url);

            if($success){
                unlink($customer->photo);
                $customer->photo = $image_url;
            }
            
        }
        $customer->save();
        return response()->json(['Updated Customer Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if($customer->photo){
            unlink($customer->photo);
            Customer::find($id)->delete();
        }else{
            Customer::find($id)->delete();
        }
        return response()->json(['Deleted Customer Successfully']);
    }
}
