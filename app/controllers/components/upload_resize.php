<?php

App::import('Component', 'FileUpload');

App::import('Component', 'ImageResize');

/**
 * Description of upload_resize
 *
 * @author vijay
 */
class UploadResizeComponent extends Object {

    var $controller;
    var $permitted = array('image/png', 'application/png', 'application/x-png',
        'image/gif', 'image/x-xbitmap', 'image/gi_',
        'image/jpeg', 'image/jpg', 'image/jp_', 'application/jpg',
        'application/x-jpg', 'image/pjpeg', 'image/pipeg', 'image/vnd.swiftview-jpeg', 'image/x-xbitmap',
        'image/jpeg', 'image/jpg', 'image/jpe_', 'image/pjpeg', 'image/vnd.swiftview-jpeg');

    function initialize(&$controller, $settings = array()) {
        // saving the controller reference for later use
        $this->controller = & $controller;

        $this->FileUpload = new FileUploadComponent();

        $this->ImageMagick = new ImageMagickComponent();
    }

    function upload_resize($file, $destination, $width=100, $height=100, $quality=100, $cachePath=null, $tag =true, $aspect=true, $image_name = null, $field = null, $model = null) {

        if (!empty($file) && $file['error'] == 0 && $file['size'] > 0) {
            //upload it
            $image = $this->FileUpload->uploadFiles($destination, $file, null, $this->permitted, false);

            if($image_name == null){
                $image_name = $image['urls']['0'];
            }

            //resize it
            $imageIs = $this->ImageMagick->resize($destination . $image['urls']['0'], $width, $height, $tag, $destination.DS.$cachePath, $quality, $aspect, $image_name);
            
            if($field && !$model){
                $this->controller->data[$this->controller->modelClass][$field] = $imageIs;
                return true;
            }elseif($field && $model){
                $this->controller->data[$model][$field] = $imageIs;
                return true;
            }else{
                return $imageIs;
            }
            
        } elseif ($file['size'] == 0) {
            return false;
        }
    }

}