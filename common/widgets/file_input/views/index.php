<?php
use kartik\file\FileInput;
$name = $config['pluginOptions']['uploadExtraData']['name'];

?>
<style>
.progress{display:none;}
</style>
<script>
window.onload = function(){
	$('.file-caption-name').html("<?=$forms['value'] ?>")	
	var field = $('.field-<?=$name ?>').find('input');
	field[0].value = "<?=$forms['value'] ?>";
}
</script>
<?= $forms['form']->field($forms['model'] , $forms['attribute'])->widget(\kartik\file\FileInput::className(),$config);?>