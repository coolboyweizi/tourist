<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MemberCreateRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Models\TalentGroupModel;
use App\Models\TalentUserModel;
use App\Models\UserModel as Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.member.index');
    }

    public function data(Request $request)
    {
        $result = app('user.abstract')->findAll(
            [],
            $request->input('limit')
        );
        return [
            'code' =>0,
            'data' => $result['data'],
            'count' => $result['total'],
        ];
        /*$model = Member::query();
        if ($request->get('name')){
            $model = $model->where('nickname','like','%'.$request->get('name').'%');
        }
        /*if ($request->get('phone')){
            $model = $model->where('phone','like','%'.$request->get('phone').'%');
        }*/

       /* $res = $model->orderBy('created','desc')->paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);*/
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.member.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberCreateRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $data['uuid'] = \Faker\Provider\Uuid::uuid();
        if (Member::create($data)){
            return redirect()->to(route('admin.member'))->with(['status'=>'添加账号成功']);
        }
        return redirect()->to(route('admin.member'))->withErrors('系统错误');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 用户
        $member = Member::findOrFail($id);

        // 达人组合
        $talentGroup = TalentGroupModel::all();
        return view('admin.member.edit',compact('member','talentGroup'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberUpdateRequest $request, $id)
    {
        $member = Member::findOrFail($id);
        $data = $request->except('password');
        if ($request->get('password')){
            $data['password'] = bcrypt($request->get('password'));
        }

        // 添加达人用户等级
        if ($request->input('talent_group',0) > 0){
            $talent = TalentUserModel::updateOrCreate([
                'uid' => $member->id,
            ],[
                'gid' => $request->input('talent_group')
            ]);
            $data = array_merge($data,[
                'talent' => $talent->id
            ]);
        }

        if ($member->update($data)){

            return redirect()->to(route('admin.member'))->with(['status'=>'更新用户成功']);
        }
        return redirect()->to(route('admin.member'))->withErrors('系统错误');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (Member::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
}
