@extends('Admin.layouts.master')

@section('title', 'Thêm mới thông tin bệnh')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Form Elements</h3>
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
                        <h2>Form Basic Elements <small>different form elements</small></h2>
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
                            <form action="{{ route('diseaseUpdate', @$editData->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            @else
                                <form class="form-horizontal form-label-left" action="{{ route('diseaseStore') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                        @endif
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2">Tên Loại bệnh<span
                                    style="color: red">*</span></label>
                            <div class="col-md-10 col-sm-10">
                                <input type="text" class="form-control col-md-6" name="name"
                                    placeholder="Nhập tên loại bệnh"
                                    value="{{ isset($editData) ? $editData->name : old('name') }}">
                                <div class="clearfix"></div>
                                @if ($errors->has('name'))
                                    <span class="text-danger" role="alert">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-2 col-sm-2 ">Nhập mô tả bệnh</label>
                            <div class="col-md-10 col-sm-10">
                                <textarea class="resizable_textarea form-control col-md-6" style="height: 150px;" name="description"
                                    placeholder="Nhập mô tả bệnh tại đây">{{ isset($editData) ? $editData->description : '' }}</textarea>
                            </div>
                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 offset-md-3">
                                <button type="button" class="btn btn-primary"
                                    onclick="window.history.back()">Quay lại</button>
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
