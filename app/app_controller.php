<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {

    var $components = array('Auth', 'FileUpload', 'ImageMagick', 'UploadResize', 'Session', 'RequestHandler', 'SwiftMailer');
    // 'AutoLogin','UploadResize'

    
    var $siteSettings;
    var $userId;
   

    function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->autoRedirect = false;
        
        $this->Auth->loginAction = array('plugin' => false, 'controller' => 'users', 'action' => 'login');

        $this->Auth->loginRedirect = array('plugin' => false,'controller' => 'users', 'action' => 'dashboard');

            //logout
        $this->Auth->logoutRedirect = array('plugin' => false, 'controller' => 'users', 'action' => 'home');
       
//        $this->log('Auth values ======');
//        $this->log('Auth Login action ===');
//        $this->log($this->Auth->loginAction);
//        $this->log('Auth loginRedirect action ===');
//        $this->log($this->Auth->loginAction);
//        $this->log('Auth logoutRedirect action ===');
//        $this->log($this->Auth->logoutRedirect);

        $this->Auth->userScope = array('User.is_active' => '1');

        //auth errors  //add it
        $this->Auth->loginError = "Invalid username or password";
        $this->Auth->authError = "Sorry, you must be logged in to visit these pages";

        $this->siteSettings = $this->Session->read('Setting');

    }

    function beforeRender() {

        parent::beforeRender();
       
    }

    
    function send_SMTP_mail($data = array(), $messageData = null) {

        $this->SwiftMailer->from = $data['from'];
        $this->SwiftMailer->fromName = $data['fromName'];
        $this->SwiftMailer->to = $data['to'];
        $this->SwiftMailer->toName = $data['toName'];

        $this->set('data', $messageData);

        //pr($this->SwiftMailer->send($data['template'], $data['subject']));

        if ($data['from'] == null) {

            return false;
        } elseif ($data['to'] == null) {

            return false;
        } elseif ($data['subject'] == null) {

            return false;
        } elseif (!$this->SwiftMailer->send($data['template'], $data['subject'])) {

            $this->log('Error sending email "$template".', LOG_ERROR);

            return false;
        } else {

            return true;
        }
    }

    /**
     *
     * @param string $file
     * @param string $target
     * @param mixed $settings
     * @return string
     */
    function upload_file($file = null, $target = null, $settings = array()) {

        $result['nofiles']['0'] = 'no file';

        if ($file['name'] != '' && $file['error'] == 0 && $file['size'] > 0) {
            $_settings = array(
                'itemId' => '',
                'permitted' => array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png'),
            );

            if (!empty($settings)) {
                $_settings = array_merge($_settings, $settings);
            }

            $result = $this->FileUpload->uploadFiles($target, $file, $_settings['itemId'], $_settings['permitted']);
        } elseif ($file['size'] == 0) {
            $result['nofiles']['0'] = 'Empty File';
        }
        return $result;
    }

}
