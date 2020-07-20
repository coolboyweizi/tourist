<style>
    #edui1{
        width:70%!important;
    }
    .demo-block > .layui-unselect{
        width:70%;
        z-index:1111;
    }
    .demo-block .layui-input,.layui-form-select .layui-input{
        width:100%!important;
    }
    .layui-form-select{
        width:70%;
    }
</style>
<div class="layui-card-body">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <input type="hidden" name="app_id" value="{{$app_id}}"/>
            <label class="layui-form-label">标题：</label>
            <div class="layui-input-block">
                <input type="text" name="title" required lay-verify="required|chinese"   class="layui-input" autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">房间类型：</label>
            <div class="layui-input-block">
                <input type="text" name="type" required lay-verify="required|chinese"   class="layui-input" autocomplete="off">
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
                <input type="hidden" name="thumbs" value="" >
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">酒店价格：</label>
            <div class="layui-input-block">
                <input type="text" name="price" required lay-verify="required" placeholder="请填写酒店价格"  class="layui-input">
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
            <label class="layui-form-label">标签：</label>
            <div class="layui-input-block">
                <input type="text" name="tags" required lay-verify="required" class="demo-input biaoqian">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">等级：</label>
            <div class="layui-input-block">
                <select name="priority">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                </select>
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
