@extends('layouts.dh')

@section('content')
    <style>
        .report-file {
            display: block;
            position: relative;
            width: 120px;
            height: 28px;
            overflow: hidden;
            border: 1px solid #428bca;
            background: none repeat scroll 0 0 #428bca;
            color: #fff;
            cursor: pointer;
            text-align: center;
            float: left;
            margin-right:5px;
        }
        .report-file span {
            cursor: pointer;
            display: block;
            line-height: 28px;
        }
        .file-prew {
            cursor: pointer;
            position: absolute;
            top: 0;
            left:0;
            width: 120px;
            height: 30px;
            font-size: 100px;
            opacity: 0;
            filter: alpha(opacity=0);
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       使用说明
                    </div>

                    <div class="panel-body">
                        <ul>
                            <li>自动转换千克</li>
                            <li>默认第一行内容不做使用</li>
                            <li>注意 · 请保持3列,第一列=<code>单号</code>,第二列=<code>重量</code>,第三列=<code>运费</code></li>
                        </ul>

                    </div>
                </div>

                <form role="form" method="POST" enctype ="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputFile">仓库单号</label>
                        <input type="file" id="exampleInputFile" name="ckdh">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">快递单号</label>
                        <input type="file" id="exampleInputFile" name="kddh">
                    </div>

                    <button type="submit" class="btn btn-default">提交</button>
                </form>
            </div>
        </div>
    </div>
@endsection