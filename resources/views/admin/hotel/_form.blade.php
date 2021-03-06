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
            <label class="layui-form-label">酒店标题：</label>
            <div class="layui-input-block">
                <input type="text" name="title" required lay-verify="required"   class="layui-input" autocomplete="off">
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
            <label class="layui-form-label">轮播图：</label>
            <div class="layui-upload uploadImg ">
                <button type="button" class="layui-btn" id="thumbs">多图片上传</button>
                <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px; min-height:170px; width:70%">
                    预览图：
                    <div class=" uplods2" id="thumbsImg">
                        <ul class="clearfix"></ul>
                    </div>
                </blockquote>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">酒店说明：</label>
            <div class="layui-input-block">
                <textarea name="illustrate" ></textarea>
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">酒店地址：</label>
            <div class="layui-input-block">
                <input type="text" name="address" required lay-verify="required" placeholder="请填写酒店地址"  class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">注意事项：</label>
            <div class="layui-input-block">
                <textarea name="notice"  ></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">订购数量：</label>
            <div class="layui-input-block">
                <input type="number" name="ordered" required lay-verify="required|number" class="demo-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态：</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" title="可用" checked>
                <input type="radio" name="status" value="0" title="不可用" >
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">图文说明：</label>
            <div class="layui-input-block">
                <textarea name="detail" id="detail"></textarea>
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
