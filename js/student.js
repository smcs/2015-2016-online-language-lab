/* directives for http://JSLint.com */
/*jslint browser, for, this, white, multivar */
/*global $, OT, console */

var Student = Object.create(LanguageLab);

Student.joinTimeOut = 1000;

Student.joinSession = function() {
    $.getJSON(Student.rootURL + '/api/join.php?context=' + Student.context + '&user=' + Student.user + '&user_name=' + Student.userName, function(response) {
        if (response.session_id !== undefined) {
            $('#' + Student.thumbnailContainerID + '-placeholder').remove();
            Student.initializeSession(response.api_key, response.session_id, response.token);
        } else {
            window.setTimeout(Student.makeConnection, Student.joinTimeOut);
        }
    });
}

Student.initializeSession = function(apiKey, sessionId, token) {
    this.proto.initializeSession(apiKey, sessionId, token);
    this.session.on('sessionDisconeected', function(event) {
        // TODO there may be some clean up that we need to do here too!
        this.joinSession();
    });
}

Student.makeConnection = function() {
    $(document).ready(this.joinSession());
}
