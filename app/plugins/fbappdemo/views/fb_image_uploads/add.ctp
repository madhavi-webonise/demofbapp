

<div class="fbImageUploads form">
<?php echo $this->Form->create('FbImageUpload',array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Add Fb Image Upload'); ?></legend>
	<?php
		echo $this->Form->input('uploader_id',array('type' => 'hidden','value'=>$user_id));
		echo $this->Form->input('name',array('type' => 'hidden','value'=>$name));
		echo $this->Form->input('email',array('type' => 'hidden','value'=>$email));
        ?>
                <label>Select file to uplaod</label>
        <?php
		echo $this->Form->file('image_name',array('type'=>'file'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
