@extends('Admin.layouts.master')

@section('title', 'Thêm mới lịch tiêm')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Thêm lịch tiêm</h3>
                {{-- <h3>Cập nhật lại thông tin bệnh nhân</h3> --}}
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
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="clearfix"></div>

        <div class="row">
            {{-- //đây --}}
            <div class="col-md-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>THÊM MỚI</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        @if (isset($editData))
                            <form action="{{ route('patientUpdate', @$editData->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            @else
                                <form class="form-horizontal form-label-left" action="{{ route('vaccinescheduleStore') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                        @endif
                        <input type="hidden" name="patient_id" value="{{ $patient_id }}">
                        <div class="form-group row">
                            <label class="control-label col-md-2 col-sm-2 ">Vaccine</label>
                            <div class="col-md-10 col-sm-10">
                                <select class="form-control col-md-6" name="vaccine_id">
                                    <option value=""disabled selected>--Chọn vaccine--</option>
                                    @foreach ($data['vaccines'] as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('vaccine_id') == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <div class="clearfix"></div>
                                @if ($errors->has('diseases_id'))
                                    <span class="text-danger" role="alert">{{ $errors->first('diseases_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2">Ngày dự kiến tiêm<span
                                    style="color: red">*</span></label>
                            <div class="col-md-10 col-sm-10">
                                <input type="date" class="form-control col-md-6" name="scheduled_date"
                                    placeholder="Chọn ngày dự kiến tiêm"
                                    value="{{ isset($editData) ? $editData->scheduled_date : old('scheduled_date') }}">
                                <div class="clearfix"></div>
                                @if ($errors->has('scheduled_date'))
                                    <span class="text-danger" role="alert">{{ $errors->first('scheduled_date') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2 ">Ghi chú</label>
                            <div class="col-md-10 col-sm-10">
                                <textarea class="resizable_textarea form-control col-md-6" style="height: 150px;" name="notes"
                                    placeholder="Nhập mô tả bệnh tại đây">{{ isset($editData) ? $editData->notes : '' }}</textarea>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 offset-md-3">
                                <button type="button" class="btn btn-primary" onclick="window.history.back()">Quay
                                    lại</button>
                                <button type="reset" class="btn btn-primary">Reset</button>
                                <button type="submit" class="btn btn-success">Lưu</button>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
