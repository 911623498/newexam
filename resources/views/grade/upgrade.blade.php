<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>
</head>
<body>
<ul class="classlist">
    @foreach($data as $v)
        @foreach($v['grade'] as $vv)
        <li>
            <span></span>
            <div class="lright">
                <h2>姓名：{{$vv['stu_name']}}</h2>
                <p>学号：{{$vv['stu_care']}}</p>
                组员状态： <select name="" class="select2" onchange="showMsg(this,{{$vv['id']}})" style="width: 50px;height: 20px;border: solid  1px #000000;margin-top: 8px;">
                    <option value="e">正常</option>
                    <option value="d" @if($vv['chengji'][0]=="监考")selected = "selected"@endif>监考</option>
                    <option value="a" @if($vv['chengji'][0]=="请假")selected = "selected"@endif>请假</option>
                    <option value="c" @if($vv['chengji'][0]=="休学")selected = "selected"@endif>休学</option>
                    <option value="b" @if($vv['chengji'][0]=="作弊")selected = "selected"@endif>作弊</option>
                </select>
                <div style="margin-top: 8px;">
                <input type="hidden" class="name" value="{{$vv['id']}}"/>
                <p>理论：<input type="text" name="{{$vv['id']}}" class="grade" value="{{$vv['chengji'][0]}}"/>分</p><br>
                <p>机试：<input type="text"  name="{{$vv['id']}}" class="grade" value="{{$vv['chengji'][1]}}"/>分</p>

            </div>
            </div>
        </li>
        @endforeach
    @endforeach
</ul>
</body>
</html>