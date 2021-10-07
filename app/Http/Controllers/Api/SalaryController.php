<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salary;
use DB;

class SalaryController extends Controller
{

    public function salaryPaid(Request $request, $id)
    {
        $validated = $request->validate([
            'salary_month' => 'required',
        ]);

        $month = $request->salary_month;
        $check = Salary::where('salary_month', $month)->where('employee_id', $id)->first();
        if($check){
            return response()->json('Salart Alrady Paid');
        }else{
            $pay_salary = new Salary();
            $pay_salary->employee_id = $id;
            $pay_salary->amount = $request->salary;
            $pay_salary->salary_date = date('d/m/Y');
            $pay_salary->salary_month = $month;
            $pay_salary->salary_year = date('Y');
            $pay_salary->save();
        }
    
    }

    public function allSalary(){
        $salary = Salary::select('salary_month')->GroupBy('salary_month')->get();
        return response()->json($salary);
    }

    public function viewSalary($id){
        $salary = DB::table('salaries')->join('employees', 'salaries.employee_id', 'employees.id')
                        ->select('salaries.*', 'employees.name')
                        ->where('salaries.salary_month', $id)->get();
        
        return response()->json($salary);
    }
    public function editSalary($id){
        $salary = DB::table('salaries')->join('employees', 'salaries.employee_id', 'employees.id')
                        ->select('salaries.*', 'employees.name', 'employees.email')
                        ->where('salaries.id', $id)->get();
        
        return response()->json($salary);
    }

    public function updateSalary(Request $request,$id){
        $validated = $request->validate([
            'amount' => 'required',
            'salary_month' => 'required',
        ]);

        $pay_salary = Salary::find($id);
        $pay_salary->amount = $request->amount;
        $pay_salary->salary_month = $request->salary_month;
        $pay_salary->save();
    }

}
