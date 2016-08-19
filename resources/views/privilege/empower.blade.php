<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
  });
  
  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".sure").click(function(){
  $(".tip").fadeOut(100);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});
</script>


</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">权限管理</a></li>
    <li><a href="#">角色管理</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
        <form action="{{URL('privilege/role_empower_add')}}" method="post">
            <input type="hidden" value="{{$role_id}}" name="role_id"/>
            <table class="tablelist">
                <tbody>
                <tr>
                <td colspan="2"><center><b style="color:#0000FF; font-size: 20px;" >{{$role_name}}</b></center></td>
                </tr>
                @foreach($power as $k=>$v)
                <tr>
                    <td style="width: 120px;"><center> <input type="checkbox" name="pow_id[]" class="FirstLevel"  value="{{$v['pow_id']}}" <?php if($v['call']==1){echo "checked";}  else{echo "";} ?>/>&nbsp;&nbsp;{{$v['pow_name']}}</center></td>
                <td>@foreach($v['son'] as $kk=>$vv)
                        <input type="checkbox" name="pow_id[]" class="secondLevel"  parent_id="{{$v['pow_id']}}"  value="{{$vv['pow_id']}}" <?php if($vv['call']==1){echo "checked";}  else{echo "";} ?> />&nbsp;&nbsp;{{$vv['pow_name']}}&nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <br/>
            <center><input  type="submit" class="btn" value="保存"/>&nbsp;&nbsp;<input type="reset" class="btn" value="取消"/></center>
        </form>
    
    </div>
    
    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>
</body>
</html>
<script type="text/javascript">
    $(function(){
        /**
         * 点击一级默认选中一级
         */
       $(".FirstLevel").click(function(){
           var oSecond = $(".secondLevel");
           var pow_id = $(this).val();
           var state=$(this).is(":checked");
           for(var i=0;i<oSecond.length;i++){
               if(oSecond.eq(i).attr('parent_id')==pow_id){
                   oSecond.eq(i).attr('checked',state);
               }
           }
       });
        /**
         * 点击二级默认选中一级
         */
        $(".secondLevel").click(function(){
           var _this=$(this);
            var pow_pid=_this.attr('parent_id');
            var oFirst=$(".FirstLevel");
            for(var i=0;i<oFirst.length;i++){
                if(oFirst.eq(i).val() == pow_pid){
                    oFirst.eq(i).attr('checked',true);
                }
            }
            //二级都未选中取消一级
            var oBrother=$(".secondLevel");
            var qBrother =new Array();
            for(var k=0;k<oBrother.length;k++){
                if(oBrother.eq(k).attr('parent_id')==pow_pid){
                    qBrother.push(oBrother.eq(k));
                }
            }
            //console.log(qBrother);
            var sign=0;
            for(var m=0;m<qBrother.length;m++){
                if(qBrother[m].is(':checked')==false){
                    //alert(qBrother[m].is(':checked'));
                    sign=1;
                }else{
                    sign=0;break;
                }
            }
            if(sign){
                for(var j=0;j<oFirst.length;j++){
                    if(oFirst.eq(j).val()==pow_pid){
                        oFirst.eq(j).attr('checked',false);
                    }
                }
            }
        });
    });
</script>