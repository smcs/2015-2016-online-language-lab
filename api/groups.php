<?php

/**
 * GET {language-lab instance url}/api/v1/groups?context={LTI context ID}[&group={group ID}&action={list|delete|reset}]
 */

require_once 'common.inc.php';

use OpenTok\Role;

requiredParameters([PARAM_CONTEXT, PARAM_USER, PARAM_USER_NAME]);

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
                    g.`context` = '" . $_SESSION['app']->sql->escape_string($_REQUEST[PARAM_CONTEXT]) . "'
                ORDER BY
                    g.`id` ASC
        ")) === false) {
            databaseError(__LINE__);
        }
        while ($group = $existingGroups->fetch_assoc()) {
            $apiResponse['groups'][] = [
				API_KEY => $_SESSION['app']->config->toString('//tokbox/key'),
				API_GROUP_ID => $group['id'],
				API_SESSION_ID => $group['tokbox'],
				API_SESSION_TOKEN => $_SESSION['app']->opentok->generateToken(
			        $group['tokbox'],
			        [
			            'role' => Role::MODERATOR,
			            'data' => json_encode([
			                'context' => $_REQUEST[PARAM_CONTEXT],
			                'user' => $_REQUEST[PARAM_USER],
			                'user_name' => $_REQUEST[PARAM_USER_NAME]
			            ])
			        ]
			    )
			];
        }
		break;
}

sendResponse($apiResponse);
