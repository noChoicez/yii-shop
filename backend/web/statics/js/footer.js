$(function(){
	var myDate = new Date()
	
	//Date picker
    $('.datepicker').datepicker({
    	language:'zh-CN',
      	autoclose: true,
      	singleDatePicker: true,
        showDropdowns: true,
        minDate:myDate.getFullYear()+'-'+myDate.getMonth()+'-'+myDate.getDate(),
        maxDate:'2030-01-01',
        format: 'yyyy-mm-dd',
    });
})