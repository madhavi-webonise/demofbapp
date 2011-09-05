<div class="fbImageUploads form">
<?php echo $this->Form->create('FbImageUpload');?>
	<fieldset>
 		<legend><?php __('Edit Fb Image Upload'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('uploader_id');
		echo $this->Form->input('name');
		echo $this->Form->input('email');
		echo $this->Form->input('image_name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('FbImageUpload.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('FbImageUpload.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Fb Image Uploads', true), array('action' => 'index'));?></li>
	</ul>
</div>