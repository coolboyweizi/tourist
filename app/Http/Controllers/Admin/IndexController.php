<?php

namespace App\Http\Controllers\Admin;

use App\Statistics\OrderStatistics;
use App\Statistics\ProfitCalc;
use App\Statistics\ProfitStatistics;
use App\Statistics\PvCalc;
use App\Statistics\PvStatistics;
use App\Statistics\UserCalc;
use App\Statistics\UserLogic;
use App\Models\CommentModel;
use App\Models\Icon;
use App\Models\Permission;
use App\Models\Role;
use App\Statistics\WithDrawStatistics;
use App\Tools\StatisticsDate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * 后台布局
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function layout()
    {
        return view('admin.layout');
    }

    /**
     * 后台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // 待审评论
        $commentNum = CommentModel::where('status',0)->count();

        // 定义时间对象
        $date = StatisticsDate::make(Carbon::now()->startOfMonth(), Carbon::now());

        // 用户信息
        $user = new UserCalc($date);

        // 提现
        $withdraw = new WithDrawStatistics(
            StatisticsDate::make(Carbon::createFromTimestamp(0), Carbon::now())
        );

        // 流量
        $obj =  new PvStatistics($date);
        $flux = $obj->day(Carbon::now()->format('y-m-d'));

        // 今日订单
        $order = new OrderStatistics(
            StatisticsDate::make(Carbon::now()->startOfDay(), Carbon::now())
        );

        return view('admin.index.index',compact('flux','commentNum','user','withdraw','order'));
    }
    public function index1()
    {
        return view('admin.index.index1');
    }
    public function index2()
    {
        // 每周访问量
        $weekPv = DB::table('daily_pv')->where('created','>',Carbon::now()->startOfWeek()->timestamp)->sum('times');
        // 每月访问量
        $monPv = DB::table('daily_pv')->where('created','>',Carbon::now()->firstOfMonth()->timestamp)->sum('times');
        // 总访问量
        $totalPv = DB::table('daily_pv')->sum('times');


        // 创建一个时间范围
        $staticsDate = StatisticsDate::make(
            Carbon::now()->startOfYear(),
            Carbon::now()
        );

        // pv
        $pvCalc = new PvStatistics($staticsDate);

        // 用户
        $user = new UserCalc($staticsDate);

        // 收益统计
        $profit = new ProfitStatistics($staticsDate);
        $profit->shared();
        return view('admin.index.index2',
            compact('weekPv','monPv','totalPv',
                    'monMerchant','monShared','monTalent','monSystem',
                    'allSystem','allShared','allTalent','allSystem',

                    'user','profit'
            )
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 数据表格接口
     */
    public function data(Request $request)
    {
        $model = $request->get('model');
        switch (strtolower($model)) {
            case 'user':
                $query = new User();
                break;
            case 'role':
                $query = new Role();
                break;
            case 'permission':
                $query = new Permission();
                $query = $query->where('parent_id', $request->get('parent_id', 0))->with('icon');
                break;
            default:
                $query = new User();
                break;
        }
        $res = $query->paginate($request->get('limit', 30))->toArray();
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 所有icon图标
     */
    public function icons()
    {
        $icons = Icon::orderBy('sort', 'desc')->get();
        return response()->json(['code' => 0, 'msg' => '请求成功', 'data' => $icons]);
    }

}
