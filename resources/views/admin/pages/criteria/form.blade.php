@extends('layouts.admin.admin')

@section('content-title', 'Criteria')

@section('content-body')
    <div class="col-12 col-md-12 col-lg-12 no-padding-margin">
        <div class="card">
            <form action="{{ @$criterion ? route('admin.criteria.update', $criterion) : route('admin.criteria.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method(@$criterion ? 'PUT' : 'POST')
                <div class="card-header">
                    <h4>Criteria Form</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', @$criterion ? $criterion->name : '') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Weight</label>
                        <input type="number" class="form-control @error('weight') is-invalid @enderror" name="weight" value="{{ old('weight', @$criterion ? $criterion->weight : '') }}">
                        @error('weight')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror">
                            <x-nothing-selected></x-nothing-selected>
                            @foreach(\App\Utils\DecisionSupportSystem\Enums\CriteriaType::cases() as $case)
                                <option @if(old('type', @$criterion ? $criterion->type->value : '') == $case->value) selected @endif value="{{ $case->value }}">{{ $case->label() }}</option>
                            @endforeach
                        </select>
                        @error('type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Value Type</label>
                        <select name="value_type" class="form-control @error('value_type') is-invalid @enderror">
                            <x-nothing-selected></x-nothing-selected>
                            @foreach(\App\Enums\CriteriaValueType::cases() as $case)
                                <option @if(old('type', @$criterion ? $criterion->value_type->value : '') == $case->value) selected @endif value="{{ $case->value }}">{{ $case->label() }}</option>
                            @endforeach
                        </select>
                        @error('value_type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
