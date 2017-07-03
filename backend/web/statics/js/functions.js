/**
 * 判断对象是否存在 class
 * @param ele
 * @param cls
 * @returns
 */
function has_class(ele,cls) { 
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)')); 
} 

/**
 * 添加class
 * @param ele
 * @param cls
 * @returns
 */
function add_class(ele,cls) { 
	if (!this.has_class(ele,cls)) ele.className += " "+cls; 
} 

/**
 * 移除class
 * @param ele
 * @param cls
 * @returns
 */
function remove_class(ele,cls) { 
	if (has_class(ele,cls)) { 
	var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)'); 
	ele.className=ele.className.replace(reg,' '); 
	} 
} 

/**
 * 移除当前节点
 * @param element
 * @returns
 */
function removeElement(element)
{
	var parentElement = element.parentNode
	if(parentElement)
		parentElement.removeChild(element)
}

/**
 * 创建input对象
 *  @param data 
 *  @param progress 是否显示上传进度条 默认不显示
 */
function createInputElement(response, alert = true, progress = false)
{
	if(!progress){
		var pros = document.getElementsByClassName('kv-upload-progress')
		for(var i of pros){
			i.style.display = 'none'
		}
	}
	if(response.state == 'SUCCESS'){
		var form = response.form
		var field = response.field
		var url = response.url
		var multiple = response.multiple
		var cls = document.getElementsByClassName('field-' + form.toLowerCase() + '-' + field)[0]
		
		if(multiple){
			input = document.createElement('input')
			input.setAttribute('type', 'hidden')
			input.setAttribute('value', url)
			input.setAttribute('name', multiple?(form + '[' + field + '][]'):(form + '[' + field + ']'))
			cls.append(input)
		}else{
			cls.getElementsByClassName('file-caption-name')[0].innerHTML = url
			cls.getElementsByTagName('input')[0].value = url
		}
		if(alert){
			layer.msg('上传成功', {time: 1000});
		}
    }else{
        layer.msg(response.state, {time: 1000});
    }
}

/**
 * 删除input对象
 */
function deleteInputElement(data, name = '')
{
	if(data && name){
		var key = data.id
		var url = data.url
		var inputs = document.querySelectorAll("input[name='" + name + "']")
		inputs.forEach(v => {
			if(v.value == url){
				var parentElement = v.parentNode
				if(parentElement){
					parentElement.removeChild(v)
					layer.msg('删除成功', {time: 1000});
				}
			}
		})
	}
}

//点击规格按钮
function createDeleteInput(obj)
{
   if(has_class(obj,'btn-primary'))
   {
	   remove_class(obj, 'btn-primary');
	   add_class(obj, 'btn-default');		   
   }
   else
   {
	   remove_class(obj, 'btn-default');
	   add_class(obj, 'btn-primary');		   
   }
   
   ajaxGetSpecInputArr();	
}

//异步获取规格文本框：步骤1
function ajaxGetSpecInputArr(goods_id = 0)
{
	//用户选择的规格数组 
	var spec_arr = {}; 
	//选中了哪些属性	  
	$("#goods_spec button").each(function(){
	    if($(this).hasClass('btn-primary'))	
		{
			var spec_id = $(this).data('spec_id');
			var item_id = $(this).data('item_id');
			if(!spec_arr.hasOwnProperty(spec_id))
				spec_arr[spec_id] = [];
		    spec_arr[spec_id].push(item_id);
			//console.log(spec_arr);
		}		
	});
	ajaxGetSpecInput(spec_arr,goods_id)
}

//异步获取规格文本框：步骤2
function ajaxGetSpecInput(spec_arr,goods_id)
{		
    $.post("/goods/goods/ajax",{"action":"getSpecInput","spec_arr":spec_arr,goods_id:goods_id},function(data){
    	//console.log(data)
		$("#goods_spec_table").html('')
		$("#goods_spec_table").append(data);
		hbdyg();  // 合并单元格
    })
}

// 合并单元格
function hbdyg() {
       var tab = document.getElementById("spec_input_tab"); //要合并的tableID
       var maxCol = 3, val, count, start;  //maxCol：合并单元格作用到多少列  
       if (tab != null) {
           for (var col = maxCol - 1; col >= 0; col--) {
               count = 1;
               val = "";
               for (var i = 0; i < tab.rows.length; i++) {
                   if (val == tab.rows[i].cells[col].innerHTML) {
                       count++;
                   } else {
                       if (count > 1) { //合并
                           start = i - count;
                           tab.rows[start].cells[col].rowSpan = count;
                           for (var j = start + 1; j < i; j++) {
                               tab.rows[j].cells[col].style.display = "none";
                           }
                           count = 1;
                       }
                       val = tab.rows[i].cells[col].innerHTML;
                   }
               }
               if (count > 1) { //合并，最后几行相同的情况下
                   start = i - count;
                   tab.rows[start].cells[col].rowSpan = count;
                   for (var j = start + 1; j < i; j++) {
                       tab.rows[j].cells[col].style.display = "none";
                   }
               }
           }
       }
   }

//点击按钮触发选择文件事件
function selectFile(obj)
{
	var id = obj.dataset.item_id
	var fileInput = document.getElementById(id)
	fileInput.click()
}

//异步上传文件，HTMl5特性，不兼容
function uploadFile(obj)
{
	var myForm = new FormData();
	myForm.append(obj.name, obj.files[0]);  
	var req = new XMLHttpRequest();
	req.open("POST", "/goods/goods/upload?action=uploadimage&u="+Math.random(), true);
	req.send(myForm);
	req.onreadystatechange = function(){
		if(req.readyState == 4 && req.status == 200){
			var res = JSON.parse(req.responseText)
			if(res.state == "SUCCESS"){
				var id = res.form.toLowerCase() + '-' + res.field + '-' + obj.id
				var input = document.getElementById(id)
				var a = document.getElementById("item-" + obj.id)
				var img = document.createElement("img")
				img.src = res.url
				img.height = 32
				img.className = "ml5"
				input.value = res.url
				a.childNodes[0].remove()
				a.appendChild(img)
				layer.msg('上传成功', {time: 1000});
			}else{
				layer.msg('上传失败', {time: 1000});
			}
			
		}
	}
}

/**
 * 异步改变单个字段属性,依赖jQuery
 * @param string url 
 * @param string id
 * @param string field
 * @param string val  
 */
function updateField(url,id,field,val)
{
	if(isNaN(val)){
		layer.msg('请输入整数', {time: 1000})
		return false
	}
	$.ajax({
		url:url,
		data:{id:id,field:field,val:val},
		type:"post",
		success:function(res){
			layer.msg('更新成功', {time: 1000})
		},
		error:function (err){
			layer.msg('更新失败，错误：' + err.responseText, {time: 1000})
		}
	})
}