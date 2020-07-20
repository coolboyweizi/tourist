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
            <label class="layui-form-label">票价标题：</label>
            <div class="layui-input-block">
                <input type="text" name="title" required lay-verify="required"   class="layui-input" autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">票价：</label>
            <div class="layui-input-block">
                <input type="text" name="price" required lay-verify="required" placeholder="请填写票价"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">单位：</label>
            <div class="layui-input-block">
                <input type="text" name="unit" required lay-verify="required" placeholder="请填写单位"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">票价类型：</label>
            <div class="layui-input-block">
                <input type="text" name="type" required lay-verify="required" placeholder="请填写票价类型"  class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">温馨提示：</label>
            <div class="layui-input-block">
                <textarea name="tips"  ></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">有效时间：</label>
            <div class="layui-input-block">
                <input type="text" name="stime" id="test1" required lay-verify="required" placeholder="请填写有效时间"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">失效时间：</label>
            <div class="layui-input-block">
                <input type="text" name="etime" id="test2" required lay-verify="required" placeholder="请填写有效时间"  class="layui-input">
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
