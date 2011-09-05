<?php

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @subpackage    cake.cake.libs.model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model
 */
class AppModel extends Model {

    /**
     * create hash of given length
     * @author Vijay Kumbhar <kvijay@weboniselab.com>
     * @param $length int : length of output string
     * @param $hash_type string : hashing function to be used
     *
     * @return $hash string : output hash
     */
    function create_hash($lenth = 6, $hash_type = null) {

        // makes a random alpha numeric string of a given lenth
        $aZ09 = array_merge(range(0, 9), range(0, 9), range(0, 9));
        $out = '';

        for ($c = 0; $c < $lenth; $c++) {
            $out .= $aZ09[mt_rand(0, count($aZ09) - 1)];
        }

        if ($hash_type) {
            $hash = $hash_type($out);
        } else {
            $hash = $out;
        }

        return $hash;
    }
}
