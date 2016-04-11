/* get credentials from server */
$(document).ready(function() {
	$.getJSON('https://area51.stmarksschool.org/sandbox/smtech/language-lab/api/v1/session?id=' + id, function(response) {
		initializeSession(response.apiKey, response.sessionId, response.token);
	});
});

function initializeSession(apiKey, sessionId, token) {

	/* create a new OpenTok session */
	var session = OT.initSession(apiKey, sessionId);

	/* define event-driven session behaviors */
	
	session.on('streamCreated', function(event) {
		session.subscribe(event.stream, 'subscriber', {
			insertMode: 'append',
			width: '100%',
			height: '100%'
		});
	});
	
	session.on('sessionDisconeected', function(event) {
		console.log('You were disconnected from the session. ', event.reason);
	});
	
	/* connect to the session */
	session.connect(token, function(error) {
		if (!error) {
			var publisher = OT.initPublisher('publisher', {
				insertMode: 'appendMode',
				width: '100%',
				height: '100%'
			});
			session.publish(publisher);
		} else {
			console.log('There was an error connection to the session: ', error.code, error.message);
		}
	});
}