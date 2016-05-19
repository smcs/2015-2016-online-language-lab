/* directives for http://JSLint.com */
/*jslint browser, for, this, white, multivar */
/*global $, OT, console */

var Teacher = Object.create(LanguageLab);

Teacher.groupContainerID = 'groups';

Teacher.makeConnection = function() {
    $(document).ready(function() {
        $.getJSON(Teacher.rootURL + '/api/v1/groups?context=' + Teacher.context, function(response) {
            for(var i = 0; i < response.groups.length; i++) {
                Teacher.displayGroup(response.groups[i].group);
            }
        });
        $.getJSON(Teacher.rootURL + '/api/v1/session?context=' + Teacher.context + '&user=' + Teacher.user, function(response) {
            Teacher.initializeSession(response.api_key, response.session_id, response.token);
        });
    });
}

Teacher.displayGroup = function(id) {
    $('#' + Teacher.groupContainerID).append('<div id="wrapper-' + id + '" class="container container-fluid group">' +
            '<p class="droppable-label">Group ' + id + ' <span class="pull-right"><a href="javascript:Teacher.deleteGroup(' + id + ');"><span class="glyphicon glyphicon-remove"></span></a></span></p>' +
            '<ul id="' + id + '" class="droppable connected"></ul>' +
        '</div>'
        );
        $('.connected').sortable({
            connectWith: '.connected',
            placeholder: 'draggable-placeholder',
            update: function(event, ui) {
                /*
                 * using the 'receive callback' -- won't trigger if position
                 * within list is changed only if the list it is in changes
                 * (cf. https://forum.jquery.com/topic/sortables-update-callback-and-connectwith#14737000000631169)
                 */
                if (this === ui.item.parent()[0]) {
                    console.log($(ui.item[0]).parent().attr('id'));
                }
            }
        });
}

Teacher.addGroup = function() {
    $.getJSON(Teacher.rootURL + '/api/v1/session?context=' + Teacher.context + '&user=' + Teacher.user + '&type=group', function(response) {
        Teacher.displayGroup(response.group);
    });
}

Teacher.deleteGroup = function (id) {
    $.getJSON(Teacher.rootURL + '/api/v1/groups?context=' + Teacher.context + '&group=' + id + '&action=delete', function(response) {
        if (response.result) {
            $('#wrapper-' + id).remove();
        } else {
            alert('Error!');
        }
    });
}

Teacher.resetGroups = function() {
    $.getJSON(Teacher.rootURL + '/api/v1/groups?context=' + Teacher.context + '&action=reset', function (response) {
        if (response.result) {
            $('#' + Teacher.groupContainerID).empty();
        } else {
            alert('Error!');
        }
    });
}
