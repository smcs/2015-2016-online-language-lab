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
	publishedStreamId: null,

	/* Keep session object as element. */
	session:null,

	publisher: null,

	appendToContainer: function(session, stream) {
		"use strict";
		var options = {
			insertMode: 'append',
			width: '100%',
			height: '100%'
		};

		var identifier = (stream === undefined ? 'publisher' : stream.streamId);

		var obj = $('#' + this.thumbnailContainerID).append('' +
			'<li class="' +  this.thumbnailClass + ' col-xs-4">' +
				'<div class="embed-responsive embed-responsive-4by3">' +
					'<div id="' + this.thumbnailPrefix + identifier + '" class="embed-responsive-item"></div>' +
				'</div>' +
			'</li>'
		);

		if (stream === undefined) {
			publisher = OT.initPublisher(this.thumbnailPrefix + identifier, options);
			this.publish();
			this.publishedStreamId = publisher.streamId;
			$('#' + this.thumbnailPrefix + identifier).attr(JSON.parse(session.connection.data)).prepend('<span class="label label-danger">' + this.userName + '</span>');
			// TODO store stream id as attribute as well
		} else if(stream !== null) {
			session.subscribe(stream, this.thumbnailPrefix + stream.streamId, options);
			var data = JSON.parse(stream.connection.data);
			$('#' + this.thumbnailPrefix + identifier).attr(data).prepend('<span class="label label-default">' + data.user_name + '</span>');
			// TODO store stream id as attribute as well
		}


		this.postAppendToContainer();
	},

	postAppendToContainer: function() {},

	initializeSession: function(apiKey, sessionId, token) {
		"use strict";

		var self = this;

		/* create a new OpenTok session */
		this.session = OT.initSession(apiKey, sessionId);

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

	publish: function() {
		this.session.publish(this.publisher);
	},

	unpublish: function() {
		//session.unpublish(publisher);
		this.session.unpublish(this.publisher);
	},

	forceDisconnect: function() {
		this.session.forceDisconnect(session.connection, function(event) {
			console.log("Disconnection is forced. ", event.reason);
		});
	},

	forceUnpublish: function() {
		this.session.connection.forceUnpublish(this.publishedStreamId, function(event) {
			console.log("Unpublish is forced. ", event.reason);
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