/* directives for http://JSLint.com */
/*jslint browser, for, this, white, multivar */
/*global $, OT, console */

var Student = Object.create(LanguageLab);
Student.joinTimeOut = 1000;
Student.makeConnection = function() {
    $(document).ready(function() {
        $.getJSON(Student.rootURL + '/api/v1/join?context=' + Student.context + '&user=' + Student.user, function(response) {
            if (response.sessionId !== undefined) {
                Student.initializeSession(response.apiKey, response.sessionId, response.token);
            } else {
                console.log('Trying again in 1 second');
                window.setTimeout(Student.makeConnection, Student.joinTimeOut);
            }
        });
    });
}
