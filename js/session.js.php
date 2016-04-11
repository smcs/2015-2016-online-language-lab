<?php

header('Content-type: text/javascript');
	
?>

/* get credentials from server */
$(document).ready(function() {
	$.getJSON('<?= (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ?
		'http://' :
		'https://'
	) .
	$_SERVER['SERVER_NAME'] .
	$_SERVER['CONTEXT_PREFIX'] .
	str_replace(
		$_SERVER['CONTEXT_DOCUMENT_ROOT'],
		'',
		dirname(__DIR__)
	) ?>/api/v1/session?id=' + id, function(response) {
		initializeSession(response.apiKey, response.sessionId, response.token);
	});
});

function appendToCarousel(session, stream = false) {
	var options = {
		insertMode: 'append',
		width: '100%',
		height: '100%'
	};
	var identifier = (stream == false ? 'publisher' : stream.streamId);
	$('#carousel').append('' +
	'	<div class="carousel-item">' +
	'		<span class="col-sm-2">' +
	'			<div class="embed-responsive embed-responsive-4by3">' +
	'				<div id="carousel-' + identifier + '" class="embed-responsive-item"></div>' +
	'			</div>' +
	'		</span>' +
	'	</div>' +
	'');
	if (stream == false) {
		var publisher = OT.initPublisher('carousel-' + identifier, options);
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