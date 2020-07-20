<style>
    #edui1{
        width:70%!important;
    }
    .demo-block > .layui-unselect{
        width:70%;
        z-index:1111;
    }
    .demo-block .layui-input{
        width:100%!important;
    }
</style>
<div class="layui-card-body">
    <form class="layui-form" action="">
        <div class="layui-form-item">

            <label class="layui-form-label">项目标题：</label>
            <div class="layui-input-block">
                <input type="text" name="title" required lay-verify="required"  readonly="readonly" class="layui-input" autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上传图片：</label>
            <div class="layui-upload uploadImg ">
                <button type="button" class="layui-btn" id="logo">上传图片</button>
                <div class="layui-upload-list uplods1">
                    <img class="layui-upload-img" id="logoImg" >
                    <p id="demoText"></p>
                </div>
                <input type="hidden" name="logo" value="" >
            </div>

        </div>
        
        <div class="layui-form-item">
            <label class="layui-form-label">产品code：</label>
            <div class="layui-input-block">
                <input type="text" name="pcode" required lay-verify="required" readonly="readonly"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">产品类别：</label>
            <div class="layui-input-block">
                <input type="text" name="ptype" required lay-verify="required" readonly="readonly" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">目的地：</label>
            <div class="layui-input-block">
                <input type="text" name="destination" readonly="readonly" required lay-verify="required"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">项目描述：</label>
            <div class="layui-input-block">
                <textarea name="detail"  ></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">评论数量：</label>
            <div class="layui-input-block">
                <input type="text" name="comment" required lay-verify="required" class="demo-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">订购数量：</label>
            <div class="layui-input-block">
                <input type="text" name="ordered" required lay-verify="required" class="demo-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态：</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" title="可用" checked lay-filter="1">
                <input type="radio" name="status" value="0" title="不可用" lay-filter="0">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标签：</label>
            <div class="layui-input-block">
                <input type="text" name="tagsA" required lay-verify="required" class="demo-input biaoqian">
                <input type="text" name="tagsB" required lay-verify="required" class="demo-input biaoqian">
                <input type="text" name="tagsC" required lay-verify="required" class="demo-input biaoqian">
            </div>
        </div>


        <div class="layui-form-item">
            <label for="" class="layui-form-label">标签</label>
            <div class="layui-input-block">
                @foreach($tags as $tag)
                    <input type="checkbox" name="tags[]" {{ $tag->checked??'' }} value="{{ $tag->id }}" title="{{ $tag->name }}">
                @endforeach
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
