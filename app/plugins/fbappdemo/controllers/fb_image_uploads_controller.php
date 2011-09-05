<?php

class FbImageUploadsController extends FbappdemoAppController {

    var $name = 'FbImageUploads';
    var $facebook = null;
    var $Fbsession = null;
    function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow('*');
        App::import('Vendor', 'facebook', array('file' => 'facebook.php'));
        // Create our Application instance (replace this with your appId and secret).
        $this->facebook = new Facebook(array(
                    'appId' => '147442695329648', //
                    'secret' => 'afe006a0a4efd92bf5a84b0f83888ffe',
                    'cookie' => true,
        ));
        $this->Fbsession =  $this->facebook->getSession();
    }

    function index() {
        
        $signed_request = $this->facebook->getSignedRequest();
        if (isset($signed_request['page']) && $signed_request['page']['liked'] == '1' && $signed_request['page']['id'] == '112999125469267') {
            
            $pagelikeid = '1';
        } else {
            $pagelikeid = '0';
        }
        $this->set(compact('pagelikeid'));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid fb image upload', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('fbImageUpload', $this->FbImageUpload->read(null, $id));
    }

    function add() {

        if (!empty($this->data)) {
            $filedata = $this->data['FbImageUpload']['image_name'];

            if ($filedata['error'] == '0' && $this->__checkHeightAndWidth($filedata['tmp_name'])) {

                $file = $this->upload_file($filedata, 'img/contest/image_gallery/');

                if (isset($file['urls']['0']) || isset($file['nofiles']['0'])) {

                    if (isset($file['urls']['0'])) {
                        $image = $this->ImageMagick->resize('img/contest/image_gallery/' . $file['urls']['0'], '50', '50', $tag = true, 'img/contest/image_gallery/50x50', $quality = 100, $aspect = true, $file['urls']['0']);
                        $image1 = $this->ImageMagick->resize('img/contest/image_gallery/' . $file['urls']['0'], '150', '150', $tag = true, 'img/contest/image_gallery/150x150', $quality = 100, $aspect = true, $file['urls']['0']);
                        $image2 = $this->ImageMagick->resize('img/contest/image_gallery/' . $file['urls']['0'], '500', '500', $tag = true, 'img/contest/image_gallery/500x500', $quality = 100, $aspect = true, $file['urls']['0']);
                        $this->data['FbImageUpload']['image_name'] = $file['urls']['0'];
                        $this->FbImageUpload->create();
                        if ($this->FbImageUpload->save($this->data)) {
                            $this->Session->setFlash(__('The fb image upload has been saved', true));
                            $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Session->setFlash(__('The fb image upload could not be saved. Please, try again.', true));
                        }
                    } else {
                        $this->Session->setFlash(__('Unable to upload file.', true));
                    }
                } else {
                    $this->Session->setFlash(__('Unable to upload file in selected destination.', true));
                }
            } else {
                $this->Session->setFlash(__('Please select image to upload.', true));
            }
        }

        
       
        $me = null;
        $this->log('Session is ====== ');
        $this->log($this->Fbsession);
        //pr($session);
       // die;
        // Session based API call.
        if (!empty($this->Fbsession)) {

            try {
                $me = $this->facebook->api('/me');
                //if user clicks on cancel then user
                //should be redirected to the home page
                
                if (empty($me)) {
                    $user_id = '';
                    $email = '';
                    $name = '';
                    $pagelikeid = '1';
                } else {

                    //check user present & login him
                    $user_id = $me['id'];
                    $name = $me['name'];
                    if (isset($me['email'])) {
                        $email = $me['email'];
                    }
                    $pagelikeid = '1';
                }
                $this->log($me);
                $this->set(compact('user_id', 'email', 'name'));
            } catch (FacebookApiException $e) {

                $this->nextUrl = FULL_BASE_URL . '/fbappdemo/fb_image_uploads/add';
                $this->cancelUrl = FULL_BASE_URL . '/fbappdemo/fb_image_uploads/cancel';
                $url = $this->facebook->getLoginUrl(array(
                            'req_perms' => 'user_birthday,email,read_stream,share_item,publish_stream,offline_access', //
                            'next' => "http://www.facebook.com/pages/My-first-page/112999125469267?sk=app_147442695329648",
                            'cancel_url' => "http://www.facebook.com/pages/My-first-page/112999125469267?sk=app_147442695329648",
                            'display' => 'popup'
                        ));
                echo "<script type='text/javascript'>top.location.href = '$url';</script>";
            }
        } else {

            $this->nextUrl = FULL_BASE_URL . '/fbappdemo/fb_image_uploads/add';
            $this->cancelUrl = FULL_BASE_URL . '/fbappdemo/fb_image_uploads/cancel';
            $url = $this->facebook->getLoginUrl(array(
                        'req_perms' => 'user_birthday,email,read_stream,share_item,publish_stream,offline_access', //
                        'next' => "http://www.facebook.com/pages/My-first-page/112999125469267?sk=app_147442695329648",
                        'cancel_url' => "http://www.facebook.com/pages/My-first-page/112999125469267?sk=app_147442695329648",
                        'display' => 'popup'
                    ));
            echo ('<script type="text/javascript">top.location.href=\'' . $url . '\';</script>');
        }
    }

    function cancel() {
        echo "hello";
        die;
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid fb image upload', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->FbImageUpload->save($this->data)) {
                $this->Session->setFlash(__('The fb image upload has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The fb image upload could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->FbImageUpload->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for fb image upload', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->FbImageUpload->delete($id)) {
            $this->Session->setFlash(__('Fb image upload deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Fb image upload was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * function to check Height and Width of image
     * @author madhavi ghadge <madhavi@weboniselab.com>
     * @param mixed $value
     * @return boolean on success
     */
    function __checkHeightAndWidth($value) {

        list($width, $height, $type, $attr) = getimagesize($value);

        if ($width < 500 || $height < 500) {
            return false;
        } else {
            return true;
        }
    }

}

?>