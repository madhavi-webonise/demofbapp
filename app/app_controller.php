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
App::import('Vendor', 'facebook/facebook');

class AppController extends Controller {

    var $components = array( 'FileUpload', 'ImageMagick', 'UploadResize', 'Session', 'RequestHandler', 'SwiftMailer');
    // 'AutoLogin','UploadResize'
    var $siteSettings;
    var $userId;

    function __construct() {

        parent::__construct();

        //define('DEV_ENV', 'local'); //if you are running the app on your local machine
        define('DEV_ENV', 'local'); //if you are running the app on server
        //check m on server env or on local env
        if (DEV_ENV == 'local') {

            $this->fbAPPID = '256084077759022';
            $this->fbAPISecret = '1fd798aae463a630d91b397d3067f63f';
            $this->baseUrl    =   "http://thinkdiff.net/demo/newfbconnect1/iframe/iadvance_sdk3";
            $this->appBaseUrl =   "http://apps.facebook.com/crushaider";
            $this->pageUrl   =   "http://www.facebook.com/pages/My-first-page/112999125469267";
            $this->appPageUrl =   "{$this->pageUrl}?sk=app_{$this->fbAPPID}";

            //$this->appAdminUserId = '100000002702602';

            $this->nextUrl = $this->appPageUrl; // you have to specify your app link
            $this->cancelUrl = $this->appPageUrl;
            
        } else {

            $this->fbAPPID = '164164896978945'; //'156993587649685';
            $this->fbAPISecret = '5e15a0247e61af4289d9ce55d4218214'; //'edbbf71d9e0767f1dd96ed54f269e7f2';

            $this->baseUrl    =   "http://thinkdiff.net/demo/newfbconnect1/iframe/iadvance_sdk3";
            $this->appBaseUrl =   "http://apps.facebook.com/crushaider";
            $this->pageUrl   =   "http://www.facebook.com/pages/My-first-page/112999125469267";
            $this->appPageUrl =   "{$this->pageUrl}?sk=app_{$this->fbAPPID}";

            $this->nextUrl = $this->appPageUrl; // you have to specify your app link
            $this->cancelUrl = $this->appPageUrl;
        }

        // Create our Application instance (replace this with your appId and secret).
        $this->facebook = new Facebook(array(
                    'appId' => $this->fbAPPID, //
                    'secret' => $this->fbAPISecret,
                    'cookie' => true,
        ));

    }

    function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->autoRedirect = false;
        
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
