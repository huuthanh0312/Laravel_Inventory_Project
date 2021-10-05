<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Image;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
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
            'name' => 'required|unique:employees|max:255',
            'email' => 'required',
            'phone' => 'required|unique:employees',

        ]);

        if($request->photo){
            $position = strpos($request->photo,';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1]; //get tail png, jpg, jpeg
            $img_name  =  time().'.'.$ext;    // merge image name  example.png
            $photo = Image::make($request->photo);
            $up_location = 'backend/employee/';
            $image_url = $up_location.$img_name;      //merge path image
            $photo->save($image_url);
    
            $employee = new Employee(); 
            $employee->name = $request->name; 
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->photo = $image_url;
            $employee->save();
            return response()->json(['Insert Employee Successfully']);
        }else{
            $employee = new Employee(); 
            $employee->name = $request->name; 
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->save();
            return response()->json(['Insert Employee Successfully Not Photo']);
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
        $data = Employee::find($id);
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
        $employee = Employee::find($id); 
        $employee->name = $request->name; 
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->salary = $request->salary;
        $employee->nid = $request->nid;
        $employee->joining_date = $request->joining_date;          
            
        $image = $request->newphoto;
        if($image){
            $position = strpos($image,';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1]; //get tail png, jpg, jpeg
            $img_name  =  time().'.'.$ext;    // merge image name  example.png
            $photo = Image::make($image);
            $up_location = 'backend/employee/';
            $image_url = $up_location.$img_name;      //merge path image
            $success = $photo->save($image_url);

            if($success){
                unlink($employee->photo);
                $employee->photo = $image_url;
            }
            
        }
        $employee->save();
        return response()->json(['Updated Employee Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if($employee->photo){
            unlink($employee->photo);
            Employee::find($id)->delete();
        }else{
            Employee::find($id)->delete();
        }
        
        
    }
}
