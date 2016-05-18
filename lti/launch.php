<?php

/* clear any existing session data */
if (session_status() === PHP_SESSION_ACTIVE) {
	session_destroy();
}
define('LAUNCHING_LTI', true);

require_once 'common.inc.php';

use smcs\language_lab\LanguageLabLTI;

/* set up a Tool Provider (TP) object to process the LTI request */
$toolProvider = new LanguageLabLTI(LTI_Data_Connector::getDataConnector($sql));
$toolProvider->setParameterConstraint('oauth_consumer_key', TRUE, 50);
$toolProvider->setParameterConstraint('resource_link_id', TRUE, 50, array('basic-lti-launch-request'));
$toolProvider->setParameterConstraint('user_id', TRUE, 50, array('basic-lti-launch-request'));
$toolProvider->setParameterConstraint('roles', TRUE, NULL, array('basic-lti-launch-request'));

/* process the LTI request from the Tool Consumer (TC) */
$toolProvider->handle_request();
exit;
