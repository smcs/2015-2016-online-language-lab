<?php

/**
 * GET {language-lab instance url}/api/v1/groups?context={LTI context ID}[&group={group ID}&action={list|delete|reset}]
 */

require_once 'common.inc.php';

requiredParameters([PARAM_CONTEXT]);

$apiResponse = [];
switch (trim(strtolower((empty($_REQUEST[PARAM_ACTION]) ? ACTION_LIST : $_REQUEST[PARAM_ACTION])))) {
	case ACTION_DELETE:
        requiredParameters([PARAM_GROUP]);
        $apiResponse[API_GROUP_ID] = $_REQUEST[PARAM_GROUP];
        if(($groups = $_SESSION['app']->sql->query("
            SELECT *
                FROM `groups`
                WHERE
                    `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "' AND
                    `id` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_GROUP]) . "'
        ")) === false) {
            databaseError(__LINE__);
        }
        if ($groups->num_rows > 0) {
            $group = $groups->fetch_assoc();
            if ($_SESSION['app']->sql->query("
                DELETE
                    FROM `sessions`
                    WHERE
                        `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "' AND
                        `id` = '{$group['session']}'
            ") === false) {
                databaseError(__LINE__);
            }
            if ($_SESSION['app']->sql->query("
                DELETE
                    FROM `groups`
                    WHERE
                        `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "' AND
                        `id` = '{$group['id']}'
            ") === false) {
                databaseError(__LINE__);
            }
            if ($_SESSION['app']->sql->query("
                DELETE
                    FROM `group_memberships`
                    WHERE
                        `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "' AND
                        `group` = '{$group['id']}'
            ") === false) {
                databaseError(__LINE__);
            }
            $apiResponse[API_ACTION_RESULT] = true;
        } else {
            $apiResponse[API_ACTION_RESULT] = false;
        }
		break;
    case ACTION_RESET:
        if ($_SESSION['app']->sql->query("
            DELETE
                FROM `sessions`
                WHERE
                    `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "' AND
                    `type` = '" . TYPE_GROUP . "'
        ") === false) {
            databaseError(__LINE__);
        }
        if ($_SESSION['app']->sql->query("
            DELETE
                FROM `groups`
                WHERE
                    `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "'
        ") === false) {
            databaseError(__LINE__);
        }
        if ($_SESSION['app']->sql->query("
            DELETE
                FROM `group_memberships`
                WHERE
                    `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "'
        ") === false) {
            databaseError(__LINE__);
        }
        $apiResponse[API_ACTION_RESULT] = true;
        break;
	case ACTION_LIST:
	default:
        if (($existingGroups = $_SESSION['app']->sql->query("
            SELECT g.`id`, s.`tokbox`
                FROM `groups` AS g
					LEFT JOIN `sessions` AS s
						ON g.`session` = s.`id`
                WHERE
                    `context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "'
                ORDER BY
                    g.`id` ASC
        ")) === false) {
            databaseError(__LINE__);
        }
        while ($group = $existingGroups->fetch_assoc()) {
            $apiResponse['groups'][] = [
				'group' => $group['id'],
				'session' => $group['tokbox']
			];
        }
		break;
}

sendResponse($apiResponse);
