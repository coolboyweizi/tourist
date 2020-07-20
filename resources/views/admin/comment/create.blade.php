@extends('admin.base')

@section('content')

<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto increadOn" style="cursor: move;">
        <h2>添加景区</h2>
        <a href="javascrip:;" onclick="window.history.go(-1)">返回>></a>
    </div>

    @include('admin.comment._form')

</div>

@endsection

@section('script')
    @include('admin.comment._js_layui')
@endsection
