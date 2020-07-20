{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">昵称</label>
    <div class="layui-input-inline">
        <input type="text" disabled="true" name="nickname" value="{{ $member->nickname ?? old('nickname') }}" placeholder="请输入昵称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">账户余额</label>
    <div class="layui-input-inline">
        <input type="text" name="amount" value="{{ $member->amount ?? old('amount') }}" lay-verify="required" placeholder="账户余额" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">冻结金额</label>
    <div class="layui-input-inline">
        <input type="text" name="freeze" value="{{ $member->freeze ?? old('freeze') }}" lay-verify="required" placeholder="冻结资金" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">达人等级</label>
    <div class="layui-input-block">
        <select name="talent_group" lay-filter="aihao">
            <option value="0" selected="" >普通用户</option>
            @foreach($talentGroup as $group)
            <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.member')}}" >返 回</a>
    </div>
</div>