/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :Jeff
*  FName  :btGrid.js
*  Time   :2014/05/13 18:31:40
*  Remark :基于bootstrap的grid插件,接口设计参考easyui
*  $(element).data() 方法向被选元素附加数据，或者从被选元素获取数据。
*  $("div").data("greeting", "Hello World");//附加值
*  $("div").data("greeting");//取值
\*********************************************************************/
// 创建一个闭包    
(function($) {    

  // 插件的定义
  //options可能是配置对象，也可能是方法名(string);
  //_relatedTarget:当options为方法名时的参数
  $.fn.btGrid = function(options,_methodParam) {
    //在这个区间，this指jquery对象,
    //在下面的函数中，this值element
    /*$('#a').click(function(){
      alert(this.text);
    });*/

    //默认配置
    // 插件的默认配置
    $.fn.btGrid.defaults = {
      'url':''//远程获取数据的地址
      ,'columns':null//字段对象一般是{'_edit':'aas','id':{'text':'id','width':100}}
      ,'data':[]//静态数据,优先级高于url
      ,'defaultColumnWidth':100//默认列宽度
    };
    
    //将默认配置和用户配置合并
    // var opts = $.extend({}, $.fn.btGrid.defaults, options);
    var opts = $.extend({}, $.fn.btGrid.defaults, typeof(options)=='object'?options:null);

    //定义插件方法
    var methods = {
      //初始化
      'init':function(){
        $this = $(this);
        //将配置加入element的data中，作为缓存使用，封装
        $this.data('optionsBtGrid',opts);

        var columns=$this.data('optionsBtGrid').columns;

        //构建表头 '<thead><tr><th style="width:100px;">aa</th><th style="width:100px;">b</th></tr></thead>';
        var arrHtml = [];
        arrHtml.push('<thead><tr>');
        for(var i in columns) {
          var c = columns[i];
          //列宽
          var w = $this.data('optionsBtGrid').defaultColumnWidth;
          w=c.width?c.width:w;

          //标题
          var t = typeof c == 'string' ? c : c.text;
          arrHtml.push('<th style="width:'+w+'px;">'+t+'</th>');
        }        
        arrHtml.push('</tr></thead>');
        
        //构建表体<tr><td>aaa</td><td>aaa</td></tr><tr><td>bbb</td><td>bbb</td></tr>
        var body = '<tbody></tbody>';
        //填充
        $this.html(arrHtml.join('')+body);
      }
      
      //载入并显示第一页的记录，如果传递了'param'参数，它将会覆盖查询参数属性的值。通过传递一些参数，通常做一个查询，这个方法可以被称为从服务器加载新数据。
      ,'load':function(param) {
        //优先使用静态数据
        var $this=$(this);
        var rowset = $this.data('optionsBtGrid')['data'];
        if (rowset && rowset.length>0) {
          $this.btGrid('_load',rowset);
          return;
        }
        //远程数据
        var columns=$this.data('optionsBtGrid').columns;
        var url=$this.data('optionsBtGrid').url;        
        $.post(url,param,function(json){
          if(!json || !json.success) {
            alert('reload 数据 出错');
            return;
          }
          //载入数据前将数据集放入缓存
          $this.data('optionsBtGrid').data=json.rows;
          
          $this.btGrid('_load',json.rows);
        },'json');
      }

      //重载记录，跟'load'方法一样但是重载的是当前页的记录而非第一页。
      ,'reload':function(param){
        //如果param为静态数据
        //alert('reload');
      }

      //载入静态数据,被load调用
      ,'_load':function(rows) {
        $this = $(this);
        var columns=$this.data('optionsBtGrid').columns;
        //重新生成库存数据
        var arrHtml = [];
        for(var i=0;rows[i];i++) {
          var temp="<tr class='trRow'>";
          for(var c in columns) {          
            //cell中内容,如果为首列且不存在内容，显示为checkbox
            var v = rows[i][c]?rows[i][c]:'aa';
            // if(!v) {
            //   v='';
            //   if(c=='_edit') {
            //     v='<input type="checkbox" id="chk" class="chk" value=""/>';
            //   }
            // }
            temp+='<td>'+v+'</td>';
          }
          temp +="</tr>"; 
          arrHtml.push(temp);
        }
        var html=arrHtml.join('');
        $('tbody',this).html(html);
      }

    };

    //return的目的是保证链式调用,比如$(a).click(fn).fade('show');    
    return this.each(function() {
      //传入的参数如果为字符串，表示是调用方法,否则表示是初始化
      if ( typeof options === 'object' || ! options ) {  
        methods.init.call( this, _methodParam );  
      } else if ( typeof options === 'string' && methods[options] ) {  
        methods[options].call( this, _methodParam);  
      } else {  
        $.error( 'Method ' +  options + ' does not exist on jQuery.tooltip' );  
      }  
    });
     
  };    
  // 私有函数：debugging    
  // function debug($obj) {
  //   if (window.console && window.console.log)    
  //     window.console.log('hilight selection count: ' + $obj.size());    
  // }; 

  // 定义暴露format函数    
  // $.fn.btGrid.format = function(txt) {    
  //   return '<strong>' + txt + '</strong>';    
  // };

     
// 闭包结束    
})(jQuery);   