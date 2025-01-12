@extends('Admin.layouts.master')

@section('title', 'Lịch trình tiêm')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Thông tin lịch trình tiêm của bệnh nhân</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5  form-group pull-right top_search">
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
                                        <th>giới tính</th>
                                        <th>Ngày sinh</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                        {{-- <th>Lịch tiêm</th> --}}
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align: center">
                                        <td scope="row">1</td>
                                        <td>{{ $data['patient']->name }}</td>
                                        <td>Nữ</td>
                                        <td>{{ $data['patient']->dob }}</td>
                                        <td>{{ $data['patient']->email }}</td>
                                        <td>{{ $data['patient']->phone }}</td>
                                        <td>{{ $data['patient']->address }}</td>
                                        {{-- <td>bệnh nhân chưa có lịch tiêm nào</td> --}}
                                        <td>
                                            <a href="{{ route('vaccinescheduleCreate', ['id' => $data['patient']->id]) }}"
                                                class="btn btn-app" style="color: black">
                                                <i class="fa fa-edit"></i> Thêm lịch trình
                                            </a>
                                            <a href="{{ route('VCDetail', ['id' => $data['patient']->id]) }}"
                                                class="btn btn-app" style="color: black">
                                                <i class="fa fa-edit"></i> Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @if ($data['schedule']->count() > 0)
            @foreach ($data['schedule'] as $schedule)
                <div class="clearfix"></div>

                <div class="row" style="display: block;">
                    <div class="col-md-12 col-sm-12  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Tên vaccine: <small>{{ $schedule->vaccines->name }}</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                            aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#ModalDelete_{{$schedule->id}}"
                                                href="#"><i class="fa fa-trash"></i> Xóa lịch trình</a>
                                        </div>
                                    </li>
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên vaccine</th>
                                                <th>Phòng bệnh</th>
                                                <th>Thứ tự mũi</th>
                                                <th>Ngày dự kiến tiêm</th>
                                                <th>Trạng thái</th>
                                                <th>Ghi chú</th>
                                                <th>Chức năng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($schedule->details as $key => $detail)
                                                <tr>
                                                    <td scope="row">{{ $key + 1 }}</td>
                                                    <td> {{ $schedule->vaccines->name }}</td>
                                                    <td>{{ $schedule->vaccines->disease->name }}</td>
                                                    <td>{{ $detail->dose_number }}</td>
                                                    <td>{{ $detail->scheduled_date }}</td>
                                                    {{-- <td>{{ $detail->status }}</td> --}}
                                                    <td>
                                                        <span
                                                            class="{{ $detail->status === 0 ? 'badge-warning' : ($detail->status === 1 ? 'badge-success' : 'badge-danger') }} p-2 rounded-pill">

                                                            {{ $detail->status === 0 ? 'Chưa tiêm' : ($detail->status === 1 ? 'Đã tiêm' : 'Bị lỡ') }}
                                                        </span>
                                                    </td>


                                                    {{-- <td>Otto</td> --}}
                                                    <td>{{ $detail->notes }}</td>
                                                    <td>
                                                        {{-- <a href="{{ route('vaccinescheduleCreate', ['id' => $data['patient']->id]) }}"
                                                            class="btn btn-app" style="color: black">
                                                            <i class="fa fa-edit"></i>
                                                        </a> --}}
                                                        <a type="button" class="btn btn-app" data-toggle="modal"
                                                            data-target="#ModalStatus_{{ $detail->id }}">
                                                            <i class="fa fa-edit"></i> Cập nhật trạng thái
                                                        </a>
                                                    </td>
                                                </tr>


                                                <!-- Modal -->
                                                <div class="modal fade bd-example-modal-lg"
                                                    id="ModalStatus_{{ $detail->id }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <form
                                                                action="{{ route('vaccinescheduleUpdateStatus', @$detail->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                                                        Cập
                                                                        nhật trạng thái</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h6>Thứ tự mũi: {{ $detail->dose_number }}</h6>
                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="control-label col-md-2 col-sm-2 ">Trạng
                                                                            thái</label>
                                                                        <div class="col-md-10 col-sm-10">
                                                                            <select class="form-control col-md-6"
                                                                                name="status">
                                                                                <option value=""disabled selected>
                                                                                    --Cập nhật trạng thái--</option>
                                                                                <option value="0"
                                                                                    {{ 0 == $detail->status ? 'selected' : '' }}>
                                                                                    Chưa tiêm</option>
                                                                                <option value="1"
                                                                                    {{ 1 == $detail->status ? 'selected' : '' }}>
                                                                                    Đã tiêm</option>
                                                                                <option value="2"
                                                                                    {{ 2 == $detail->status ? 'selected' : '' }}>
                                                                                    Bị lỡ</option>
                                                                                {{-- <option value="2">Tiêm bù</option> --}}

                                                                            </select>
                                                                            {{-- {{ $detail->status}}
                                                                            {{ old('status')}} --}}
                                                                            <div class="clearfix"></div>
                                                                            {{-- @if ($errors->has('diseases_id'))
                                                                        <span class="text-danger" role="alert">{{ $errors->first('diseases_id') }}</span>
                                                                    @endif --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row ">
                                                                        <label class="control-label col-md-2 col-sm-2 ">Ghi
                                                                            chú</label>
                                                                        <div class="col-md-10 col-sm-10">
                                                                            <textarea class="resizable_textarea form-control col-md-6" style="height: 150px;" name="notes"
                                                                                placeholder="Nhập ghi chú"> {{ $detail->notes }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Hủy</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Lưu</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- modal xóa lịch trình --}}
                <div class="modal fade bd-example-modal-lg" id="ModalDelete_{{ $schedule->id }}" tabindex="-1"
                    role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Xóa lịch trình</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4>Bạn có chắc muốn xóa Lịch trình tiêm vaccsice:{{ $schedule->vaccines->name }} này không?
                                    </h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                    <form action="{{ route('vaccinescheduleDelete', $schedule->id) }}"
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
            @endforeach
        @else
            <div class="clearfix"></div>
            {{-- <div class="row" style="display: block;">
                <div class="col-md-12 col-sm-12  ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Bệnh nhân này chưa tiêm mũi nào</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> --}}
            <span>Bệnh nhân này chưa tiêm mũi nào</span>
        @endif



    </div>
@endsection
