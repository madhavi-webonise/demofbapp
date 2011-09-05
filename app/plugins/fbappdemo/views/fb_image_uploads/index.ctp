<?php
if(isset($pagelikeid) && $pagelikeid == '1'){
 $pagelikeid = $pagelikeid;
?>

<div class="fbImageUploads index">
	<h2><?php __('Fb Image Uploads');?></h2>
	<ul>
		<li><?php echo $this->Html->link(__('New Fb Image Upload', true), array('action' => 'add')); ?></li>
	</ul>
</div>
<?php
}else{
    $pagelikeid ='0';
?>
<img src="/img/likeus.jpg" alt="Please like our fanpage first" align="center" />
<?php
}
?>