<?php

namespace Rafflex\AdminSetupXtension\Admin;

class Notification
{
    public function removeNotifications() {
        echo "
        <style type='text/css'>
            #wpwrap .notice.notice-error.is-dismissible,
            #wpwrap #duplicate-post-notice,
            #wpwrap .notice#emr-news,
            #wpwrap .notice.frash-notice.frash-notice-rate,
            #wpwrap .notice.updated.editorskit-notice {
                display: none !important;
            }
        </style>
        ";
    }
}
