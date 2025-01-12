@extends('Admin.layouts.master')

@section('title', 'Danh sách lịch tiêm')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Danh sách<small> lịch tiêm</small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row" style="display: block;">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Basic Tables <small>basic table subtitle</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Settings 1</a>
                                    <a class="dropdown-item" href="#">Settings 2</a>
                                </div>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>#</th>
                                        <th>Tên bệnh nhân</th>
                                        <th>Ngày sinh</th>
                                        {{-- <th>Email</th> --}}
                                        <th>Số điện thoại</th>
                                        {{-- <th>Địa chỉ</th> --}}
                                        <th>Lịch tiêm</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['patient'] as $key => $value)
                                        <tr style="text-align: center">
                                            <td scope="row">{{ $key + 1 }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->dob }}</td>
                                            {{-- <td>{{$value->email}}</td> --}}
                                            <td>{{ $value->phone }}</td>
                                            <td>bệnh nhân chưa có lịch tiêm nào</td>
                                            <td>
                                                <a href="{{ route('VCDetail', ['id' => $value->id]) }}" class="btn btn-app"
                                                    style="color: black">
                                                    <i class="fa fa-calendar"></i> Lịch tiêm
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
