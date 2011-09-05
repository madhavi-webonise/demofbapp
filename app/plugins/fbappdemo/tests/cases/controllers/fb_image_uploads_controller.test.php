<?php
/* FbImageUploads Test cases generated on: 2011-09-05 14:09:48 : 1315214868*/
App::import('Controller', 'Fbappdemo.FbImageUploads');

class TestFbImageUploadsController extends FbImageUploadsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class FbImageUploadsControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->FbImageUploads =& new TestFbImageUploadsController();
		$this->FbImageUploads->constructClasses();
	}

	function endTest() {
		unset($this->FbImageUploads);
		ClassRegistry::flush();
	}

}
?>