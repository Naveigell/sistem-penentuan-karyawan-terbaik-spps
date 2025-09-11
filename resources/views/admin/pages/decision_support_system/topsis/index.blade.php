@extends('layouts.admin.admin')

@section('content-title', 'Topsis')

@section('content-body')
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Topsis</h4>
                <div class="card-header-action">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#average-step-modal">Show Step</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Employee</th>
                            @foreach($criteria as $criterion)
                                <th>{{ $criterion->name }} ({{ $criterion->alphabet() }})</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $employee->user->name }}</td>
                                    @foreach($criteria as $criterion)
                                        @if($criterion->value_type->isOption())
                                            @php
                                                $value = optional(optional($employee->criteriaOptions->where('criteria_id', $criterion->id)->first())->criteriaOption)->value;
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @else
                                            @php
                                                $value = optional($employee->criteriaValues->where('criteria_id', $criterion->id)->first())->value;
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr>
                                <td>Average</td>
                                @foreach($criteria as $index => $criterion)
                                    <td>{{ $averages[$index] }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Normalization</h4>
                <div class="card-header-action">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#normalization-step-modal">Show Step</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Employee</th>
                            @foreach($criteria as $criterion)
                                <th>{{ $criterion->name }} ({{ $criterion->alphabet() }})</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->user->name }}</td>
                                @foreach($normalizations[$employee->id] as $normalization)
                                    <td>{{ $normalization }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Weighted Normalization</h4>
                <div class="card-header-action">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#weighted-normalization-step-modal">Show Step</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Employee</th>
                            @foreach($criteria as $criterion)
                                <th>{{ $criterion->name }} ({{ $criterion->alphabet() }})</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->user->name }}</td>
                                @foreach($weightedNormalizations[$employee->id] as $normalization)
                                    <td>{{ $normalization }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Ideal Solutions</h4>
                <div class="card-header-action">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ideal-solution-step-modal">Show Step</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Solution</th>
                            @foreach($criteria as $criterion)
                                <th>{{ $criterion->name }} ({{ $criterion->alphabet() }})</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($idealSolutions as $key => $solution)
                            <tr>
                                <td>{{ ucwords($key) }}</td>
                                @foreach($solution as $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Ideal Solution Distances</h4>
                <div class="card-header-action">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ideal-solution-distance-step-modal">Show Step</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Employee</th>
                            @foreach($idealSolutionResults as $key => $result)
                                <th>{{ ucwords($key) }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $index => $employee)
                            <tr>
                                <td>{{ $employee->user->name }}</td>

                                <td>{{ $idealSolutionResults['positive'][$index] }}</td>
                                <td>{{ $idealSolutionResults['negative'][$index] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Result</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Employee</th>
                            <th>Result</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $result['name'] }}</td>
                                    <td>{{ $result['result'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content-modal')
    @include('admin.includes.decision_support_system.topsis.average_modal', compact('normalizations', 'employees', 'averages'))
    @include('admin.includes.decision_support_system.topsis.normalization_modal', compact('normalizations', 'employees', 'averages', 'precision'))
    @include('admin.includes.decision_support_system.topsis.weighted_normalization_modal', compact('normalizations', 'employees', 'averages', 'precision'))
    @include('admin.includes.decision_support_system.topsis.ideal_solutions', compact('normalizations', 'employees', 'averages', 'precision', 'idealSolutions'))
    @include('admin.includes.decision_support_system.topsis.ideal_solution_distances', compact('normalizations', 'employees', 'averages', 'precision', 'idealSolutions', 'idealSolutionResults', 'weightedNormalizations'))
@endsection
