<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

require_once("__inc__.php");
require_once(ROOT_PATH . "core/3rdparty/simpletest/autorun.php");


class UrlBridgeTest extends UnitTestCase {
    function testPathConversion() {
        // Tests semplici
        $this->assertEqual(UrlBridge::ToMobile(DESKTOP_VERSION_URL . "/p/extras/forum/"), 
                                                MOBILE_VERSION_URL . "/p/forum/");
        $this->assertEqual(UrlBridge::ToDesktop(MOBILE_VERSION_URL . "/p/forum/"), 
                                                DESKTOP_VERSION_URL . "/p/extras/forum/");

        $this->assertEqual(UrlBridge::ToMobile(DESKTOP_VERSION_URL . "/p/login/cpanel/mail/"), 
                                                MOBILE_VERSION_URL . "/p/user/panels/messages/");
        $this->assertEqual(UrlBridge::ToDesktop(MOBILE_VERSION_URL . "/p/user/panels/messages/index.php"),
                                                DESKTOP_VERSION_URL . "/p/login/cpanel/mail/index.php");

        // Piu' complessi
        $this->assertEqual(UrlBridge::ToMobile(DESKTOP_VERSION_URL . "/p/extras/forum/23/23-test/?p=1#p213"), 
                                                MOBILE_VERSION_URL . "/p/forum/23/23-test/?p=1#p213");

        
                                            
        // #######################################
        // Test Guide
        $this->assertEqual(UrlBridge::ToMobile(DESKTOP_VERSION_URL . "/p/guide/Guida_Pascal/"), 
                                                MOBILE_VERSION_URL . "/p/guide/5-Guida_Pascal/");
        $this->assertEqual(UrlBridge::ToDesktop(MOBILE_VERSION_URL . "/p/guide/5-Guida_Pascal/"),
                                                DESKTOP_VERSION_URL . "/p/guide/Guida_Pascal/");
        $this->assertEqual(UrlBridge::ToMobile(DESKTOP_VERSION_URL . "/p/guide/Guida_Pascal/Introduzione_alla_programmazione/"), 
                                                MOBILE_VERSION_URL . "/p/guide/5-Guida_Pascal/1-Introduzione_alla_programmazione/");
        $this->assertEqual(UrlBridge::ToDesktop(MOBILE_VERSION_URL . "/p/guide/5-Guida_Pascal/1-Introduzione_alla_programmazione/"),
                                                DESKTOP_VERSION_URL . "/p/guide/Guida_Pascal/Introduzione_alla_programmazione/");
    }
}

?>
