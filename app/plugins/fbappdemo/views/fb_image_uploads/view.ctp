<div class="fbImageUploads view">
<h2><?php  __('Fb Image Upload');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fbImageUpload['FbImageUpload']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Uploader Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fbImageUpload['FbImageUpload']['uploader_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fbImageUpload['FbImageUpload']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fbImageUpload['FbImageUpload']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fbImageUpload['FbImageUpload']['image_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fbImageUpload['FbImageUpload']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fbImageUpload['FbImageUpload']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Fb Image Upload', true), array('action' => 'edit', $fbImageUpload['FbImageUpload']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Fb Image Upload', true), array('action' => 'delete', $fbImageUpload['FbImageUpload']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $fbImageUpload['FbImageUpload']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Fb Image Uploads', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fb Image Upload', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
