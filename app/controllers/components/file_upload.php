<?php

class FileUploadComponent extends Object {

    var $controller = '';

    /**
     * uploads files to the server
     * @params:
     * 		$folder 	= the folder to upload the files e.g. 'img/files'
     * 		$formdata 	= the array containing the form files
     * 		$itemId 	= id of the item (optional) will create a new sub folder
     * @return:
     * 		will return an array with the success of each file upload
     */
    function uploadFiles($folder, $formdata, $itemId = null, $permitted, $multifile = false) {

        $typeOK = false;

        // setup dir names absolute and relative
        $folder_url = WWW_ROOT . $folder;
        $rel_url = $folder;

        // create the folder if it does not exist
        if (!is_dir($folder_url)) {

            // chmod(WWW_ROOT, 0777);

            mkdir($folder_url, 1777);
            //change the chmod of medium project directory
            chmod($folder_url, 0777);
        }

        // if itemId is set create an item folder
        if ($itemId) {
            // set new absolute folder
            $folder_url = WWW_ROOT . $folder . '/' . $itemId;
            // set new relative folder
            $rel_url = $folder . '/' . $itemId;
            // create directory
            if (!is_dir($folder_url)) {
                mkdir($folder_url);
                //change the chmod of medium project directory
                chmod($folder_url, 0777);
            }
        }
        // list of permitted file types, this is only images but documents can be added
        //$permitted = array('image/gif','image/jpeg','image/pjpeg','image/png');

        if ($multifile == true) {
            // loop through and deal with the files
            foreach ($formdata as $file) {

                $file_ext = explode('.', $file['name']);

                $file_ext_size = sizeof($file_ext);

                // replace invalid characters with underscores
                $filename = Inflector::slug($file_ext[0]) . "." . $file_ext[$file_ext_size - 1];
                // assume filetype is false
                $typeOK = false;
                // check filetype is ok
                foreach ($permitted as $type) {
                    if ($type == $file['type']) {
                        $typeOK = true;
                        break;
                    }
                }
            }
        } else {
            if (!empty($formdata['name'])) {

                $file_ext = explode('.', $formdata['name']);

                $file_ext_size = sizeof($file_ext);

                // replace invalid characters with underscores
                $filename = Inflector::slug($file_ext[0]) . "." . $file_ext[$file_ext_size - 1];


                // assume filetype is false
                $typeOK = false;

                // check filetype is ok
                foreach ($permitted as $type) {

                    if ($type == $formdata['type']) {
                        $typeOK = true;
                        break;
                    }
                }
                $file = $formdata;
            } else {
                $file = $formdata;
            }
        }

        //echo $filename;die;
        // if file type ok upload the file
        if ($typeOK) {
            // switch based on error code
            switch ($file['error']) {

                case 0:

                    //echo $folder_url . $filename . '=====';
                    //echo file_exists($folder_url . $filename);
                    // check filename already exists
                    if (!file_exists($folder_url . $filename)) {
                        // create full filename
                        $full_url = $folder_url . $filename;
                        $url = $rel_url . $filename;
                        // upload the file
                        $success = move_uploaded_file($file['tmp_name'], $url);
                    } else {
                        // create unique filename and upload file
                        ini_set('date.timezone', 'Europe/London');
                        $now = strtotime("now") . "_";
                        $filename = $now . $filename;
                        $full_url = $folder_url . '/' . $filename;
                        $url = $rel_url . $filename;
                        $success = move_uploaded_file($file['tmp_name'], $url);
                    }
                    // if upload was successful
                    if ($success) {
                        // save the url of the file
                        //echo $url;
                        chmod($url, 0777); //exit;
                        $result['urls'][] = $filename;
                    } else {
                        $result['errors'][] = "Error uploaded $filename. Please try again.";
                    }
                    break;
                case 3:
                    // an error occured
                    $result['errors'][] = "Error uploading $filename. Please try again.";
                    break;
                default:
                    // an error occured
                    $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                    break;
            }
        } elseif ($file['error'] == 4) {
            // no file was selected for upload
            $result['nofiles'][] = "No file Selected";
        } else {
            // unacceptable file type
            $result['errors'][] = "$filename cannot be uploaded. Acceptable file types:" . implode(',', $permitted) . "";
        }

        return $result;
    }

    function createDir($dir_path = WWW_ROOT, $dir_names = array()) {

        for ($i = 0; $i < sizeof($dir_names); $i++) {

            $folder_url = WWW_ROOT . $dir_path . DS . $dir_names[$i];

            if (!is_dir($folder_url)) {
                //create dir
                mkdir($folder_url, 01777);
                //change the chmod of medium project directory
                chmod($folder_url, 01777);
            }
        }
    }

    function unlinkFile($file_path) {

        $this->log('in unlink file');

        $path = WWW_ROOT . $file_path;

        $this->log($path);

        if (file_exists($path)) {

            if (unlink($path)) {
                $this->log('in unlink file done');
                return true;
            }
        }
    }

    function download($file, $content_type) {

        if (file_exists($file)) {

            header('Content-Description: File Transfer');
            header("Content-Type: $content_type");
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');

            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));

            ob_clean();
            flush();

            readfile($file);
            exit;
        } else {
            return false;
        }
    }

    function renameMe($name, $rename) {

        $path = 'files/flash/';

        if (file_exists($path . $name)) {

            if (rename($path . $name, $path . $rename)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function deleteMe($file_Folder) {

        if (unlink($file_Folder)) {
            return true;
        } else {
            return false;
        }
    }

    function copydir($source, $destination) {

        if (!is_dir($destination)) {

            $oldumask = umask(0);
            mkdir($destination, 01777); // so you get the sticky bit set
            umask($oldumask);
        }

        $dir_handle = @opendir($source) or die("Unable to open");

        while ($file = readdir($dir_handle)) {

            if ($file != "." && $file != ".." && !is_dir("$source/$file")) {
                copy("$source/$file", "$destination/$file");
                unlink("$source/$file");
            }
        }

        closedir($dir_handle);
    }

    function removedir($dirname) {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    unlink($dirname . "/" . $file);
                else {
                    $a = $dirname . '/' . $file;
                    removedir($a);
                }
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }

    function getImageDimentions($tmpName) {

        list($width, $height, $type, $attr) = getimagesize($tmpName);

        return array('width' => $width, 'height' => $height);
    }

    function __deleteImg($id) {
        $category_data = $this->Category->find('first', array('conditions' => array('Category.id' => $id)));
        $deleteImg = $this->Category->find('all', array('conditions' => array('Category.lft >=' => $category_data['Category']['lft'], 'Category.rght <=' => $category_data['Category']['rght'])));
        foreach ($deleteImg as $deleteData) {
            $this->FileUpload->deleteMe('img/category_image/' . $deleteData['Category']['image']);
        }
    }

}

?>