<?php

// No direct access
defined( '_JEXEC' ) or die;

require_once( dirname( __FILE__ ) . '/helper.php' );
$compare = modTmboxHelper::getData( $params );
$wishlist = modTmboxHelper::getData2( $params );
$tmbox = (bool)$params->get( 'tmbox', 1 );

$moduleclass_sfx = htmlspecialchars( $params->get( 'moduleclass_sfx' ) );
require( JModuleHelper::getLayoutPath( 'mod_tmbox', $params->get( 'layout', 'default' ) ) );