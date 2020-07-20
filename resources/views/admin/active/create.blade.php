@extends('admin.base')

@section('content')

<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto increadOn" style="cursor: move;">
        <h2>添加活动</h2>
    </div>

    @include('admin.active._form')

</div>

@endsection

@section('script')
    @include('admin.active._js_layui')
@endsection