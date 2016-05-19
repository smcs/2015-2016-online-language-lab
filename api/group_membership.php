<?php

/**
 * GET {language-lab instance url}/api/v1/group_membership?context={LTI context ID}&user={LTI user ID}&group={group ID}[&action={add|delete}]
 */

require_once 'common.inc.php';

requiredParameters([PARAM_CONTEXT, PARAM_USER, PARAM_GROUP]);

$apiResponse = [
    API_USER_ID => $_REQUEST[PARAM_USER],
    API_GROUP_ID => $_REQUEST[PARAM_GROUP]
];

/* default to ACTION_ADD if none (or nonexistent) specified */
switch (trim(strtolower((empty($_REQUEST[PARAM_ACTION]) ? ACTION_ADD : $_REQUEST[PARAM_ACTION])))) {
	case ACTION_DELETE:
        if($_SESSION['app']->sql->query("
            DELETE
                FROM `group_memberships`
                WHERE
                    `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "' AND
                    `user` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_USER]) . "' AND
                    `group` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_GROUP]) . "'
        ") === false) {
            databaseError(__LINE__);
        }
        $apiResponse[API_ACTION_RESULT] = true;
		break;
	case ACTION_ADD:
        // FIXME validate that group ID exists
        if ($_SESSION['app']->sql->query("
            DELETE
                FROM `group_memberships`
                WHERE
                    `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "' AND
                    `user` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_USER]) . "'
        ") == false) {
            databaseError(__LINE__);
        }
        if ($_SESSION['app']->sql->query("
            INSERT
                INTO `group_memberships`
                (
                    `context`,
                    `user`,
                    `group`
                ) VALUES (
                    '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "',
                    '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_USER]) . "',
                    '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_GROUP]) . "'
                )
        ") === false) {
            databaseError(__LINE__);
        }
        $apiResponse[API_MEMBERSHIP_ID] = $_SESSION['app']->sql->insert_id;
	default:
		break;
}

sendResponse($apiResponse);
