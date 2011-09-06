<?php
echo $this->Html->script(array('jquery-1.4.2.min','jquery.validate', 'jquery.validation.functions'), false);
?>
<script type="text/javascript" >
/* <![CDATA[ */
jQuery(function(){

    jQuery("#userName").validate({
        expression: "if (VAL) return true; else return false;",
        message: "Please enter your name"
    });

    jQuery("#userEmail").validate({
        expression: "if ((VAL != 'Email Address') && VAL) return true; else return false;",
        message: "Please enter email address"
    });
    jQuery("#userEmail").validate({
        expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
        message: "Please enter a valid email address"
    });

    jQuery("#imageName").validate({
        expression: "if (VAL) return true; else return false;",
        message: "Please select image to upload"
    });

    jQuery("#imgTitle").validate({
        expression: "if (VAL) return true; else return false;",
        message: "Please enter photo title"
    });

    jQuery("#imgTitle").validate({
        expression: "if (VAL.length < 60 && VAL) return true; else return false;",
        message: "Photo Title should be maximum 60 charactors"
    });
});
/* ]]> */
</script>
<div class="fbImageUploads form">
<?php echo $this->Form->create('FbImageUpload',array('type' => 'file','inputDefaults' => array('div' => false, 'label' => false)));?>
	<fieldset>
 		<legend><?php __('Upload Image for Social Contest'); ?></legend>
	<?php
		echo $this->Form->input('uploader_id',array('type' => 'hidden','value'=>$user_id));
		echo $this->Form->input('name',array('type' => 'hidden','value'=>$name));
		echo $this->Form->input('email',array('type' => 'hidden','value'=>$email));
        ?>
                <label>Name</label>
                <?php
                echo $this->Form->input('username',array('id'=>'userName'));
                ?>
                 <label>Email</label>
                <?php
                echo $this->Form->input('useremail',array('id'=>'userEmail'));
                ?>
                <label>Select file to uplaod</label>
        <?php
		echo $this->Form->file('image_name',array('type'=>'file','id'=>'imageName'));
	?>
                 <label>Add Description (60 chars)</label>
                <?php
                echo $this->Form->input('imgtitle',array('id'=>'imgTitle'));
                ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
