<?php

namespace smcs\language_lab;

use LTI_Tool_Provider;

class LanguageLabLTI extends LTI_Tool_Provider {

    /* called when the LTI is launched */
    public function onLaunch() {

        /* decide which dashboard to load based on user role (URLs are relative to the path of lti/launch.php) */
        if ($this->user->isLearner()) {
            $this->redirectURL = '../StudentDashboard.php';
        } elseif ($this->user->isStaff() || $this->user->isAdmin()) {
            $this->redirectURL = '../teacherdash.php';
        } else {
            $this->reason = 'Invalid role';
            $this->isOK = false;
        }

        if ($this->isOK) {
            $_SESSION['user'] = $this->user;
            error_log('saved user information to session');
        }
    }
}
