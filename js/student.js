/* directives for http://JSLint.com */
/*jslint browser, for, this, white, multivar */
/*global $, OT, console */

var Student = Object.create(LanguageLab);

Student.joinTimeOut = 1000;

Student.makeConnection = function() {
    $(document).ready(function() {
        $.getJSON(Student.rootURL + '/api/v1/join?context=' + Student.context + '&user=' + Student.user, function(response) {
            if (response.session_id !== undefined) {
                $('#' + Student.thumbnailContainerID + '-placeholder').remove();
                Student.initializeSession(response.api_key, response.session_id, response.token);
            } else {
                window.setTimeout(Student.makeConnection, Student.joinTimeOut);
            }
        });
    });
}
