<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('user')->latest()->paginate()->withQueryString();

        return view('admin.pages.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.employee.form');
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(EmployeeRequest $request)
    {
        DB::beginTransaction();

        try {
            $employee = Employee::create($request->employeeData());
            $employee->user()->create($request->userData());

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            dd($exception->getMessage());
        }

        return redirect(route('admin.employees.index'))->with('success', 'Employee created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('admin.pages.employee.form', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     * @throws \Throwable
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        DB::beginTransaction();

        try {
            $employee->update($request->employeeData());
            $employee->user()->update($request->userData());

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            dd($exception->getMessage());
        }

        return redirect(route('admin.employees.index'))->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
