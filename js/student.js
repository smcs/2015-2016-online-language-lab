/* directives for http://JSLint.com */
/*jslint browser:true, white: true */
/*global $, OT, console, LanguageLab */

var Student = Object.create(LanguageLab);

Student.joinTimeOut = 1000;

Student.joinSession = function() {
    "use strict";
    $.getJSON(Student.rootURL + '/api/join.php?context=' + Student.context + '&user=' + Student.user + '&user_name=' + Student.userName, function(response) {
        if (response.session_id !== undefined) {
            $('#' + Student.thumbnailContainerID + '-placeholder').remove();
            Student.initializeSession(response.api_key, response.session_id, response.token);
        } else {
            window.setTimeout(Student.makeConnection, Student.joinTimeOut);
        }
    });
};

Student.initializeSession = function(apiKey, sessionId, token) {
    "use strict";
    this.__proto__.initializeSession(apiKey, sessionId, token);
    /* FIXME I think this works okay, but I'm worried that it may rely on too many assumptions */
    console.log(this);
    this.sessions[(this.sessions.length > 0 ? this.sessions.length - 1 : 'ot-streams')].on('sessionDisconeected', function(event) {
        console.log('Disconnected. Cleaning up and rejoining.');
        $('#' + Student.thumbnailContainerID).empty();
        Student.sessions = [];
        Student.publishedStreams = [];
        Student.streams = [];
        Student.joinSession();
    });
};

Student.makeConnection = function() {
    "use strict";
    $(document).ready(this.joinSession());
};
