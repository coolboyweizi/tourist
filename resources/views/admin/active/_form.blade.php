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

        <input type="hidden" name="app" value="{{$app['type']}}" />
        <input type="hidden" name="price_id" value="{{ $price_id }}" />
        <div class="layui-form-item">
            <label class="layui-form-label">活动对象</label>
            <div class="layui-input-block">
                <input type="text" value="{{$app['appTitle']}}" disabled='disabled' class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">活动原价</label>
            <div class="layui-input-block">
                <input type="text" value="{{$app['old']}}" disabled='disabled' class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">活动价格</label>
            <div class="layui-input-block">
                <input type="text" name="price" lay-verify="title" autocomplete="off" value="{{$app['price']}}" placeholder="请输入价格" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">活动时间</label>
            <div class="layui-input-inline">
                <input type="text" name="active" class="layui-input"  id="range" placeholder="限制每月日期" style="width: 100%;margin-bottom: 5px;">
            </div>
            <div class="layui-form-mid layui-word-aux">请填写6到12位密码</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">日期范围</label>
            <div class="layui-input-inline">
                <input type="text" name="date" class="layui-input" value="0" placeholder="限制每周星期" style="width:100%;margin-bottom: 10px;">
            </div>
            <div class="layui-form-mid layui-word-aux">如: 1,3,4. 0则默认所有。</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">星期范围</label>
            <div class="layui-input-inline">
                <input type="text" name="week" class="layui-input" value="0" placeholder="限制每周星期" style="width:100%;margin-bottom: 10px;">
            </div>
            <div class="layui-form-mid layui-word-aux">如: 1,3,4. 0则默认所有。</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" title="可用" checked="">
                <input type="radio" name="status" value="0" title="停止">
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea" name="remark"></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="formDemo">立即提交</button>
            </div>
        </div>
    </form>
</div>
