<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Excel;

class ExcelController extends Controller
{
    //
    public function import(){
        $filePath = 'storage/exports/'.iconv('UTF-8', 'GBK', '学生成绩').'.xls';
        Excel::load($filePath, function($reader) {
            $data = $reader->all();
            dd($data);
        });
    }
}
