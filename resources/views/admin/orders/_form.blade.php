<style>
    #edui1{
        width:70%!important;
    }
</style>
<div class="layui-card-body">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">项目标题：</label>
            <div class="layui-input-block">
                <input type="text" name="title" required lay-verify2="required"   class="layui-input" autocomplete="off">
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
                <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px; min-height:150px; width:70%">
                    预览图：
                    <div class="layui-upload-list uplods2" id="thumbsImg">
                        <ul></ul>
                    </div>
                </blockquote>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图文介绍：</label>
            <div class="layui-upload uploadImg ">
                <button type="button" class="layui-btn" id="details">上传图片</button>
                <div class="layui-upload-list uplods3">
                    <img class="demo_imgs" id="detailsImg">
                    <p id="demoText"></p>
                    <input type="hidden" name="detail" value="">
                </div>

            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">景区地址：</label>
            <div class="layui-input-block">
                <input type="text" name="address" required lay-verify2="required" placeholder="请填写景区地址"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开放时间：</label>
            <div class="layui-input-block">
                <input type="text" name="opentime" class="layui-input" >
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
                <input type="num" name="ordered" required lay-verify2="required" class="demo-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态：</label>
            <div class="layui-input-block demo-block">
                <input type="text" name="status" required lay-verify2="required" class="demo-input" r>
            </div>
        </div>

        @include('UEditor::head')

        <div class="layui-form-item">
            <label class="layui-form-label">项目说明：</label>
            <div class="layui-input-block">
                <script id="container" name="illustrate" type="text/plain">

                </script>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标签：</label>
            <div class="layui-input-block">
                <input type="text" name="tagsA" required lay-verify2="required" class="demo-input biaoqian">
                <input type="text" name="tagsB" required lay-verify2="required" class="demo-input biaoqian">
                <input type="text" name="tagsC" required lay-verify2="required" class="demo-input biaoqian">
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
