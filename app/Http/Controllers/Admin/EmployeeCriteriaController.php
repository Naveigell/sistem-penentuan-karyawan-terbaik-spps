<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeCriteriaRequest;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\EmployeeCriteriaOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeCriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Employee $employee)
    {
        $employee->loadMissing('user', 'criteriaOptions', 'criteriaValues');
        $criteria = Criteria::all();

        return view('admin.pages.employee_criteria.index', compact('employee', 'criteria'));
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
     * @throws \Throwable
     */
    public function store(EmployeeCriteriaRequest $request, Employee $employee)
    {
        $criteria = Criteria::with('options', 'range')->get();

        DB::beginTransaction();

        try {
            foreach ($criteria as $criterion) {
                if ($criterion->value_type->isOption()) {
                    $employee->criteriaOptions()->updateOrCreate([
                        'criteria_id' => $criterion->id,
                    ], [
                        'criteria_option_id' => $request->validated('criteria.' . $criterion->id),
                    ]);
                } else {
                    $employee->criteriaValues()->updateOrCreate([
                        'criteria_id' => $criterion->id,
                    ], [
                        'value' => $request->validated('criteria.' . $criterion->id),
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            dd($exception->getMessage());
        }

        return redirect(route('admin.employees.criteria.index', $employee))->with('success', 'Criteria updated successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
