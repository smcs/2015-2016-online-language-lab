<?php

namespace smcs\language_lab;

use LTI_Tool_Provider;

class LanguageLabLTI extends LTI_Tool_Provider {

    /* called when the LTI is launched */
    public function onLaunch() {
        /* store the user/course information from Canvas (the tool consumer) in
           the $_SESSION global */
        $_SESSION['consumer'] = $this->user->getResourceLink()->settings;

        /* decide which dashboard to load based on user role */
        if ($this->user->isLearner()) {
            $this->redirectURL = 'StudentDashboard.php';
        } elseif ($this->user->isStaff() || $this->user->isAdmin()) {
            $this->redirectURL = 'teacherdash.php';
        } else {
            $this->reason = 'Invalid role';
            $this->isOK = false;
        }
    }
}
