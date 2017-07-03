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
