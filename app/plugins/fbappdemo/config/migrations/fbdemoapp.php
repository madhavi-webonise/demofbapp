<?php
class M4e648e3d5a244ab3bfcb0b0417aa370f extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	var $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	var $migration = array(
		'up' => array(
			'create_table' => array(
				'fb_image_upload' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'uploader_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'name' => array('type' => 'string', 'length ' => '255','null' => false, 'default' => NULL),
                                        'email' => array('type' => 'string', 'length ' => '255','null' => false, 'default' => NULL),
                                        'image_name' => array('type' => 'string', 'length ' => '255', 'null' => false, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				 'fb_image_upload'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	function after($direction) {
		return true;
	}
}
?>