@extends('Admin.layouts.master')

@section('title', 'Thêm mới thông tin bệnh')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Thêm mới thông tin bệnh nhân</h3>
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
                                <form class="form-horizontal form-label-left" action="{{ route('patientStore') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                        @endif
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2">Tên bệnh nhân<span
                                    style="color: red">*</span></label>
                            <div class="col-md-10 col-sm-10">
                                <input type="text" class="form-control col-md-6" name="name"
                                    placeholder="Nhập tên bệnh nhân"
                                    value="{{ isset($editData) ? $editData->name : old('name') }}">
                                <div class="clearfix"></div>
                                @if ($errors->has('name'))
                                    <span class="text-danger" role="alert">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2">Ngày tháng năm sinh<span
                                    style="color: red">*</span></label>
                            <div class="col-md-10 col-sm-10">
                                <input type="date" class="form-control col-md-6" name="dob"
                                    placeholder="Nhập ngày tháng năm sinh"
                                    value="{{ isset($editData) ? $editData->dob : old('dob') }}">
                                <div class="clearfix"></div>
                                @if ($errors->has('dob'))
                                    <span class="text-danger" role="alert">{{ $errors->first('dob') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2">Email</label>
                            <div class="col-md-10 col-sm-10">
                                <input type="text" class="form-control col-md-6" name="email"
                                    placeholder="Nhập email"
                                    value="{{ isset($editData) ? $editData->email : old('email') }}">
                            </div>

                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2">Số điện thoại<span
                                    style="color: red">*</span></label>
                            <div class="col-md-10 col-sm-10">
                                <input type="text" class="form-control col-md-6" name="phone"
                                    placeholder="Nhập số điện thoại"
                                    value="{{ isset($editData) ? $editData->phone : old('phone') }}">
                                    <div class="clearfix"></div>
                                @if ($errors->has('phone'))
                                    <span class="text-danger" role="alert">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2">Địa chỉ</label>
                            <div class="col-md-10 col-sm-10">
                                <input type="text" class="form-control col-md-6" name="address"
                                    placeholder="Nhập tên địa chỉ"
                                    value="{{ isset($editData) ? $editData->address : old('address') }}">
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
