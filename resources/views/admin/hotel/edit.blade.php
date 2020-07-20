@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto increadOn" style="cursor: move;">
        <h2>编辑酒店</h2>
        <a href="javascript:window.history.go(-1);">返回>></a>
    </div>

    @include('admin.hotel._form')

</div>
@endsection



@section('script')
    @include('admin.hotel._js_layui')
@endsection