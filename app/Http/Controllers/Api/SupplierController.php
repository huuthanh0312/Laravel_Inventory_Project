<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Image;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|unique:suppliers|max:255',
            'email' => 'required',
            'phone' => 'required|unique:suppliers',

        ]);

        if($request->photo){
            $position = strpos($request->photo,';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1]; //get tail png, jpg, jpeg
            $img_name  =  time().'.'.$ext;    // merge image name  example.png
            $photo = Image::make($request->photo);
            $up_location = 'images/supplier/';
            $image_url = $up_location.$img_name;      //merge path image
            $photo->save($image_url);
    
            $supplier = new Supplier(); 
            $supplier->name = $request->name; 
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shopname = $request->shopname;
            $supplier->photo = $image_url;
            $supplier->save();
            return response()->json(['Insert Supplier Successfully']);
        }else{
            $supplier = new Supplier(); 
            $supplier->name = $request->name; 
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shopname = $request->shopname;
            $supplier->save();
            return response()->json(['Insert Supplier Successfully Not Photo']);
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
        $data = Supplier::find($id);
        return response()->json($data);
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
        $supplier = Supplier::find($id); 
        $supplier->name = $request->name; 
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->shopname = $request->shopname;       
            
        $image = $request->newphoto;
        if($image){
            $position = strpos($image,';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1]; //get tail png, jpg, jpeg
            $img_name  =  time().'.'.$ext;    // merge image name  example.png
            $photo = Image::make($image);
            $up_location = 'images/supplier/';
            $image_url = $up_location.$img_name;      //merge path image
            $success = $photo->save($image_url);

            if($success){
                unlink($supplier->photo);
                $supplier->photo = $image_url;
            }
            
        }
        $supplier->save();
        return response()->json(['Updated Supplier Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if($supplier->photo){
            unlink($supplier->photo);
            Supplier::find($id)->delete();
        }else{
            Supplier::find($id)->delete();
        }
    }
}
