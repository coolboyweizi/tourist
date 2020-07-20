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
            <label for="" class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="" lay-verify="required" placeholder="请输入名称" class="layui-input" >
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">分享比例</label>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="text" name="scale" placeholder="￥" autocomplete="off" class="layui-input">
                </div>

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
