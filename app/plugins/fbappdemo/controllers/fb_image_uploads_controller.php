<?php

class FbImageUploadsController extends FbappdemoAppController {

    var $name = 'FbImageUploads';
    var $facebook = null;
    var $Fbsession = null;

    function beforeFilter() {

        parent::beforeFilter();

        $this->Fbsession = $this->facebook->getSession();
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

                $filesize = 2097152; //2MB

                if($this->checkFileSize($filedata['tmp_name'],$filesize)){


                $file = $this->upload_file($filedata, 'img/contest/image_gallery/');

                if (isset($file['urls']['0']) || isset($file['nofiles']['0'])) {

                    if (isset($file['urls']['0'])) {
                        $image = $this->ImageMagick->resize('img/contest/image_gallery/' . $file['urls']['0'], '50', '50', $tag = true, 'img/contest/image_gallery/50x50', $quality = 100, $aspect = true, $file['urls']['0']);
                        $image1 = $this->ImageMagick->resize('img/contest/image_gallery/' . $file['urls']['0'], '150', '150', $tag = true, 'img/contest/image_gallery/150x150', $quality = 100, $aspect = true, $file['urls']['0']);
                        $image2 = $this->ImageMagick->resize('img/contest/image_gallery/' . $file['urls']['0'], '500', '500', $tag = true, 'img/contest/image_gallery/500x500', $quality = 100, $aspect = true, $file['urls']['0']);
                        $this->data['FbImageUpload']['image_name'] = $file['urls']['0'];
                        $this->FbImageUpload->create();
                        if ($this->FbImageUpload->save($this->data)) {

                            $attachment = array(
                                'message' => '',
                                'name' => 'Social Photo Contest',
                                'caption' => "Social Photo Contest",
                                'link' => $this->nextUrl,
                                'description' => $this->data['FbImageUpload']['name'] . ' Uploaded new photo in social contest',
                                'picture' => FULL_BASE_URL . '/img/contest/image_gallery/150x150/' . $file['urls']['0'],
                                'actions' => array(array('name' => 'Start Using',
                                        'link' => $this->nextUrl))
                            );
                            try {

                                $result = $this->facebook->api('/me/feed/', 'post', $attachment);
                                if (!empty($result)) {
                                    $this->Session->setFlash(__('The fb image upload has been saved and published on your wall', true));
                                } else {
                                    $this->Session->setFlash(__('The fb image upload has been saved. but unable to publish on your wall', true));
                                }
                            } catch (FacebookApiException $e) {
                                $this->Session->setFlash(__('The fb image upload has been saved. but unable to publish on your wall', true));
                            }

                            $this->redirect(array('action' => 'successmessage'));
                        } else {
                            $this->Session->setFlash(__('The fb image upload could not be saved. Please, try again.', true));
                        }
                    } else {
                        $this->Session->setFlash(__('Unable to upload file.', true));
                    }
                } else {
                    $this->Session->setFlash(__('Unable to upload file in selected destination.', true));
                }
              }else{
                    $this->Session->setFlash(__('Please select file with maximum 2 MB size.', true));
                }
            } else {
                $this->Session->setFlash(__('Please select image to with minimum 500x500 heigh and width and maximum 2MB size.', true));
            }
        }

        $me = null;
        $this->log('Session is ====== ');
        $this->log($this->Fbsession);

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
                } else {

                    //check user present & login him
                    $user_id = $me['id'];
                    $name = $me['name'];
                    if (isset($me['email'])) {
                        $email = $me['email'];
                    } else {
                        $email = '';
                    }
                }
                $this->log($me);
                $this->set(compact('user_id', 'email', 'name'));
            } catch (FacebookApiException $e) {

                $url = $this->facebook->getLoginUrl(array(
                            'req_perms' => 'user_birthday,email,read_stream,share_item,publish_stream,offline_access', //
                            'next' => $this->nextUrl,
                            'cancel_url' => $this->cancelUrl,
                            'display' => 'popup'
                        ));
                echo "<script type='text/javascript'>top.location.href = '$url';</script>";
            }
        } else {

            $url = $this->facebook->getLoginUrl(array(
                        'req_perms' => 'user_birthday,email,read_stream,share_item,publish_stream,offline_access', //
                        'next' => $this->nextUrl,
                        'cancel_url' => $this->cancelUrl,
                        'display' => 'popup'
                    ));
            echo ('<script type="text/javascript">top.location.href=\'' . $url . '\';</script>');
        }
    }

    function successmessage() {
        
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

    function checkFileSize($data, $fileSize=NULL) {

        if (!empty($fileSize)) {
            $getFileSize = filesize($data);//  $data['size'] / 1024;
            
            if ($getFileSize <= $fileSize) {
                return true;
            }else{
               return false;
            }
        }
    }

}

?>