<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EmployeeResource::collection(Employee::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'var_name' => 'required',
            'var_last_name' => 'required',
            'var_dni' => 'required',
            'var_email' => 'required|email',
            'var_phone' => 'required'
        ]);
        
        if($validator->fails()){
            return (new EmployeeResource(null))->additional(['success' => false,'message' => 'Validation Error','errors' =>  $validator->errors()]);      
        }

        $employee = Employee::create($request->all());

        if($employee){
           return (new EmployeeResource($employee))->additional(['success' => true,'message' => 'employee create']);
        }

        return (new EmployeeResource($employee))->additional(['success' => false,'message' => 'employee no create']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if (empty($employee)) {
            return (new EmployeeResource($employee))->additional(['success' => false,'message' => 'employee not found.']);
        }

        return new EmployeeResource($employee);
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
        $employee = Employee::find($id);
        
        if (empty($employee)) {
            return (new EmployeeResource($employee))->additional(['success' => false,'message' => 'employee not found.']);;
        }

        $validator = Validator::make($request->all(),[
            'var_name' => 'required',
            'var_last_name' => 'required',
            'var_dni' => 'required',
            'var_email' => 'required|email',
            'var_phone' => 'required'
        ]);

        if($validator->fails()){
            return (new EmployeeResource(null))->additional(['success' => false,'message' => 'Validation Error','errors' =>  $validator->errors()]);      
        }

        $employee->update($request->all());
        return new EmployeeResource($employee);
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
        
        if (empty($employee)) {
            return (new EmployeeResource($employee))->additional(['success' => false,'message' => 'employee not found.']);
        }
        
        $employee->delete();
        return new EmployeeResource($employee);
    }
}
