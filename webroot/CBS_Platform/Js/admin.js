function selectAll()
{
  var obj = document.getElementsByName("checkAll[]");
  if(document.getElementById("selAll").checked == false)
  {
  for(var i=0; i<obj.length; i++)
  {
    obj[i].checked=false;
  }
  }else
  {
  for(var i=0; i<obj.length; i++)
  {  
    obj[i].checked=true;
  }
  }
 
}

//当选中所有的时候，全选按钮会勾上
function setSelectAll()
{
	var obj=document.getElementsByName("checkAll[]");
	var count = obj.length;
	var selectCount = 0;
	
	for(var i = 0; i < count; i++)
	{
		if(obj[i].checked == true)
		{
			selectCount++;
		}
	}
	if(count == selectCount)
	{
		document.all.selAll.checked = true;
	}
	else
	{
		document.all.selAll.checked = false;
	}
}

//反选按钮
function inverse() {
	var checkboxs=document.getElementsByName("checkAll[]");
	for (var i=0;i<checkboxs.length;i++) {
	  var e=checkboxs[i];
	  e.checked=!e.checked;
	  setSelectAll();
	}
}
//通过js获取参数
function getQueryStringValue(name) { 
	var str_url, str_pos, str_para;
	var arr_param = new Array();
	str_url = window.location.href;
	str_pos = str_url.indexOf("?");
	
	str_para = str_url.substring(str_pos + 1);
	if (str_pos > 0) {
		//if contain # ----------------------begin
		str_para = str_para.split("#")[0];
		//-----------------------------------end
		arr_param = str_para.split("&");
		for (var i = 0; i < arr_param.length; i++) {
		var temp_str = new Array()
		temp_str = arr_param[i].split("=")
		if (temp_str[0].toLowerCase() == name.toLowerCase()) {
		return temp_str[1];
		}
		}
	}
	return "";
} 