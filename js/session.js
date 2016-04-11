/* get credentials from server */
$(document).ready(function() {
	$.getJSON('https://area51.stmarksschool.org/sandbox/smtech/language-lab/api/v1/session?id=' + id, function(response) {
		initializeSession(response.apiKey, response.sessionId, response.token);
	});
});

function appendToCarousel(session, stream = false) {
	var options = {
		insertMode: 'append',
		width: '100%',
		height: '100%'
	};
	$('#carousel').append('<div class="carousel-item col-sm-2"><div class="embed-responsive embed-responsive-4by3"><div id="carousel-' + (stream == false ? 'publisher' : stream.streamId) + '" class="embed-responsive-item"></div></div></div>');
	if (stream == false) {
		var publisher = OT.initPublisher('carousel-publisher', options);
		session.publish(publisher);
		publishedStreamId = publisher.streamId;
	} else if(stream != null) {
		session.subscribe(stream, 'carousel-' + stream.streamId, options);
	}
}

function initializeSession(apiKey, sessionId, token) {

	/* create a new OpenTok session */
	var session = OT.initSession(apiKey, sessionId);

	/* define event-driven session behaviors */
	
	session.on('streamCreated', function(event) {
		if (event.stream.streamId != publishedStreamId) {
			appendToCarousel(session, event.stream);
		}
	});
	
	session.on('streamDestroyed', function(event) {
		$('.carousel-item:has(#carousel-' + event.stream.streamId + ')').remove();
	});
	
	session.on('sessionDisconeected', function(event) {
		console.log('You were disconnected from the session. ', event.reason);
	});
	
	/* connect to the session */
	session.connect(token, function(error) {
		if (!error) {
			appendToCarousel(session);
		} else {
			console.log('There was an error connecting to the session: ', error.code, error.message);
		}
	});
}