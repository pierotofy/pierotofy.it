<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	$pagSection = "About";
	
	require_once("__inc__.php");
	require_once(ROOT_PATH . "header.php");

	// Lista svilupatori versione mobile
	$devs = array("ghostmars919", "ale.gatti96", "qwertj", "Piero Tofy"); 
	$username = join(',', array_map(function($v){ 
										return "'" . $v . "'"; 
									}, $devs));
?>
	<div class="center">
		<img src="/images/eagle.jpg" alt="<?php echo SITE_VERSION; ?>">
		<p><b><?php echo SITE_VERSION; ?></b></p>
		<p>Si ringrazia per il loro contributo:</p>

		<?php
			$query = exequery(User::SELECT_SQL."WHERE nickname IN ($username) ORDER BY nickname");
			while($row = mysqli_fetch_array($query)){
				
				$user_link = new User($row);
				echo ("<img class='avatar small' src=" . $user_link -> getAvatarUrl() . " alt='avatar'> ");
				echo ($user_link -> getProfileLink()."<br/><br/>");
			}
		?>
	</div>
<?php
	require_once(ROOT_PATH . "footer.php");
	//var_dump($debug_queries_list);
?>
