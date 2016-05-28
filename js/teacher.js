/* directives for http://JSLint.com */
/*jslint devel: true, browser: true, white: true */
/*global $, OT, console, LanguageLab */

var Teacher = Object.create(LanguageLab);

Teacher.groupContainerID = 'groups';

Teacher.makeConnection = function () {
    "use strict";
    $(document).ready(function () {
        var i;
        $.getJSON(Teacher.rootURL + '/api/groups.php?context=' + Teacher.context + '&user=' + Teacher.user + '&user_name=' + Teacher.userName, function (response) {
            if (response.groups !== undefined) {
                for (i = 0; i < response.groups.length; i = i + 1) {
                    Teacher.displayGroup(response.groups[i].group);
                    Teacher.initializeSession(
                        response.groups[i].api_key,
                        response.groups[i].session_id,
                        response.groups[i].token,
                        response.groups[i].group
                    );
                }
            }
        });
        $.getJSON(Teacher.rootURL + '/api/session.php?context=' + Teacher.context + '&user=' + Teacher.user + '&user_name=' + Teacher.userName, function (response) {
            Teacher.initializeSession(
                response.api_key,
                response.session_id,
                response.token
            );
        });
    });
};

Teacher.displayGroup = function (id) {
    "use strict";
    $('#' + Teacher.groupContainerID).append(
        '<div id="wrapper-' + id + '" class="droppable">' +
            '<p class="label label-info">' +
                'Group ' + id + ' ' +
                '<a href="javascript:Teacher.deleteGroup(' + id + ');"><span class="glyphicon glyphicon-remove"></span></a>' +
            '</p>' +
            '<ul id="' + id + '" class="connected"></ul>' +
        '</div>'
        );

        $('.connected').sortable({
            connectWith: '.connected',
            opacity: 0.5,
            placeholder: 'placeholder col-xs-4',
            update: Teacher.sortableUpdate
        });
};

Teacher.sortableUpdate = function(event, ui) {
    "use strict";
    console.log(Teacher);

    /*
     * using the 'receive callback' -- won't trigger if position
     * within list is changed only if the list it is in changes
     * (cf. https://forum.jquery.com/topic/sortables-update-callback-and-connectwith#14737000000631169)
     */
    if (this !== ui.item.parent()[0]) {
        /* handle event for new list */

        var thumbnail = $(ui.item[0]).find('embed-responsive-item'),
            sourceGroupID = $(this).attr('id'),
            destinationGroupID = $(ui.item.parent()[0].attr('id')),
            user = thumbnail.attr('user');

        /* update group memberships via API */
        if (destinationGroupID === Teacher.thumbnailContainerID) {
            $.getJSON(Teacher.rootURL + '/api/group_membership.php?context=' + Teacher.context + '&user=' + user + '&action=reset');
        } else {
            $.getJSON(Teacher.rootURL + '/api/group_membership.php?context=' + Teacher.context + '&user=' + user + '&group=' + destinationGroupID);
        }

        /* locally disconnect dragged user from source group, forcing a reconnect */
        Teacher.sessions[sourceGroupID].forceUnpublish(Teacher.streams[sourceGroupID][thumbnail.attr('stream_id')], function() {
            console.log('Disconnected a ' + user + ' from ' + sourceGroupID);
        });
    }
};

Teacher.postInitializeSession = function() {
    "use strict";
};

Teacher.addGroup = function() {
    "use strict";
    $.getJSON(Teacher.rootURL + '/api/session.php?context=' + Teacher.context + '&user=' + Teacher.user + '&user_name=' + Teacher.userName + '&type=group', function(response) {
        Teacher.displayGroup(response.group);
    });
};

Teacher.deleteGroup = function (id) {
    "use strict";
    $.getJSON(Teacher.rootURL + '/api/groups.php?context=' + Teacher.context + '&group=' + id + '&action=delete', function(response) {
        if (response.result) {
            $('#wrapper-' + id).remove();
        } else {
            alert('Error!');
        }
    });
};

Teacher.resetGroups = function() {
    "use strict";
    // TODO make list of users and OpenTok sessions affected
    $.getJSON(Teacher.rootURL + '/api/groups.php?context=' + Teacher.context + '&action=reset', function (response) {
        if (response.result) {
            $('#' + Teacher.groupContainerID).empty();
        } else {
            alert('Error!');
        }
    });
    // TODO disconnect users from their (now deleted) OpenTok sessions, forcing them to reconnect to the class session
};
