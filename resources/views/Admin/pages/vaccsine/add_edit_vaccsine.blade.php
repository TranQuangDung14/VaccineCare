@extends('Admin.layouts.master')

@section('title', 'Thêm mới thông Vaccsine')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                @if (isset($data['vaccsine']))
                    <h3>Cập nhật lại thông tin Vaccsine</h3>
                @else
                    <h3>Thêm mới Vaccsine</h3>
                @endif
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
            <div class="col-md-12 ">
                <div class="x_panel">
                    <div class="x_title">

                        @if (isset($data['vaccsine']))
                            <h2>Cập nhật lại thông tin Vaccsine</h2>
                        @else
                            <h2>THÊM MỚI</h2>
                        @endif
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
                        @if (isset($data['vaccsine']))
                            <form action="{{ route('vaccsineUpdate', @$data['vaccsine']->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            @else
                                <form class="form-horizontal form-label-left" action="{{ route('vaccsineStore') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                        @endif
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2">Tên vaccsine<span
                                    style="color: red">*</span></label>
                            <div class="col-md-10 col-sm-10">
                                <input type="text" class="form-control col-md-6" name="name"
                                    placeholder="Nhập tên vaccsine"
                                    value="{{ isset($data['vaccsine']) ? $data['vaccsine']->name : old('name') }}">
                                <div class="clearfix"></div>
                                @if ($errors->has('name'))
                                    <span class="text-danger" role="alert">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-2 col-sm-2 ">Phòng bệnh</label>
                            <div class="col-md-10 col-sm-10">
                                <select class="form-control col-md-6" name="diseases_id">
                                    <option value=""disabled selected>--Chọn phòng bệnh--</option>
                                    @foreach ($data['diseases'] as $value)
                                        <option value="{{ $value->id }}"
                                            {{ isset($data['vaccsine']) ? ($data['vaccsine']->diseases_id == $value->id ? 'selected' : '') : (old('diseases_id') == $value->id ? 'selected' : '') }}>
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
                            <label class="control-label col-md-2 col-sm-2">Số mũi cần tiêm<span
                                    style="color: red">*</span></label>
                            <div class="col-md-10 col-sm-10">
                                <input type="number" class="form-control col-md-6" name="doses_required"
                                    placeholder="Nhập Số mũi cần tiêm"
                                    value="{{ isset($data['vaccsine']) ? $data['vaccsine']->doses_required : old('doses_required') }}">
                                <div class="clearfix"></div>
                                @if ($errors->has('doses_required'))
                                    <span class="text-danger" role="alert">{{ $errors->first('doses_required') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2">Chu kì thời gian giữa mỗi mũi tiêm (ngày)<span
                                    style="color: red">*</span></label>
                            <div class="col-md-10 col-sm-10">
                                <input type="number" class="form-control col-md-6" name="dose_intervals"
                                    placeholder="Nhập Chu kì thời gian giữa mỗi mũi tiêm"
                                    value="{{ isset($data['vaccsine']) ? $data['vaccsine']->dose_intervals : old('dose_intervals') }}">
                                <div class="clearfix"></div>
                                @if ($errors->has('dose_intervals'))
                                    <span class="text-danger" role="alert">{{ $errors->first('dose_intervals') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2 ">Nhập ghi chú</label>
                            <div class="col-md-10 col-sm-10">
                                <textarea class="resizable_textarea form-control col-md-6" style="height: 150px;" name="description"
                                    placeholder="Nhập ghi chú">{{ isset($data['vaccsine']) ? $data['vaccsine']->description : '' }}</textarea>
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
