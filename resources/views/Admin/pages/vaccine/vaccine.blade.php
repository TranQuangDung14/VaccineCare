@extends('Admin.layouts.master')

@section('title', 'Danh sách vaccines')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Danh sách <small>vaccines</small></h3>
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
                                        <th>Tên vaccine</th>
                                        <th>Phòng bệnh</th>
                                        <th>Số mũi cần tiêm</th>
                                        <th>Khoảng cách thời gian giữa mỗi mũi</th>
                                        <th>Ghi chú</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['vaccine'] as $key => $value)
                                        <tr style="text-align: center">
                                            <td scope="row">{{ $key + 1 }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->disease->name }}</td>
                                            <td>{{ $value->doses_required }}</td>
                                            <td>{{ $value->dose_intervals }}</td> 
                                            <td>{{ $value->description }}</td>
                                            <td>
                                                <a href="{{ route('vaccineEdit', ['id' => $value->id]) }}"
                                                    class="btn btn-app" style="color: black">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a>
                                                <a class="btn btn-app" data-toggle="modal" data-target="#ModalDelete_{{ $value->id }}"><i
                                                        class="fa fa-trash"></i> Xóa</a>

                                                <div class="modal fade delete-modal-lg" id="ModalDelete_{{ $value->id }}" tabindex="-1" role="dialog"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">Xóa</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h4>Bạn có chắc muốn xóa vaccine: "{{ $value->name }}" này
                                                                    không?</h4>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Đóng</button>
                                                                <form action="{{ route('vaccineDelete', $value->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Xóa</button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

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
