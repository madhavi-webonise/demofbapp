<?php
/* FbImageUpload Test cases generated on: 2011-09-05 14:09:04 : 1315214824*/
App::import('Model', 'Fbappdemo.FbImageUpload');

class FbImageUploadTestCase extends CakeTestCase {
	function startTest() {
		$this->FbImageUpload =& ClassRegistry::init('FbImageUpload');
	}

	function endTest() {
		unset($this->FbImageUpload);
		ClassRegistry::flush();
	}

}
?>