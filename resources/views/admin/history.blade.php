@extends('layouts.admin')

@section('content')
    <div class="card-body">

        <form method="get" action="{{route('admin.report')}}">
            <label for="formFileSm" class="form-label">Bulan</label>
            <input type="text" name="month"  class="form-control mb-3">
            <label for="formFileSm" class="form-label">Tahun</label>
            <input type="text" name="year"  class="form-control mb-3">
            <div class="col-lg-6">
                <input class="btn btn-primary" type="submit" value="Cari">
                <a href="{{route('admin.report')}}" class="btn btn-warning" value="Reset">Reset</a>
            </div>

        </form>
    </div>
    <div class="card border-0 border-start border-bottom border-5 radius-15 border-secondary">
        <div class="card-header ">
            <h5 class="mt-3 mb-3">History Report</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Action</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Link</th>
                        <th>Report Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $key => $data)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$data->action ?  $data->action->name : null}}</td>
                            <td>{{$data->title}}</td>
                            <td>{{$data->category->name}}</td>
                            <td><a href="{{$data->link}}" target="blank">{{$data->link}}</a></td>
                            <td>{{date('d-m-Y || H:s', strtotime($data->created_at))}}</td>

                        </tr>
                    @endforeach
                    </tbody>

                </table>
                `
            </div>
        </div>
    </div>
@endsection
