<?php
/**
 * Configuration Should be Written In a single file
 * @global array $GLOBALS['fbconfig']
 * @name $fbconfig
 * @author Mahmud Ahsan
 */
$fbconfig['appid' ] = "147442695329648";
$fbconfig['api'   ] = "";
$fbconfig['secret'] = "afe006a0a4efd92bf5a84b0f83888ffe";

$fbconfig['baseUrl']    =   "http://thinkdiff.net/demo/newfbconnect1/iframe/iadvance_sdk3";
$fbconfig['appBaseUrl'] =   "http://apps.facebook.com/crushaider";
$fbconfig['pageUrl']    =   "http://www.facebook.com/pages/My-first-page/112999125469267";
$fbconfig['appPageUrl'] =   "{$fbconfig['pageUrl']}?sk=app_{$fbconfig['appid' ]}";

$tutorialLink           =   "<a href='http://thinkdiff.net/facebook/iadvance-graph-api-iframe-base-facebook-page-app-development' target='_blank'>Tutorial: iAdvance - Graph API & Iframe base Facebook Page App Development</a>";

?>