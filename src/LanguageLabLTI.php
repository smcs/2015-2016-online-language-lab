<?php

namespace smcs\language_lab;

use LTI_Tool_Provider;

class LanguageLabLTI extends LTI_Tool_Provider {

    /* called when the LTI is launched */
    public function onLaunch() {

        /* decide which dashboard to load based on user role (URLs are relative to the path of lti/launch.php) */
        if ($this->user->isLearner()) {
            $this->redirectURL = '../StudentDashboard.php?session=' . session_id();
        } elseif ($this->user->isStaff() || $this->user->isAdmin()) {
            $this->redirectURL = '../teacherdash.php?session=' . session_id();
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
