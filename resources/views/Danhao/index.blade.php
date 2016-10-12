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
                        @if(isset($dh_count))
                            快递 <code>{{ $dh_count['kd'] or '0' }}</code>
                            仓库 <code>{{ $dh_count['ck'] or '0' }}</code>

                        @endif
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>单号</th>
                                <th>重量</th>
                                <th>运费</th>
                                <th>出错</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($danhao))
                                <?php $i = 0;?>
@foreach($danhao as $key => $item )

                            <tr>
                                <td><?php echo ++$i ; ?></td>
                                <td>{{$key}}</td>
                                <td>快递kg <code>{{$item['kd']['kg'] or 'null' }}</code> / <code>{{$item['ck']['kg'] or 'null'}}</code> 仓库kg</td>
                                <td>快递yf <code>{{$item['kd']['fy'] or 'null' }}</code> / <code>{{$item['ck']['fy'] or 'null'}}</code> 仓库yf</td>
                            </tr>
@endforeach
@endif
                            </tbody>
                        </table>
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