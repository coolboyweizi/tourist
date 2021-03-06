@extends('admin.base')

@section('content')
    <div class="layui-row layui-col-space15">

        <div class="layui-col-sm6 layui-col-md3">

            <div class="layui-card">

                <div class="layui-card-header">

                    访问量

                    <span class="layui-badge layui-bg-blue layuiadmin-badge">周</span>

                </div>

                <div class="layui-card-body layuiadmin-card-list">

                    <p class="layuiadmin-big-font">{{ $weekPv }}</p>

                    <p>

                        总计访问量

                        <span class="layuiadmin-span-color">{{ $totalPv }} <i class="layui-inline layui-icon layui-icon-flag"></i></span>

                    </p>

                </div>

            </div>

        </div>

        <div class="layui-col-sm6 layui-col-md3">

            <div class="layui-card">

                <div class="layui-card-header">

                    新用户

                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span>

                </div>

                <div class="layui-card-body layuiadmin-card-list">

                    <p class="layuiadmin-big-font">{{ $user->monthReg()->count() }}</p>

                    <p>

                        新下载

                        <span class="layuiadmin-span-color">10% <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>

                    </p>

                </div>

            </div>

        </div>

        <div class="layui-col-sm6 layui-col-md3">

            <div class="layui-card">

                <div class="layui-card-header">

                    收入

                    <span class="layui-badge layui-bg-green layuiadmin-badge">月</span>

                </div>

                <div class="layui-card-body layuiadmin-card-list">



                    <p class="layuiadmin-big-font">{{ $profit->system()->sum('money') }}</p>

                    <p>

                        总收入

                        <span class="layuiadmin-span-color">{{ $profit->system()->sum('money') }} <i class="layui-inline layui-icon layui-icon-dollar"></i></span>

                    </p>

                </div>

            </div>

        </div>

        <div class="layui-col-sm6 layui-col-md3">

            <div class="layui-card">

                <div class="layui-card-header">

                    活跃用户

                    <span class="layui-badge layui-bg-orange layuiadmin-badge">月</span>

                </div>

                <div class="layui-card-body layuiadmin-card-list">



                    <p class="layuiadmin-big-font">{{ $user->live()->count() }}</p>

                    <p>

                        最近一个月

                        <span class="layuiadmin-span-color">15% <i class="layui-inline layui-icon layui-icon-user"></i></span>

                    </p>

                </div>

            </div>

        </div>

        <div class="layui-col-sm12">

            <div class="layui-card">

                <div class="layui-card-header">

                    访问量

                    <div class="layui-btn-group layuiadmin-btn-group">

                        <a href="javascript:;" class="layui-btn layui-btn-primary layui-btn-xs">去年</a>

                        <a href="javascript:;" class="layui-btn layui-btn-primary layui-btn-xs">今年</a>

                    </div>

                </div>

                <div class="layui-card-body">

                    <div class="layui-row">

                        <div class="layui-col-sm8">

                            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-pagetwo">

                                <div carousel-item id="LAY-index-pagetwo">

                                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>

                                </div>

                            </div>

                        </div>

                        <div class="layui-col-sm4">

                            <div class="layuiadmin-card-list">

                                <p class="layuiadmin-normal-font">月访问数</p>

                                <span>同上期增长</span>

                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">

                                    <div class="layui-progress-bar" lay-percent="30%"></div>

                                </div>

                            </div>

                            <div class="layuiadmin-card-list">

                                <p class="layuiadmin-normal-font">月下载数</p>

                                <span>同上期增长</span>

                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">

                                    <div class="layui-progress-bar" lay-percent="20%"></div>

                                </div>

                            </div>

                            <div class="layuiadmin-card-list">

                                <p class="layuiadmin-normal-font">月收入</p>

                                <span>同上期增长</span>

                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">

                                    <div class="layui-progress-bar" lay-percent="25%"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="layui-col-sm4">
            <!--
            <div class="layui-card">

                <div class="layui-card-header">用户留言</div>

                <div class="layui-card-body">

                    <ul class="layuiadmin-card-status layuiadmin-home2-usernote">

                        <li>

                            <h3>贤心</h3>

                            <p>作为 layui 官方推出的后台模板，从初版的饱受争议，到后续的埋头丰富，逐步占据了国内后台系统应用的主要市场。</p>

                            <span>5月30日 00:00</span>

                            <a href="javascript:;" layadmin-event="replyNote" data-id="7" class="layui-btn layui-btn-xs layuiadmin-reply">回复</a>

                        </li>

                        <li>

                            <h3>诸葛亮</h3>

                            <p>皓首匹夫！苍髯老贼！你枉活九十有六，一生未立寸功，只会摇唇鼓舌！助曹为虐！一条断脊之犬，还敢在我军阵前狺狺狂吠，我从未见过有如此厚颜无耻之人！</p>

                            <span>5月02日 00:00</span>

                            <a href="javascript:;" layadmin-event="replyNote" data-id="5" class="layui-btn layui-btn-xs layuiadmin-reply">回复</a>

                        </li>

                        <li>

                            <h3>胡歌</h3>

                            <p>你以为只要长得漂亮就有男生喜欢？你以为只要有了钱漂亮妹子就自己贴上来了？你以为学霸就能找到好工作？我告诉你吧，这些都是真的！</p>

                            <span>5月11日 00:00</span>

                            <a href="javascript:;" layadmin-event="replyNote" data-id="6" class="layui-btn layui-btn-xs layuiadmin-reply">回复</a>

                        </li>

                        <li>

                            <h3>杜甫</h3>

                            <p>人才虽高，不务学问，不能致圣。刘向十日画一水，五日画一石。</p>

                            <span>4月11日 00:00</span>

                            <a href="javascript:;" layadmin-event="replyNote" data-id="2" class="layui-btn layui-btn-xs layuiadmin-reply">回复</a>

                        </li>

                        <li>

                            <h3>鲁迅</h3>

                            <p>路本是无所谓有和无的，走的人多了，就没路了。。</p>

                            <span>4月28日 00:00</span>

                            <a href="javascript:;" layadmin-event="replyNote" data-id="4" class="layui-btn layui-btn-xs layuiadmin-reply">回复</a>

                        </li>

                        <li>

                            <h3>张爱玲</h3>

                            <p>于千万人之中遇到你所要遇到的人，于千万年之中，时间的无涯的荒野中，没有早一步，也没有晚一步，刚巧赶上了，那也没有别的话好说，唯有轻轻的问一声：“噢，原来你也在这里？”</p>

                            <span>4月11日 00:00</span>

                            <a href="javascript:;" layadmin-event="replyNote" data-id="1" class="layui-btn layui-btn-xs layuiadmin-reply">回复</a>

                        </li>

                    </ul>

                </div>

               </div>
                -->
            <div class="layui-card">

                <div class="layui-card-header">本周活跃用户排名</div>

                <div class="layui-card-body">

                    <table class="layui-table layuiadmin-page-table" lay-skin="line">

                        <thead>

                        <tr>

                            <th>用户名</th>

                            <th>最后登录时间</th>

                            <th>状态</th>

                            <th>活跃度</th>

                        </tr>

                        </thead>

                        <tbody>
                        @if( $user->live()->count())
                            @foreach ($user->live() as $user)
                                <tr>

                                    <td><span class="first">{{ $user->nickname }}</span></td>

                                    <td><i class="layui-icon layui-icon-log"> {{ \Carbon\Carbon::createFromTimestamp($user->updated)->format('Y-m-d H:i:s') }}</i></td>

                                    <td><span>
                                                    @if(\Carbon\Carbon::now()->timestamp - $user->updated < 600)
                                                在线
                                            @else
                                                离线
                                            @endif
                                                </span>
                                    </td>

                                    <td>{{ $user->loginTimes }} <i class="layui-icon layui-icon-praise"></i></td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">
                                    <div class="layui-none">无数据</div>
                                </td>
                            </tr>
                        @endif


                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="layui-col-sm8">

            <div class="layui-row layui-col-space15">

                <div class="layui-col-sm6">

                    <div class="layui-card">

                        <div class="layui-card-header">本周分享排名</div>

                        <div class="layui-card-body">

                            <table class="layui-table layuiadmin-page-table" lay-skin="line">

                                <thead>

                                <tr>

                                    <th>用户名</th>

                                    <th>收益</th>

                                    <th>账户金额</th>

                                    <th>最近登录时间</th>

                                </tr>

                                </thead>

                                <div class="layui-table-body layui-table-main">
                                    <tbody>
                                    @if( $profit->shared()->count())
                                        @foreach ($profit->shared() as $user)
                                            <tr>
                                                <td><span class="first">{{ $user['name'] }}</span></td>
                                                <td><i class="layui-icon layui-icon-rmb"> {{ $user['profit'] }} </i></td>
                                                <td>{{ $user['amount'] }}</td>
                                                <td>{{ $user['updated'] }} </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                               <td colspan="4">
                                                   <div class="layui-none">无数据</div>
                                               </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </div>

                            </table>

                        </div>

                    </div>

                </div>

                <div class="layui-col-sm6">

                    <div class="layui-card">

                        <div class="layui-card-header">本周商家收益</div>

                        <div class="layui-card-body">


                                <div class="layui-tab-item layui-show">

                                    <table class="layui-table layuiadmin-page-table" lay-skin="line">

                                        <thead>

                                        <tr>

                                            <th>用户名</th>

                                            <th>收益</th>

                                            <th>账户金额</th>

                                            <th>最近登录时间</th>

                                        </tr>

                                        </thead>

                                        <tbody>
                                        @if($profit->merchant()->count())
                                            @foreach ($profit->merchant() as $user)
                                                <tr>

                                                    <td><span class="first">{{ $user['name'] }}</span></td>

                                                    <td><i class="layui-icon layui-icon-rmb "> {{ $user['profit'] }} </i></td>

                                                    <td>{{ $user['amount'] }}
                                                    </td>

                                                    <td>{{ $user['updated'] }} </td>

                                                </tr>

                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">
                                                    <div class="layui-none">无数据</div>
                                                </td>
                                            </tr>
                                        @endif

                                        </tbody>

                                    </table>

                                </div>

                        </div>

                    </div>

                </div>

                <!--<div class="layui-col-sm12">

                    <div class="layui-card">

                        <div class="layui-card-header">用户全国分布</div>

                        <div class="layui-card-body">

                            <div class="layui-row layui-col-space15">

                                <div class="layui-col-sm4">

                                    <table class="layui-table layuiadmin-page-table" lay-skin="line">

                                        <thead>

                                        <tr>

                                            <th>排名</th>

                                            <th>地区</th>

                                            <th>人数</th>

                                        </tr>

                                        </thead>

                                        <tbody>

                                        <tr>

                                            <td>1</td>

                                            <td>浙江</td>

                                            <td>62310</td>

                                        </tr>

                                        <tr>

                                            <td>2</td>

                                            <td>上海</td>

                                            <td>59190</td>

                                        </tr>

                                        <tr>

                                            <td>3</td>

                                            <td>广东</td>

                                            <td>55891</td>

                                        </tr>

                                        <tr>

                                            <td>4</td>

                                            <td>北京</td>

                                            <td>51919</td>

                                        </tr>

                                        <tr>

                                            <td>5</td>

                                            <td>山东</td>

                                            <td>39231</td>

                                        </tr>

                                        <tr>

                                            <td>6</td>

                                            <td>湖北</td>

                                            <td>37109</td>

                                        </tr>

                                        </tbody>

                                    </table>

                                </div>

                                <div class="layui-col-sm8">



                                    <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-pagethree">

                                        <div carousel-item id="LAY-index-pagethree">

                                            <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>

                                        </div>

                                    </div>



                                </div>

                            </div>

                        </div>

                    </div>

                </div>-->

            </div>

        </div>

    </div>
@endsection

@section('script')
    <script>
        layui.use(['index', 'sample']);
    </script>
@endsection