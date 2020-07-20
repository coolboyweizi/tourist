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
            <label class="layui-form-label">项目ID：</label>
            <div class="layui-input-block">
                <input type="text" name="app_id" required lay-verify="required" readonly="readonly"  class="layui-input" autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">产品code：</label>
            <div class="layui-input-block">
                <input type="text" name="pcode" required lay-verify="required" readonly="readonly"  class="layui-input" autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">票价名称：</label>
            <div class="layui-input-block">
                <input type="text" name="title" required lay-verify="required" readonly="readonly"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">售价：</label>
            <div class="layui-input-block">
                <input type="text" name="price" required lay-verify="required" readonly="readonly"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">票价类型：</label>
            <div class="layui-input-block">
                <input type="text" name="type" required lay-verify="required" readonly="readonly"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">单位：</label>
            <div class="layui-input-block">
                <input type="text" name="unit" required lay-verify="required"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">出发日期：</label>
            <div class="layui-input-block">
                <input type="text" name="godate" required lay-verify="required" readonly="readonly" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">时刻表：</label>
            <div class="layui-input-block">
                <input type="text" name="schedule" required lay-verify="required" readonly="readonly"  class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">座位总数：</label>
            <div class="layui-input-block">
                <input type="text" name="seats"  required lay-verify="required" readonly="readonly" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">已售座位数：</label>
            <div class="layui-input-block">
                <input type="text" name="occupiedseats"  required lay-verify="required" readonly="readonly" class="layui-input">
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
            <label class="layui-form-label">优先级：</label>
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
