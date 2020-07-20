@extends('admin.base')

@section('content')


<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto increadOn" style="cursor: move;">
        <h2>编辑景区</h2>
        <a href="javascript:window.history.go(-1);">返回>></a>
    </div>

    @include('admin.talentGroup._form')

</div>


@endsection


@section('script')
    @include('admin.talentGroup._js_layui')
@endsection
