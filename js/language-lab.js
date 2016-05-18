/* directives for http://JSLint.com */
/*jslint browser, for, this, white, multivar */
/*global $, OT, console */

var LanguageLab; // make JSLint shut up
LanguageLab = {
	thumbnailContainerID: 'ot-streams',
	thumbnailClass: 'ot-stream',
	thumbnailPrefix: 'ot-stream-',
    rootURL: null,
    context: null,
    user: null,
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
			'<li class="' +  this.thumbnailClass + ' draggable col-xs-2">' +
				'<div class="embed-responsive embed-responsive-4by3">' +
					'<div id="' + this.thumbnailPrefix + identifier + '" class="embed-responsive-item"></div>' +
				'</div>' +
			'</li>'
		);
		if (stream === undefined) {
			var publisher = OT.initPublisher(this.thumbnailPrefix + identifier, options);
			session.publish(publisher);
			this.publishedStreamId = publisher.streamId;
		} else if(stream !== null) {
			session.subscribe(stream, this.thumbnailPrefix + stream.streamId, options);
		}

		this.postAppendToContainer();
	},

	postAppendToContainer: function() {},

	initializeSession: function(apiKey, sessionId, token) {
		"use strict";

		var self = this;

		/* create a new OpenTok session */
		var session = OT.initSession(apiKey, sessionId);

		/* define event-driven session behaviors */
		session.on('streamCreated', function(event) {
			if (event.stream.streamId !== self.publishedStreamId) {
				self.appendToContainer(session, event.stream);
			}
		});

		session.on('streamDestroyed', function(event) {
			$('.' + self.thumbnailClass + ':has(#' + self.thumbnailPrefix + event.stream.streamId + ')').remove();
		});

		session.on('sessionDisconeected', function(event) {
			console.log('You were disconnected from the session. ', event.reason);
		});

		/* connect to the session */
		session.connect(token, function(error) {
			if (!error) {
				self.appendToContainer(session);
			} else {
				console.log('There was an error connecting to the session: ', error.code, error.message);
			}
		});
	},

    makeConnection: function() {},

	init: function(rootURL, context, user) {
		"use strict";
        this.rootURL = rootURL;
        this.context = context;
        this.user = user;
        this.makeConnection();
    }
};
