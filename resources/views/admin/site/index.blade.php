@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>站点配置</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.site.update')}}" method="post">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">分享提成</label>
                    <div class="layui-input-block">
                        <input type="text" name="shared" value="{{ $config['shared']??'' }}" lay-verify="required|number" placeholder="设置分享百分比" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">系统分成</label>
                    <div class="layui-input-block">
                        <input type="text" name="system" value="{{ $config['system']??'' }}" lay-verify="required|number" placeholder="设置分成百分比" class="layui-input" >
                    </div>
                </div>
                <!--
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">达人提成</label>
                    <div class="layui-input-block">
                        <input type="text" name="talent" value="{{ $config['talent']??'' }}" lay-verify="required|number" placeholder="设置达人百分比" class="layui-input" >
                    </div>
                </div>
                -->
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">站点标题</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" value="{{ $config['title']??'' }}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">站点关键词</label>
                    <div class="layui-input-block">
                        <input type="text" name="keywords" value="{{ $config['keywords']??'' }}" lay-verify="required" placeholder="请输入关键词" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">站点描述</label>
                    <div class="layui-input-block">
                        <textarea class="layui-textarea" name="description" cols="30" rows="10">{{ $config['description']??'' }}</textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">CopyRight</label>
                    <div class="layui-input-block">
                        <input type="text" name="copyright" value="{{ $config['copyright']??'' }}" lay-verify="required" placeholder="请输入copyright" class="layui-input" >
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

