
$('body').click(function(){
     hideWindow();
});

/**
 * 添加div弹出窗口，显示颜色信息
*/
function showWindow(o,arr){
  //删除原来的窗口信息
  $('.window_Self').remove();
  //创建div
  var div ='<div class="window_Self popover container"><div class="arrow"></div><h3 class="popover-title">请选择<span class="btn btn-link clearItem">置空</span></h3><div class="popover-content window_content"></div></div>';
  //添加到页面
  $('body').append(div);
  //隐藏
  $('.window_Self').hide();

  //填充颜色信息
  setColorToDiv(arr);

  //计算位置
  var em = $(o).offset();
  var top = em.top+$(o).outerHeight();
  // alert(top);
  var left = em.left;
  // alert(top+','+left);
  //自定义样式信息
  $('.window_Self').css({'position':'absolute','top':top,'left':left,'max-width':'400px'});
  $('.window_content').css({'max-height':'230px','overflow':'auto'});
  //显示窗口信息
  $('.window_Self').show();

  //定义单机事件
  $('.window_color').click(function(){
      o.value=$(this).html();
  });

  $('.clearItem').click(function(){
    o.value='';
  });
}

/**
 * 隐藏div
*/
function hideWindow(){
  $('.window_Self').hide();
  $('.window_Self').remove();
}

/**
 * 填充颜色信息
*/
function setColorToDiv(arr){
  //清空内容
  clearWindow();
  var str_color = '';
  var content=[];
  if(arr){
    for(var i=0;arr[i];i++){
      if(arr[i].first==true){
         content.push('<div class="col-md-12 text-danger"><b>'+arr[i].letter+'</b></div>');
      }
      content.push('<div class="col-md-6 btn btn-link window_color">'+arr[i].color+'</div>');
    }
    str_color = content.join('');
  }else{
    str_color="无颜色";
  }
  // alert(str_color);
  $('.window_content').html(str_color);
}

/**
 * 填充颜色信息
*/
function clearWindow(){
  $('.window_content').html('');
}