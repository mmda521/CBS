/*
*  依赖jquery,请先加载jquery-1.4.2.min.js
*  version:V1.7               Date:2011/04/01
*  eragon
*/
$(function(){   
	$.fn.extend({
		InitValid:function(){
			    $(this).find("input[type=text],textarea,select").each(function(index){
			    if(index == 0) firstObj = $(this);
			    var data = {};
			    if($(this).attr("valType"))
				    data["valType"] = $(this).attr("valType");

			    if($(this).attr("min"))
				    data["min"] = $(this).attr("min");

			    if($(this).attr("max"))
				    data["max"] = $(this).attr("max");
    				
			    if(!$(this).attr("id"))
			    {
			        $(this).attr("id","ctrl" + index);
			    }
			    
			    if($(this).attr("minLength"))
				    data["minLength"] = $(this).attr("minLength");

			    if($(this).attr("maxLength"))
				    data["maxLength"] = $(this).attr("maxLength") || $(this).attr("MaxLength");

			    if($(this).attr("required"))
				    data["required"] = $(this).attr("required");

			    $(this).data("validSettings",$.extend({},data,eval("(" + $(this).attr("validSettings") + ")")));

			    if($(this).data("validSettings").maxLength && $(this).data("validSettings").maxLength!=-1)
			        $(this).attr("maxLength",$(this).data("validSettings").maxLength);
			        
			    if(!$(this).data("validSettings").tipStyle)
			    {
			        $(this).data("validSettings").tipStyle = $.tipStyle || "bottom";
			    }
			    
			    if(!$(this).data("validSettings").messages)
			    {
			        $(this).data("validSettings").messages = {};
			    }
			    		    
			});
			
			if(firstObj) firstObj.focus();

			//input tips
			$("input[type=text],textarea,select").focus(
				function(e) {
						ShowTips($(this));
				}
			).hover(function(e){
			        ShowErrors($(this));
			    },
			    function(e)
			    {
			    }
			).keyup(function(event){
			    if($(this).data("validSettings").maxLength == -1 || $(this).data("validSettings").maxLength == undefined) return true;
				if($(this).val().length > $(this).data("validSettings").maxLength)
				{
					$(this).val($(this).val().substring(0,$(this).data("validSettings").maxLength));
				}

				if(($(this).data("validSettings").calcRemain == "true" || $(this).data("validSettings").calcRemain == true) && !isNaN($(this).data("validSettings").maxLength))
				{
					$(this).attr("sysMsg","已录入" + $(this).val().length + "个字符，还可以录" + ($(this).data("validSettings").maxLength - $(this).val().length) + "个");
					ShowTips($(this));
				}
			}).keydown(function(event){
                if($(this).data("validSettings").valType == undefined) return true;
                
				//按下ctrl、shift、alt 等功能键
				if(event.ctrlKey || event.shiftKey || event.altKey) return true; 

				//方向键 && F1..F12
				var key = event.keyCode;
				if(key >= 33 && key <= 47) return true;
				if(key >= 112 && key <=137) return true;
				
				
				//8 = BackSpace	9 = Tab		12 = Clear	13 = Enter	16 = Shift_L	17 = Control_L	18 = Alt_L	19 = Pause		20 = Caps_Lock	27 = Escape Escape
				var sCode = ";8;9;12;13;16;17;18;19;20;27;";
				if(sCode.indexOf(";" + key + ";") >= 0) return true;

				switch($(this).data("validSettings").valType.toLowerCase())
				{
					case "number":
						if(!((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || key == 190 || key==189 || key==109 || key==110))
							return false;
						break;
					case "int":
						if(!((key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
							return false;
						break;
					case "telphone":
						if(!((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || key == 189 || key == 109))
							return false;
						break;
					case "mobile":
						if(!((key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
							return false;
						break;
					case "date":
						if(!((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key >= 189 && key<=191) || key == 32 || key==109 || key==110))
							return false;
						break;
				}
				
				return true;
			}).blur(function(even){
				validate($(this));
			});
		   //加载css
           includeCSS(Jsroot()+"validatestyle.css");
			
			/*$("input[type='submit']").click(function(){
			    return $(this.form).Valid();
			});*/
			
		},
		ShowErrors:function(msg){
		    $(this).attr("errMsg",msg);
		    ShowResult($(this));
		},
		Valid:function(){
		    firstObj = null;
			var isSubmit = true;
			$(this).find("input[type=text],textarea,select").each(function(){
				if($(this).data("validSettings"))
				{
					if(!validate($(this))){
					    if(firstObj == null) firstObj = $(this);
						isSubmit = false;
					}
				}
				if(!isSubmit) return false;
			});
			return isSubmit;
		},
		ShowErrors:function(msg)
		{
			$(this).attr("errMsg",msg);
			ShowResult($(this));
		},
		ValidGroup:function(groupName){
			 firstObj = null;	 
			 var isSubmit = true;
			 $(this).find("input[valGroup=" +groupName+ "][type=text],textarea[valGroup=" +groupName+ 
			 "],select[valGroup=" + groupName+ "]").each(function(){
			 	if($(this).data("validSettings"))
				{
					if(!validate($(this))){
					    if(firstObj == null) firstObj = $(this);
						isSubmit = false;
					}
				}
			 });
			return isSubmit;
		}
	});
	
	
	function validate(obj){
		obj.attr("errMsg","");
		$("div#vtip").remove();
		$("div#t" + obj.attr("id")).remove();
		obj.removeClass("input_validation-failed");
		//对于隐藏控件、只读控件、已禁用的控件 不进行前端校验
		if(obj.attr("display") == "none") return true;   
		if(obj.attr("readonly") == true) return true;
		if(obj.attr("disabled") == true) return true;
		

		var validSettings = obj.data("validSettings");
		
		//没有valType 或 required 属性，不校验
		if(validSettings.valType == undefined && validSettings.required ==undefined) return true;
		
		var objval = obj.val();
		//if(validSettings.required == "true" && (trim(objval) == "" || objval == null || objval == undefined))
		if((validSettings.required ||validSettings.required == "true")&& (trim(objval) == "" || objval == null || objval == undefined))
		{
			obj.attr("errMsg",validSettings.messages.required || "请填写该信息");
			ShowResult(obj);
			return false;
		}
		
		//允许为空，且无值则不校验
		if(obj.val() == null || obj.val() == undefined || obj.val().replace(/\ /gi,"")=="") return true; 
		
        if(validSettings.valType == undefined) return true;
		switch(validSettings.valType.toLowerCase())
		{
			case "url":
				var reg = /^(http|https|ftp)\:\/\/[a-zA-Z0-9\-\._]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?\/?([a-zA-Z0-9\-\._\?\,\'/\\\+&%\$#\=~])*$/;
				if(!reg.test(obj.val()))
				{
					obj.attr("errMsg",validSettings.messages.url || "您输入的Url格式不正确");
					ShowResult(obj);
					return false;
				}
				break;

			case "email":
				var reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
				if(!reg.test(obj.val()))
				{
					obj.attr("errMsg",validSettings.messages.email || "您输入的Email格式不正确");
					ShowResult(obj);
					return false;
				}
				break;
			case "number":
				var reg = /^(-?\d+)(\.\d+)?$/;
				if(!reg.test(obj.val()))
				{
					obj.attr("errMsg",validSettings.messages.number || "请输入数字");
					ShowResult(obj);
					return false;
				}
				break;
			case "telphone":
				var reg = /^\d{3}-\d{8}$|^\d{4}-\d{8}$/;
				if(!reg.test(obj.val()))
				{
					obj.attr("errMsg",validSettings.messages.telphone || "请输入正确的电话号码，例如0755-88880000");
					ShowResult(obj);
					return false;
				}
				break;
			case "mobile":
				var reg = /^(130|131|132|133|134|135|136|137|138|139|150|153|157|158|159|180|187|188|189)\d{8}$/;
				if(!reg.test(obj.val()))
				{
					obj.attr("errMsg",validSettings.messages.mobile || "请输入正确的手机号码");
					ShowResult(obj);
					return false;
				}
				break;
			case "ip":
				var reg =  /^(([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))\.)(([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))\.){2}([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))$/;
				if(!reg.test(obj.val()))
				{
					obj.attr("errMsg",validSettings.messages.ip || "请输入正确的IP地址，例如 127.0.0.1");
					ShowResult(obj);
					return false;
				}
				break;
			case "int":
				var reg = /^\d*$/;
				if(!reg.test(obj.val()))
				{
					obj.attr("errMsg",validSettings.messages.int || "请输入整数");
					ShowResult(obj);
					return false;
				}
				break;
			case "date":
				var reg = /^(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8]))))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-02-29)$/;
				if(!reg.test(obj.val()))
				{
					obj.attr("errMsg",validSettings.messages.date || "请输入格式正确的日期，例如：2010-02-28");
					ShowResult(obj);
					return false;
				}
				break;
			case "idcard":
				var reg = /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/;  //18位身份证号码
				reg= /^((11|12|13|14|15|21|22|23|31|32|33|34|35|36|37|41|42|43|44|45|46|50|51|52|53|54|61|62|63|64|65)[0-9]{4})(([1|2][0-9]{3}[0|1][0-9][0-3][0-9][0-9]{3}[X0-9])|([0-9]{2}[0|1][0-9][0-3][0-9][0-9]{3}))$/; 

				if(obj.val().length == 15)   //15位身份证号码
					reg =/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/; 
				if(!reg.test(obj.val()))
				{
					obj.attr("errMsg",validSettings.messages.idcard || "您输入的身份证格式不正确");
					ShowResult(obj);
					return false;
				}
				break;			
		}

		if(validSettings.regExp)
		{
			var reg = validSettings.regExp;
			if(!reg.test(obj.val()))
			{
				obj.attr("errMsg",validSettings.messages.regExp || "格式不对，请重新录入");
				ShowResult(obj);
				return false;
			}
		}

		if(validSettings.min)
		{
			if(validSettings.min.indexOf("#")==0 || validSettings.min.indexOf(".")==0)
			{
				$("div#vtip").remove();
				$(validSettings.min).attr("errMsg","");
				$(validSettings.min).removeClass("input_validation-failed");
				switch (validSettings.valType.toLowerCase())
				{
					case "number":
					case "int":
						if(stringToFloat(obj.val()) < stringToFloat($(validSettings.min).val()))
						{
							obj.attr("errMsg",validSettings.messages.min || "不能小于" + $(validSettings.min).val());
							ShowResult(obj);
							return false;
						}
						break;
					case "date":
						if(stringToDate(obj.val()) < stringToDate($(validSettings.min).val()) && stringToDate(obj.val()) != 0 &&  stringToDate($(validSettings.min).val()) != 0)
						{
							obj.attr("errMsg",validSettings.messages.min || "不能小于" + $(validSettings.min).val());
							ShowResult(obj);
							return false;
						}
						break;
					default:
						if(obj.val() < $(validSettings.min).val() && $(validSettings.min).val().replace(/\ /gi,"") != "")
						{
							obj.attr("errMsg",validSettings.messages.min || "不能小于" + $(validSettings.min).val());
							ShowResult(obj);
							return false;
						}
						break;
				}

			}
			else
			{
				switch (validSettings.valType.toLowerCase())
				{
					case "number":
					case "int":
						if(stringToFloat(obj.val()) < stringToFloat(validSettings.min))
						{
							obj.attr("errMsg",validSettings.messages.min || "不能小于" + validSettings.min);
							ShowResult(obj);
							return false;
						}
						break;
					case "date":
						if(stringToDate(obj.val()) < stringToDate(validSettings.min) && stringToDate(obj.val())!= 0 && stringToDate(validSettings.min)!= 0 )
						{
							obj.attr("errMsg",validSettings.messages.min || "不能小于" + validSettings.min);
							ShowResult(obj);
							return false;
						}
						break;
					default:
						if(obj.val() < validSettings.min)
						{
							obj.attr("errMsg",validSettings.messages.min || "不能小于" + validSettings.min);
							ShowResult(obj);
							return false;
						}
						break;
				}
			}
		}

		if(validSettings.max)
		{
			if(validSettings.max.indexOf("#") == 0 || validSettings.max.indexOf(".") == 0)
			{
				$("div#vtip").remove();
				$(validSettings.max).attr("errMsg","");
				$(validSettings.max).removeClass("input_validation-failed");
				switch (validSettings.valType.toLowerCase())
				{
					case "number":
					case "int":
						if(stringToFloat(obj.val()) > stringToFloat($(validSettings.max).val()))
						{
							obj.attr("errMsg",validSettings.messages.max || "不能大于" + $(validSettings.max).val());
							ShowResult(obj);
							return false;
						}
						break;
					case "date":
						if(stringToDate(obj.val()) > stringToDate($(validSettings.max).val()) && stringToDate(obj.val())!= 0 && stringToDate($(validSettings.max).val())!= 0)
						{
							obj.attr("errMsg",validSettings.messages.max || "不能大于" + $(validSettings.max).val());
							ShowResult(obj);
							return false;
						}
						break;
					default:
						if(obj.val() > $(validSettings.max).val() && $(validSettings.max).val().replace(/\ /gi,"") != "")
						{
							obj.attr("errMsg",validSettings.messages.max || "不能大于" + $(validSettings.max).val());
							ShowResult(obj);
							return false;
						}
						break;
				}
			}
			else
			{
				switch (validSettings.valType.toLowerCase())
				{
					case "number":
					case "int":
						if(stringToFloat(obj.val()) > stringToFloat(validSettings.max))
						{
							obj.attr("errMsg",validSettings.messages.max || "不能大于" + validSettings.max);
							ShowResult(obj);
							return false;
						}
						break;
					case "date":
						if(stringToDate(obj.val()) > stringToDate(validSettings.max) && stringToDate(obj.val())!= 0 && stringToDate(validSettings.max)!= 0)
						{
							obj.attr("errMsg",validSettings.messages.max || "不能大于" + validSettings.max);
							ShowResult(obj);
							return false;
						}
						break;
					default:
						if(obj.val() > validSettings.max)
						{
							obj.attr("errMsg",validSettings.messages.max || "不能大于" + validSettings.max);
							ShowResult(obj);
							return false;
						}						
						break;
				}
			}
		}

		if(validSettings.minLength)
		{
			if(obj.val().length < validSettings.minLength)
			{
				obj.attr("errMsg",validSettings.messages.minLength || "最短录入长度为" + validSettings.minLength);
				ShowResult(obj);
				return false;
			}
		}
		
		if(validSettings.remoteUrl)
		{
		    var url = validSettings.remoteUrl;
		    if(url.indexOf("?") > 0) 
		        url = url + "&param=" + escape(obj.val());
		    else
		        url = url + "?param=" + escape(obj.val());
		    $.getJSON(url + "&rnd=" + Math.random(),function(data){
		        if(data.result != 1)
		        {
		            obj.attr("errMsg",data.msg);
		            ShowResult(obj);
		            return false;
		        }
		        else
		        {
		            ShowResult(obj);
		        }
		        
		    });
		}
		else
		{
		    ShowResult(obj);
		}
		return true;
	}

	function stringToFloat(v)
	{
		if(isNaN(v)) 
			return 0;
		else
			return parseFloat(v);
	}

   function trim(string) {
    return string.replace(/(^\s*)|(\s*$)/g, "");
   }

	function stringToDate(v)
	{
		try
		{
			v = v.replace(/\-/gi,"/").replace(/\./gi,"/");
			return Date.parse(v);
		}
		catch (e)
		{
			return 0;
		}
	}

    function ShowResult(obj)
    {
        $("div#t" + obj.attr("id")).remove();
        $("div#vtip").remove();
        if(obj.data("validSettings").tipStyle.toLowerCase() == "bottom")
        {	    
		    if(obj.attr("errMsg"))
		    {
		        $('body').append( '<div id="vtip" class="error"><div id="vtipArrow" />' + obj.attr("errMsg") + '</div>' );
			    obj.addClass("input_validation-failed");
			}
			else if(obj.val().replace(/\ /gi,"")!="")
			{
			    obj.removeClass("input_validation-failed");
			}			
		    var top =   obj.position().top + obj.height() + 15;
		    var left =  obj.position().left;
		    $('div#vtip').css({top:top + "px",left:left + "px"});
		    $('div#vtip').show();
        }
        else
        {
		    if(obj.attr("errMsg"))
		    {
		        $('body').append( '<div class="error" id="t' + obj.attr("id") + '">' + obj.attr("errMsg") + '</div>' );
			    obj.addClass("input_validation-failed");
			}
			else if(obj.val().replace(/\ /gi,"")!="")
			{
		        $('body').append( '<div class="succ" id="t' + obj.attr("id") + '">&nbsp;</div>' );
			    obj.removeClass("input_validation-failed");
			}
		    var top = obj.position().top;
		    var left =  obj.position().left + obj.width() + 20;	
		    $("div#t" + obj.attr("id")).css({top:top + "px",left:left + "px"});
		    $("div#t" + obj.attr("id")).show();
		}
    }
    
    function ShowErrors(obj)
    {
		var msg = obj.attr("errMsg") ;
        if(msg == undefined || msg == "") return;
        $("div#t" + obj.attr("id")).remove();
        $("div#vtip").remove();
	    if(obj.data("validSettings").tipStyle.toLowerCase() == "bottom")
	    {
	        $('body').append( '<div id="vtip" class="error"><div id="vtipArrow" />' + msg + '</div>' );
		    obj.addClass("input_validation-failed");

		    var top = obj.position().top + obj.height() + 13;
		    var left = obj.position().left;
		    
		    $('div#vtip').css({top:top + "px",left:left + "px"});
		    $('div#vtip').show();
		}
		else
		{

	        $('body').append( '<div class="error" id="t' + obj.attr("id") + '">' + msg + '</div>' );
		    obj.addClass("input_validation-failed");
		    var top = obj.position().top;
		    var left =  obj.position().left + obj.width() + 20;		    
		    $("div#t" + obj.attr("id")).css({top:top + "px",left:left + "px"});
		    $("div#t" + obj.attr("id")).show();
		}
    }
    
	function ShowTips(obj)
	{
        $("div#t" + obj.attr("id")).remove();
        $("div#vtip").remove();
	    var msg = obj.attr("sysMsg") || obj.attr("tip");
	    if(msg == undefined || msg == "") return;
	    if(obj.data("validSettings").tipStyle.toLowerCase() == "bottom")
	    {
	        $('body').append( '<div id="vtip" class="tip"><div id="vtipArrow"/>' + msg + '</div>' );
		    obj.removeClass("input_validation-failed");
		    var top = obj.position().top + obj.height() + 13;
		    var left = obj.position().left;
		    $('div#vtip').css({top:top + "px",left:left + "px"});
		    $('div#vtip').show();
		}
		else
		{
	        $('body').append( '<div class="tip" id="t' + obj.attr("id") + '">' + msg + '</div>' );
		    obj.removeClass("input_validation-failed");
		    var top = obj.position().top;
		    var left =  obj.position().left + obj.width() + 20;		    
		    $("div#t" + obj.attr("id")).css({top:top + "px",left:left + "px"});
		    $("div#t" + obj.attr("id")).show();
		}
	}
	function Jsroot() {       
		var root,
		tmp;
		var scripts=document.getElementsByTagName("script");
		for (var i = 0; i < scripts.length; i++) {
			root = scripts[i].getAttribute("src");
			root = (root || "").substr(0, root.toLowerCase().indexOf("validator.js"));
			tmp = root.lastIndexOf("/");
			if (tmp > 0) root = root.substring(0, tmp + 1);
			if (root) break
		}
		return root
	}
	function includeCSS(link) {
		var head = document.getElementsByTagName("head")[0];
		var css = document.createElement("link");
		css.rel = "stylesheet";
		css.href = link;
		css.type = "text/css";
		head.appendChild(css);
	}
    var firstObj;
	$(this).InitValid();
});
