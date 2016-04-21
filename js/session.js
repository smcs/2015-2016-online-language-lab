/* directives for http://JSLint.com */
/*jslint browser, for, this, white, multivar */
/*global $, OT, console */

var app; // make JSLint shut up
app = {
	thumbnailContainerID: 'ot-streams',
	thumbnailClass: 'ot-stream',
	thumbnailPrefix: 'ot-stream-',
	publishedStreamId: null,
	
	appendToContainer: function(session, stream) {
		"use strict";
		var options = {
			insertMode: 'append',
			width: '100%',
			height: '100%'
		};
		var identifier = (stream === undefined ? 'publisher' : stream.streamId);
		$('#' + this.thumbnailContainerID).append('' +
		'	<div class="' +  this.thumbnailClass + '">' +
		'		<span class="col-sm-2">' +
		'			<div class="embed-responsive embed-responsive-4by3">' +
		'				<div id="' + this.thumbnailPrefix + identifier + '" class="embed-responsive-item"></div>' +
		'			</div>' +
		'		</span>' +
		'	</div>' +
		'');
		if (stream === undefined) {
			var publisher = OT.initPublisher(this.thumbnailPrefix + identifier, options);
			session.publish(publisher);
			this.publishedStreamId = publisher.streamId;
		} else if(stream !== null) {
			session.subscribe(stream, this.thumbnailPrefix + stream.streamId, options);
		}
	},
	
	initializeSession: function(apiKey, sessionId, token) {
		"use strict";
	
		/* create a new OpenTok session */
		var session = OT.initSession(apiKey, sessionId);
	
		/* define event-driven session behaviors */
		session.on('streamCreated', function(event) {
			if (event.stream.streamId !== app.publishedStreamId) {
				app.appendToContainer(session, event.stream);
			}
		});
		
		session.on('streamDestroyed', function(event) {
			$('.' + app.thumbnailClass + ':has(#' + app.thumbnailPrefix + event.stream.streamId + ')').remove();
		});
		
		session.on('sessionDisconeected', function(event) {
			console.log('You were disconnected from the session. ', event.reason);
		});
		
		/* connect to the session */
		session.connect(token, function(error) {
			if (!error) {
				app.appendToContainer(session);
			} else {
				console.log('There was an error connecting to the session: ', error.code, error.message);
			}
		});
	},
	
	init: function(rootURL, id) {
		"use strict";
		this.thumbnailPrefix = this.thumbnailClass + '-';
		/* get credentials from server */
		$(document).ready(function() {
			$.getJSON(rootURL + '/api/v1/session?id=' + id, function(response) {
				app.initializeSession(response.apiKey, response.sessionId, response.token);
			});
		});	}
};