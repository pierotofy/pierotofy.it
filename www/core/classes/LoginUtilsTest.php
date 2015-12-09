<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

require_once("__inc__.php");
require_once(ROOT_PATH . "core/3rdparty/simpletest/autorun.php");


class LoginUtilsTest extends UnitTestCase {
    function testIsEmailValid() {
        $this->assertTrue(LoginUtils::IsEmailValid('admin@pierotofy.it'));
		$this->assertTrue(LoginUtils::IsEmailValid('"Abc\@def"@example.com'));
		$this->assertTrue(LoginUtils::IsEmailValid('!#$%&\'*+-/=?^_`{}|~@example.org'));
		$this->assertTrue(LoginUtils::IsEmailValid('!def!xyz%abc@example.com'));

        $this->assertFalse(LoginUtils::IsEmailValid('test@test.tes'));        
        $this->assertFalse(LoginUtils::IsEmailValid('A@b@c@example.com'));
        $this->assertFalse(LoginUtils::IsEmailValid('a"b(c)d,e:f;g<h>i[j\k]l@example.com'));
        $this->assertFalse(LoginUtils::IsEmailValid('this is"not\\allowed@example.com'));
        $this->assertFalse(LoginUtils::IsEmailValid('A@b@c@example.com'));
    }
}

?>
