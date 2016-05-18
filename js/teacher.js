/* directives for http://JSLint.com */
/*jslint browser, for, this, white, multivar */
/*global $, OT, console */

var Teacher = Object.create(LanguageLab);
Teacher.makeConnection = function() {
    $(document).ready(function() {
        $.getJSON(Teacher.rootURL + '/api/v1/session?context=' + Teacher.context + '&user=' + Teacher.user, function(response) {
            Teacher.initializeSession(response.api_key, response.session_id, response.token);
        });
    });
}
