<?php

namespace App\Http\Controllers\Admin\DecisionSupportSystem;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Employee;
use App\Utils\DecisionSupportSystem\Topsis;
use Illuminate\Http\Request;

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
        $employees = Employee::with('criteriaOptions.criteriaOption', 'criteriaValues', 'user')->get();

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

        $topsis = new Topsis($employeeData, $criteriaData);
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
            'averages'
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
