<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

class DeletedMemberUser extends User{
	function DeletedMemberUser($nickname){
		$this['id'] = null;
		$this['member_nickname'] = $nickname;
		$this['member_description'] = "";
		$this['avatar'] = $this['member_avatar_image'] = "default.png";
	}
	
	function getProfileUrl(){
		return "javascript:void(0);";
	}
}

?>
