<?php

use Illuminate\Database\Seeder;

class WxUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $db_users = array(
            array('id' => '1','opendid' => 'o11975WldaBdbvrFIIK7rVRGxnfk','avatar' => 'https://wx.qlogo.cn/mmopen/vi_32/W3nuebmh2wJckVXSrCgBuC0B6xViao4ctgdqCsxiaAkrbUB4nIUKkSwC22o9jYQEh8f5nfNHSvDfribY2RRAZFWIA/132','nickname' => '果果','city' => 'Chengdu','province' => 'Sichuan','amount' => '85358.72','freeze' => '32816.56','status' => '0','gender' => '2','type' => '1','created' => '1543819281','updated' => '1547520816','session_key' => 'ySkwHWvOCuL+UAd/R72uRg==','deleted' => NULL),
            array('id' => '2','opendid' => 'o11975XREDXcSUQzHs_FuZBpOmtg','avatar' => 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKWB20xEr7Vs68vXXgCCPPdq71dwn90SeSHVtIQPqCNVZdbmicIF9mhQiaTHXuYqo3CWhJR8XPvzqXQ/132','nickname' => '冷空气*','city' => 'Guangyuan','province' => 'Sichuan','amount' => '22466.99','freeze' => '2060.01','status' => '0','gender' => '1','type' => '1','created' => '1543819332','updated' => '1547777754','session_key' => 'GHu+z+l2MTiRIwIfemZbWA==','deleted' => NULL),
            array('id' => '3','opendid' => 'o11975Tqf1J8033af2o-4FxW08SU','avatar' => 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLktKx4VicR2cMBbXRbZ2oS2PsrcFdOickEiaZJjI3lV8kHFMAA7Z8wicud5rJBoGibSqYNGHoSkMhFdRg/132','nickname' => '王烨','city' => 'Chengdu','province' => 'Sichuan','amount' => '19040.00','freeze' => '200.00','status' => '0','gender' => '1','type' => '1','created' => '1543820491','updated' => '1547536242','session_key' => '/FZPgfnIieSXYFQXvv4w1Q==','deleted' => NULL),
            array('id' => '4','opendid' => 'o11975ZUATdHNrPOKfriR7iChK0w','avatar' => 'https://wx.qlogo.cn/mmhead/IOoBQCibkoWbaVDWPqV78dDkxickianQse1VTiaicNewK59A/132','nickname' => '曾宁宜','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1545233111','updated' => '1547360863','session_key' => 'TZYBNHlAS2WBOFmCccRtow==','deleted' => NULL),
            array('id' => '5','opendid' => 'o11975d5vwiuM0UPA-RpOjI_6xYU','avatar' => 'https://wx.qlogo.cn/mmopen/vi_32/L9JiaUTBWYvWgWPe2gZfYd3PLoKB17e3ic8PuuCsaA1fyXfg0K8GrPBO0QDd21GIqgGOgSARwjdgsVgpBhQgMjlA/132','nickname' => 'Fiction','city' => 'Ziyang','province' => 'Sichuan','amount' => '197848.00','freeze' => '3000.00','status' => '0','gender' => '1','type' => '1','created' => '1545270185','updated' => '1547177007','session_key' => 'oxiVMog+YewCUPh0dsUSMA==','deleted' => NULL),
            array('id' => '6','opendid' => 'o11975a6N-tEu07KSR3OyFB4rW_U','avatar' => 'https://wx.qlogo.cn/mmopen/vi_32/ZoDMgCVk5IGQWRuFCbb5xVibtmGknSGgBd17f94SZPAyxEvB74PhpFE0EV7FM9rSUrzEupibhPhAnroYJrpRY1kA/132','nickname' => '工作号','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '1','type' => '1','created' => '1545271342','updated' => '1545636907','session_key' => 'bpuqIW3Hnq2cMaIYKbZVJA==','deleted' => NULL),
            array('id' => '7','opendid' => 'o11975SHZfDz9i8oDBPyHVhzMjh4','avatar' => 'https://wx.qlogo.cn/mmhead/2Y1MpTicN5NHicJIjfyXrfy7xJCOvSVCMQNNCQ3kJovxo/132','nickname' => '吴孟智','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1545306585','updated' => '1547442213','session_key' => 'Q13RDoKnDlRVdG3zxCzS5w==','deleted' => NULL),
            array('id' => '8','opendid' => 'o11975dIFtmTYfT70MVPkSnIaSvI','avatar' => 'https://wx.qlogo.cn/mmhead/XBu6rjtdhtCcrAPKNLfiaaVwMSaaOGDx8kzewniaicmVicM/132','nickname' => '胡勇妤','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1545306685','updated' => '1547187143','session_key' => 'Cu+rzHL9MAq0tCLtSeM72w==','deleted' => NULL),
            array('id' => '9','opendid' => 'o11975Rf1Zdu7M97sY4kdO0yKC8E','avatar' => 'https://wx.qlogo.cn/mmhead/M4SZTDGcjHgowEiawicmvA4sEQSkdaE1ibJ371gB5YGl1A/132','nickname' => '黎逸书','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1545307017','updated' => '1547700350','session_key' => 'fBwqLIiWeOWPOSmBaJ74IA==','deleted' => NULL),
            array('id' => '10','opendid' => 'o11975QOleAg7apBHW17tDaLblWM','avatar' => 'https://wx.qlogo.cn/mmhead/mibQlicQlBOl2ziaOAdLGiclUviaEdUF4hKMlOf3vlmWxZMo/132','nickname' => '梁安琪','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1545307281','updated' => '1546179479','session_key' => 'mrpr6w9mcan5IRVLPmA9Fw==','deleted' => NULL),
            array('id' => '11','opendid' => 'o11975V6xuNed3LftQN7QBgVG1jU','avatar' => 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83er07iaHv6icae0N7fvByKIVnL4GG36w5wz3iaI4ic9Qrgy2vZiaBn1o7icA6MJmh4XibOAq3VWDwVZZnMNibA/132','nickname' => '西北 偏北','city' => '','province' => 'Makkah','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '1','type' => '1','created' => '1545371044','updated' => '1546565579','session_key' => 'e5f3IToHpoXvYypcPReYCw==','deleted' => NULL),
            array('id' => '12','opendid' => 'o11975WAFtcVrL8TaPooMw3OU7VY','avatar' => 'https://wx.qlogo.cn/mmhead/x6H7A3cnDSrBcBkq1vbBXAkWSJpyJgwmONVUqiadkEjM/132','nickname' => '严芸豪','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1545375076','updated' => '1547306693','session_key' => 'G06vcaIFRjZHaJdanVvIfQ==','deleted' => NULL),
            array('id' => '13','opendid' => 'o11975dnoS2uWvpFIsuUSurdnk2I','avatar' => 'https://wx.qlogo.cn/mmhead/yDkEtL5iaD6yNPaWicdgOp7UEps6LPyhia6f7kjUHF0TLo/132','nickname' => '陈芳亦','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1545382038','updated' => '1546786882','session_key' => 'KqvoU4fQFP3Qz+uemgp9nQ==','deleted' => NULL),
            array('id' => '14','opendid' => 'o11975ZRG2agq4L49LvDhQn6KnM4','avatar' => 'https://wx.qlogo.cn/mmhead/0QH5mmWxSALaHFxWSqQPpqtgKXWzgUVmchicmFms2Gkg/132','nickname' => '洪倩珠','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1545382439','updated' => '1545911753','session_key' => 'viNQqyrg3o4M/gU+NcqX8g==','deleted' => NULL),
            array('id' => '15','opendid' => 'o11975YS-1S4kdvaBfzJOiiCUtcQ','avatar' => 'https://wx.qlogo.cn/mmhead/PkCSa92jJ4bn0HTL90kLNVqQ4wGPCicibPKJHsPd93pvg/132','nickname' => '刘家升','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1545382760','updated' => '1547131137','session_key' => 'yR9PCR8Yii6vaVs2D8vn5Q==','deleted' => NULL),
            array('id' => '16','opendid' => 'o11975RSD_pfp8N4wBepmsSgxiEE','avatar' => 'https://wx.qlogo.cn/mmhead/j9Jn1S2jLwGzYrwXmePONzYCKBMLg3wgKMeDID4tbww/132','nickname' => '陈莹美','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1545477571','updated' => '1547356752','session_key' => 'RZ3CPaYbzOi43Oxv+jAxDg==','deleted' => NULL),
            array('id' => '17','opendid' => 'o11975TohNIV4HjUDGznAIk4SS8Q','avatar' => 'https://wx.qlogo.cn/mmopen/vi_32/VvgTG6Tia0pWCArUPdkbgI7onlsRwCZjeUic1GyzfGlEEticFY7mHibQT9dibE39lxddamgAj8l43STg3P491SDMxwg/132','nickname' => '任德才','city' => 'Chengdu','province' => 'Sichuan','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '1','type' => '1','created' => '1545727805','updated' => '1546075576','session_key' => 'NncooUzR3Uyj1HBymgcG0g==','deleted' => NULL),
            array('id' => '18','opendid' => 'o11975ReggHs_k1bIrXUgbMRjh1U','avatar' => 'https://wx.qlogo.cn/mmopen/vi_32/icWtHpj8CI0jdmprMFB180ubjqTA9lZZYe2QaJVHH2UveWqmIkfib6Lz3TVGia2zmVFSdTgMZOS7k0mZgicibnQqypg/132','nickname' => '笙默xzh','city' => '','province' => '','amount' => '0.00','freeze' => '0.00','status' => '0','gender' => '0','type' => '1','created' => '1546570005','updated' => '1546589270','session_key' => 'suE8vrWxkxkmJ4U+4oN7RQ==','deleted' => NULL)
        );


        foreach ($db_users as $data ) {
            foreach (['deleted','updated','created'] as $key) {
                unset($data[$key]);
            }
            \App\Models\UserModel::create($data);
        }
    }
}
