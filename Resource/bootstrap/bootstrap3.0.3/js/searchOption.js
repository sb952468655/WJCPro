/*****************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :li
*  FName  :select_input.js
*  Time   :2014/09/25 14:58:22
*  Remark :下拉框显示较多的时候，客户一般认为比较难以选择，换控件比较浪费时间，
* 该js 处理搜索option选项问题，临时解决方案
\*********************************************************************/
(function($) {
	/**
	 * 加载
	*/
	 var SelectOptions = function (el, options) {
	 	var that = this;
        this.options = options;
        this.$el = $(el);
        this.$el.removed = false;
        // this.$el_ = this.$el.clone();
        $(el).attr('title','右击鼠标支持筛选，回车确认');

        // this.initInput();

        
        $(el).bind('dblclick contextmenu',function(){
			that.initInput();
			return false;
		});

		this.$el.bind('blur',function(){
			if(that.$el.removed == true){

				var value = $(this).val();

				$(this).children().remove();

				$(this).append(that._Select.children());

				$(this).val(value);

				that._Select.children().remove();

				that.$el.removed = false;
			}
		});
    };

    /**
     * 初始化界面
    */
    SelectOptions.prototype.initInput = function () {
    	var el = this.$el;
    	var _this = this;

    	if($('#_input_select_').length==0){
    		var _input_ = "<input type='text' name='_input_select_' id='_input_select_' value='' style='display:none;z-index:100;' placeholder='搜索选项，回车确认'>";

			_input_ +="<select name='_select_options_' id='_select_options_' style='display:none;'></select>";

			//添加控件
			$(_input_).appendTo('body');
    	}

    	var input = $('#_input_select_');
    	var _thatOption = $('#_select_options_');

    	this._Select = _thatOption;
    	this._Input = input;

		//隐藏，不显示
		$(input).hide();
		$(_thatOption).hide();

		
		$(input).off('dblclick').on('dblclick', $.proxy(_this.optionShow, _this));
		
		$(input).keydown(function(event){
			if(event.keyCode==13){
				$(input).dblclick();
			}
		});

		//计算位置
		var em = $(el).offset();

		$(input).css({
			'position':'absolute',
			'top':em.top,
			'left':em.left,
			'width':$(el).outerWidth(),
			'height':$(el).outerHeight()
		});

		$(input).addClass('form-control');

		//显示空
		$(input).val('');

		$(input).show();
		// $(el).blur();
		$(input).focus();
	}

    /**
     * 隐藏option选项，显示筛选到的值
    */
    SelectOptions.prototype.optionShow = function(){
    	//debugger;
    	var o = this.$el;
    	//输入框隐藏
		$(this._Input).hide();
		

		//匹配的项显示
		var likeStr = $(this._Input).val();

		if(likeStr=='')return;
		if(o.removed)return;

		//所有的下拉选项全部为隐藏
		this._Select.children().remove();
		this._Select.append($(o).children());

		//debugger;
		$(o).children().remove();
		o.removed = true;
		//debugger;
		$('option[value!=""]',this._Select).each(function(){
			if(this.text.indexOf(likeStr)>=0){
				var temp = $(this).clone(true);
				$(o).append(temp);
			}
		});

		$(o).focus();
		//o.size=o.length;
    }

	/**
	 * 默认参数
	 * @var Array
	*/
	SelectOptions.defaults = {};

	$.fn.searchOption = function (option, _relatedTarget) {
		var value;
	    this.each(function () {
            var $this = $(this),
                data = $this.data('select.search'),
                options = $.extend({}, SelectOptions.defaults, $this.data(), typeof option === 'object' && option);

            if (!data) {
                $this.data('select.search', (data = new SelectOptions(this, options)));
            }

            if (typeof option === 'string') {
                if ($.inArray(option, allowedMethods) < 0) {
                    throw "Unknown method: " + option;
                }
                value = data[option](_relatedTarget);

                if (option === 'destroy') {
                    $this.removeData('select.search');
                }
            }
        });

	    return typeof value === 'undefined' ? this : value; 
	}

})(jQuery);  

$(function(){
	$('select').searchOption();
});