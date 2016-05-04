<?php

namespace smtech\LanguageLab;

use mysqli;
use LTI_Tool_Provider;
use LTI_Data_Connector;
use Battis\AppMetadata;

class Application extends LTI_Tool_Provider {

    /**
     * Application metadata
     * @var AppMetadata
     */
    public $metadata;

    /**
     * MySQL connection
     * @var mysqli
     */
    public $sql;

    public function __construct(mysqli $sql) {
        $this->sql = $sql;
        $this->metadata = new AppMetadata($sql, '');
        parent::__construct(
            LTI_Data_Connector::getDataConnector($this->sql)
        );
        $this->setParameterConstraint('oauth_consumer_key', TRUE, 50);
        $this->setParameterConstraint('resource_link_id', TRUE, 50, array('basic-lti-launch-request'));
        $this->setParameterConstraint('user_id', TRUE, 50, array('basic-lti-launch-request'));
        $this->setParameterConstraint('roles', TRUE, NULL, array('basic-lti-launch-request'));
    }

    public function onLaunch() {
        if ($this->user->isLearner()) {
            $this->redirectURL = "{$this->metadata['APP_URL']}/student-dashboard.php";
        } elseif ($this->user->isStaff() || $this->user->isAdmin()) {
            $this->redirectURL = "{$this->metadata['APP_URL']}/teacher-dashboard.php";
        } else {
            $this->reason = 'Invalid role';
            $this->isOK = false;
        }
    }
}
