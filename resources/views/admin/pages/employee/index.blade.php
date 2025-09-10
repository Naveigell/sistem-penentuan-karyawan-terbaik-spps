@extends('layouts.admin.admin')

@section('content-title', 'Karyawan')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Karyawan</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Karyawan</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-2">Nama Karyawan</th>
                            <th class="col-2">Email</th>
                            <th class="col-2">No Telp</th>
                            <th class="col-2">Alamat</th>
                            <th class="col-2">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>
                                    <x-iterate :pagination="$employees" :loop="$loop"></x-iterate>
                                </td>
                                <td>{{ $employee->user->name }}</td>
                                <td>{{ $employee->user->email }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>
                                    <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-warning"><i class="fa fa-pen"></i></a>
                                    <button class="btn btn-danger btn-action trigger--modal-delete cursor-pointer" data-url="{{ route('admin.employees.destroy', $employee) }}"><i class="fas fa-trash"></i></button>
                                    <a href="{{ route('admin.employees.criteria.index', $employee) }}" class="btn btn-light"><i class="fa fa-list"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Data Empty</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $employees->links() }}
            </div>
        </div>
    </div>
@endsection

@section('content-modal')
    <x-modal.delete :name="'Karyawan'"></x-modal.delete>
@endsection
