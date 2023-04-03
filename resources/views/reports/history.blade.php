@extends('layouts.master')

@section('content')
    <div class="card border-0 border-start border-bottom border-5 radius-15 border-secondary">
        <div class="card-header ">
            <h5 class="mt-3 mb-3">History Report</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Action</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th width="10%" class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $key => $data)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$data->action ? $data->action->name : null}}</td>
                            <td>{{$data->title}}</td>
                            <td>{{$data->category->name}}</td>
                            <td>{{$data->subCategory ? $data->subCategory->name : null}}</td>
                            <td><a href="{{$data->link}}" target="_blank" class="btn btn-sm btn-primary d-grid">view</a> </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
