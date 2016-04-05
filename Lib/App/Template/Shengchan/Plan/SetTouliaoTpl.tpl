<script language="javascript">
{literal}
	//访问地址，传递id信息
	function SetPlanByMore(obj){
		var plan2ProId = getPlan2proId();
		if(plan2ProId == ''){
			return;
		}

		var url=$('#thisUrl').attr('url');
		url+='&id='+plan2ProId;

		window.location.href = url;
	}

	//获取投料计划的id
	function getPlan2proId(){
		var temp=[];
		var i=0;
		var productId=[];
		$('[name="plan2ProId[]"]:checked').each(function(){
			temp.push($(this).val());
			productId.push($(this).attr('productId'));
			i++;
		});

		if(i < 2){
			alert('至少选择两条信息');
			return '';
		}
		// debugger;
		productId=productId.unique();
		if(productId.length>1){
			alert('必须同一计划单且品种必选相同');
			return '';
		}

		return temp.join(',');
	}

	//去掉重复值
	Array.prototype.unique=function(){
		var o={},newArr=[],i,j;
		for( i=0;i<this.length;i++){
			if(typeof(o[this[i]])=="undefined")
			{
			    o[this[i]]="";
			}
		}
		for(j in o){
		     newArr.push(j)
		}
		return newArr;
	}
{/literal}
</script>