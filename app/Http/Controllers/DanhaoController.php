<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Excel;

class DanhaoController extends Controller
{
    //
    public function index(Request $request){
        $i = function ($d){
            return $d != null || intval($d)> 0?$d:'0';
        };

        if ($request->isMethod('post')) {

            $name =  md5(time() . rand(0, 10000)) . '.' ;
            if ($request->hasFile('ckdh') && $request->hasFile('kddh')) {
                $table = array();
                $count = array();
                $newFileName = $name . $request->ckdh->getClientOriginalExtension();
                $ckdh = $request->ckdh->move('xls', $newFileName);
                $date = Excel::load($ckdh)->get()->toArray();
                $count['ck'] = count($date);
//                dd(Excel::load($ckdh,function($reader){ dd($reader->all());}));
                $ckdh = null;
                $body = null;
                foreach ($date as $val) {

                    foreach ($val as $vala) {
                        $body[] = $vala;
                    }
                    if(count($body) != 3){
                        continue;
                    }

                    $key = $body[0];
                    if(intval($body[1]) > 100){ $body[1] = round(floatval(intval($body[1]) / 1000),2); }
                    $table[$key]['ck'] = array('kg' => $body[1], 'fy' => $body[2]);
                    $table[$key]['kd'] = array('kg' => 0,'fy' =>0);
                    $body = null;
                }
                $body = null;
                $newFileName = $name . $request->kddh->getClientOriginalExtension();
                $kddh = $request->kddh->move('xls' ,$newFileName );
                $date =  Excel::load($kddh)->get()->toArray();
                $count['kd'] = count($date);
                foreach($date as  $val){
                    foreach($val as  $vala ){
                        $body[] = $vala;
                    }
                    if(count($body) != 3){
                        continue;
                    }
                    $key = $body[0];
                    if(intval($body[1]) > 100){ $body[1] = round(floatval(intval($body[1]) / 1000),2); }
                    $table[$key]['kd'] = array('kg' => ($body[1]),'fy'=> ($body[2]));
                    if(empty($table[$key]['ck'])){ $table[$key]['ck'] = array('kg' => 0, 'fy' => 0); }
                    $body = null;
                }
                $xls = array();
                $mw = array('ck' => 0,'kd' => 0);
                foreach($table as $Key => $val){
                    $val['ck']['fy'] = floatval($val['ck']['fy']);
                    $val['kd']['fy'] = floatval($val['kd']['fy']);
                    $mw['ck'] += intval($val['ck']['fy']);
                    $mw['kd'] += intval($val['kd']['fy']);

                    $m = intval($val['ck']['fy']) > 0 ?round(floatval($val['ck']['fy'] - $val['kd']['fy']),2):'0';
                    $xls[] = array($Key,$i($val['kd']['kg']),$i($val['ck']['kg']),$i($val['kd']['fy']),$i($val['ck']['fy']),$m);
                }


                Excel::create('新的数据表', function($excel) use($xls ,$count ,$mw) {
                    $excel->sheet('Sheetname', function($sheet) use($xls ,$count ,$mw) {


                        $sheet->fromArray($xls);
                        $sheet->row(1, array(
                            '单号','快递重量','仓库重量','快递运费','仓库运费','运费差'
                        ));
                        $s = round(floatval($mw['ck'] - $mw['kd']),2);
                        $sheet->appendRow(array('仓库='.$count['ck'],'快递='.$count['kd'],'仓库-快递=多付值',$mw['ck'].' - '.$mw['kd'].' = '.$s),'负数等多付');
                        // Sheet manipulation
                    });
                })->export('xls');

                return view('Danhao.index' ,['danhao' => $table ,'dh_count' => $count] );
            }
            return view('Danhao.index' );
        }


        return view('Danhao.index');
    }

    public function txt(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            if (!$input['name'] ){
                return view('Danhao.txt',['post'=>true,'error'=>'请输入有效名字']);
            }
            if (!$input['qq'] && !$input['wx'] && !$input['iphon']){
                return view('Danhao.txt',['post'=>true,'error'=>'联系方式 3选1']);
            }
            unset($input['_token']);
            DB::table('user')->insert(
                $input
            );
            return view('Danhao.txt',['post'=>true,'add'=>true]);

        }
        return view('Danhao.txt',['post'=>false,'error'=>false,'add'=>false]);
    }

}
