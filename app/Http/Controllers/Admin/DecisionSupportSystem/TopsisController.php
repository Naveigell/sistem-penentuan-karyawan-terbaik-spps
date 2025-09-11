<?php

namespace App\Http\Controllers\Admin\DecisionSupportSystem;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\EmployeeCriteriaOption;
use App\Models\EmployeeCriteriaValue;
use App\Utils\DecisionSupportSystem\Topsis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopsisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Exception
     */
    public function index()
    {
        $criteria  = Criteria::all();
        $employees = Employee::with('criteriaOptions.criteriaOption', 'criteriaValues', 'user')
            ->addSelect([
                'total_option' => EmployeeCriteriaOption::selectRaw('COUNT(*)')->whereColumn('employees.id', 'employee_criteria_options.employee_id'),
                'total_values' => EmployeeCriteriaValue::selectRaw('COUNT(*)')->whereColumn('employees.id', 'employee_criteria_values.employee_id'),
            ])
            ->get();

        // check if employee has filled all criteria
        foreach ($employees as $employee) {
            if ($employee->total_option + $employee->total_values < $criteria->count()) {
                return redirect(route('admin.employees.index'))->with('error', 'Tolong lengkapi data kriteria pada karyawan : ' . $employee->user->name);
            }
        }

        $criteriaData = $criteria->map(fn(Criteria $criteria) => [
            "id"     => $criteria->id,
            "name"   => $criteria->name,
            "weight" => $criteria->weight,
            "type"   => $criteria->type->value,
        ])->toArray();

        $employeeData = $employees->map(fn(Employee $employee) => [
            "id"     => $employee->id,
            "name"   => $employee->user->name,
            "values" => $employee->resolveValues($criteria),
        ])->toArray();

        $precision = 5;

        $topsis = new Topsis($employeeData, $criteriaData);
        $topsis->setPrecision($precision);
        $topsis->calculate();

        $normalizations         = $topsis->getNormalization();
        $weightedNormalizations = $topsis->getWeightedNormalizations();
        $results                = $topsis->results();
        $idealSolutions         = $topsis->getIdealSolutions();
        $idealSolutionResults   = $topsis->getIdealSolutionResults();
        $averages               = $topsis->getAverages();

        return view('admin.pages.decision_support_system.topsis.index', compact(
            'criteria',
            'employees',
            'results',
            'normalizations',
            'weightedNormalizations',
            'idealSolutions',
            'idealSolutionResults',
            'averages',
            'precision'
        ));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
