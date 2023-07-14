@extends('layouts.app')
@section('title', 'Assignments')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5>Assignments</h5>
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Create assignment
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (isset($assignments) && count($assignments) > 0)
                    <div class="table-responsive">
                        <table
                            class="table table-striped
                    table-hover
                    table-bordered
                    table-primary
                    align-middle">
                            <thead class="table-light">
                                <caption>Assignments</caption>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th class="text-nowrap">Due date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($assignments as $assignment)
                                    <tr class="table-secondary">
                                        <td scope="row">{{ $assignment->title }}</td>
                                        <td>{{ $assignment->description }}</td>
                                        <td class="text-nowrap">{{ date('jS M Y', strtotime($assignment->due_date)) }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="col"><i class="bi bi-pencil btn shadow"></i></div>
                                                <div class="px-1"></div>
                                                <div class="col">
                                                    <a href="{{ route('assignments.view', ['id' => $assignment->id]) }}">
                                                        <i class="bi bi-eye btn shadow"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="p-3">No assignments</div>
                @endif
            </div>
            {{-- Create assignment modal --}}
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Create Assignment
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('assignment.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="title">Assignment title</label>
                                            <input type="text" name="title"
                                                class="form-control @error('title') is-invalid @enderror"
                                                value="{{ old('title') }}">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="due_date">Due date</label>
                                            <input type="date" name="due_date"
                                                class="form-control @error('due_date') is-invalid @enderror"
                                                value="{{ old('due_date') }}">
                                            @error('due_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Assignment description"></label>
                                            <textarea name="description" id="description" cols="" rows="10"
                                                class="form-control @error('description') is-invalid @enderror" placeholder="Please describe your assignment here"></textarea>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-between">
                                    <button class="btn btn-success" type="submit">Post Assignment</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
