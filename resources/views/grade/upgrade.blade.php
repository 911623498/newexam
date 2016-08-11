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
                <p>学号：{{$vv['stu_care']}}</p><br>
                <input type="hidden" class="name" value="{{$vv['id']}}"/>
                <p>理论：<input type="text" name="grad" class="grade" value="{{$vv['chengji'][0]}}"/>分</p><br>
                <p>机试：<input type="text"  name="grad" class="grade" value="{{$vv['chengji'][1]}}"/>分</p>
            </div>
        </li>
        @endforeach
    @endforeach
</ul>
</body>
</html>