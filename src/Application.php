<?php

namespace smtech\LanguageLab;

use mysqli;
use Serializable;
use LTI_Tool_Provider;
use LTI_Data_Connector;
use Battis\AppMetadata;
use Battis\ConfigXML;
use OpenTok\OpenTok;

class Application extends LTI_Tool_Provider {

    /**
     * Configuration information
     * @var ConfigXML
     */
    public $config;

    /**
     * Application metadata
     * @var AppMetadata
     */
    public $metadata;

    /**
     * MySQL connection
     * @var \mysqli
     */
    public $sql;

    /**
     * OpenTok connection
     * @var OpenTok
     */
    public $opentok;

    public function __construct($config) {
        $this->config = new ConfigXML($config);

        $this->sql = $this->config->newInstanceOf(mysqli::class, '//mysql');

        parent::__construct(
            LTI_Data_Connector::getDataConnector($this->sql)
        );
        $this->setParameterConstraint('oauth_consumer_key', TRUE, 50);
        $this->setParameterConstraint('resource_link_id', TRUE, 50, array('basic-lti-launch-request'));
        $this->setParameterConstraint('user_id', TRUE, 50, array('basic-lti-launch-request'));
        $this->setParameterConstraint('roles', TRUE, NULL, array('basic-lti-launch-request'));

        $this->metadata = new AppMetadata($this->sql, '');

        $this->opentok = $this->config->newInstanceOf(OpenTok::class, '//tokbox');
    }

    public function onLaunch() {
        if ($this->user->isLearner()) {
            $this->redirectURL = "{$this->metadata['APP_URL']}/student/dashboard.php";
        } elseif ($this->user->isStaff() || $this->user->isAdmin()) {
            $this->redirectURL = "{$this->metadata['APP_URL']}/teacher/dashboard.php";
        } else {
            $this->reason = 'Invalid role';
            $this->isOK = false;
        }
        $_SESSION['context'] = $this->user->getResourceLink()->lti_context_id;
    	$_SESSION['user'] = $this->user->getId();
    	$_SESSION['firstName'] = $this->user->firstname;
    	$_SESSION['lastName'] = $this->user->lastname;
    	$_SESSION['fullName'] = $this->user->fullname;
    }
}
