<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CriteriaRequest;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criteria = Criteria::latest()->paginate()->withQueryString();

        return view('admin.pages.criteria.index', compact('criteria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.criteria.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriteriaRequest $request)
    {
        Criteria::create($request->validated());

        return redirect(route('admin.criteria.index'))->with('success', 'Criteria created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Criteria $criteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criteria $criterion)
    {
        return view('admin.pages.criteria.form', compact('criterion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriteriaRequest $request, Criteria $criterion)
    {
        $criterion->update($request->validated());

        return redirect(route('admin.criteria.index'))->with('success', 'Criteria updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criterion)
    {
        $criterion->delete();

        return redirect(route('admin.criteria.index'))->with('success', 'Criteria deleted successfully');
    }
}
