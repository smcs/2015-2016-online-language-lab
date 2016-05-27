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
	userName: null,
	sessions: [],
	publishedStreams: [],

	appendToContainer: function(stream, container) {
		"use strict";
		var options = {
			insertMode: 'append',
			width: '100%',
			height: '100%'
		};

		var identifier = (stream === undefined ? 'publisher' : stream.streamId);

		var obj = $('#' + container).append('' +
			'<li class="' +  this.thumbnailClass + ' col-xs-4">' +
				'<div class="embed-responsive embed-responsive-4by3">' +
					'<div id="' + this.thumbnailPrefix + identifier + '" class="embed-responsive-item"></div>' +
				'</div>' +
			'</li>'
		);

		var thumbnail = '#' + this.thumbnailPrefix + identifier;

		if (stream === undefined) {
			this.publishedStreams[container] = OT.initPublisher(this.thumbnailPrefix + identifier, options);
			this.sessions[container].publish(this.publishedStreams[container]);
			$(thumbnail).attr(JSON.parse(this.sessions[container].connection.data)).attr('stream_id', this.publishedStreams[container].streamId).prepend('<span class="label label-danger">' + this.userName + '</span>');
		} else if(stream !== null) {
			this.sessions[container].subscribe(stream, this.thumbnailPrefix + stream.streamId, options);
			$(thumbnail).attr(JSON.parse(stream.connection.data)).attr('stream_id', stream.streamId);
			$(thumbnail).prepend('<span class="label label-default">' + $(thumbnail).attr('user_name') + '</span>');
		}

		this.postAppendToContainer();
	},

	postAppendToContainer: function() {},

	initializeSession: function(apiKey, sessionId, token, container) {
		"use strict";

		var self = this;

		/* create a new OpenTok session */
		if (container === undefined) {
			container = this.thumbnailContainerID;
		}
		this.sessions[container] = OT.initSession(apiKey, sessionId);
		if(this.sessions[container].connection === undefined) {
			console.log('No session connection for container ' + container);
		}

		/* define event-driven session behaviors */
		this.sessions[container].on('streamCreated', function(event) {
			if (event.stream.streamId !== self.publishedStreams[container].streamId) {
				self.appendToContainer(event.stream, container);
			}
		});

		this.sessions[container].on('streamDestroyed', function(event) {
			$('.' + self.thumbnailClass + ':has(#' + self.thumbnailPrefix + event.stream.streamId + ')').remove();
		});

		this.sessions[container].on('sessionDisconeected', function(event) {
			console.log('You were disconnected from the session. ', event.reason);
		});

		/* connect to the session */
		this.sessions[container].connect(token, function(error) {
			if (!error) {
				self.appendToContainer(undefined, container);
			} else {
				console.log('There was an error connecting to the session: ', error.code, error.message);
			}
		});
	},

    makeConnection: function() {},

	init: function(rootURL, context, user, userName) {
		"use strict";
        this.rootURL = rootURL;
        this.context = context;
        this.user = user;
		this.userName = userName;
        this.makeConnection();
    }
};
