<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	$pagSection = "Home";
	
	require_once("__inc__.php");
	require_once(ROOT_PATH . "header.php");
?>

<h3>Ultimi topics</h3>
<ul class="nav-list" style="margin: 1em 0;">
<?php
	// Ultimi topics nel forum
	$q = exequery(Topic::SELECT_SQL . 
				"WHERE a.private = 0 AND type = " . Forum::TYPE_TOPIC . " 
				ORDER BY last_post_date DESC LIMIT 0,15");
	while($values = mysqli_fetch_array($q)){
		$topic = new Topic($values);
?>
		<li>
			<a class="nowrap" href="<?php echo $topic->getUrl(); ?>">
			<span class="tag pull-right" style="margin-left: 0.5em;"><?php echo $topic['argument_title']; ?></span>
			<span class="bubble red pull-right"><?php echo $topic['replies']; ?></span>
			<?php echo $topic->getName(); ?>
			<span class="hide-phone hide-tablet"> - <?php echo $topic->getFormattedDate(); ?></span>
			</a>
		</li>
<?php } ?>
</ul>


<?php
	echo AlertMessage::Get("Vi ricordiamo che questo sito e' un lavoro in corso, 
		quindi errori e mancanza di funzionalita' sono perfettamente normali a questo punto.<br/><br/>

		<ul style='margin-left: 20px;'>
			<li style='margin-bottom: 20px;'>Se trovi un errore <button class='btn' onclick=\"location.href='http://www.pierotofy.it/p/extras/forum/572/';\">segnalalo agli sviluppatori</button></li>
			<li style='margin-bottom: 20px;'>Se vuoi contribuire e partecipare assieme al nostro fantastico team di sviluppo <button class='btn' onclick=\"location.href='http://devwiki.pierotofy.it';\">visita il nostro wiki</button></li>
			<li style='margin-bottom: 20px;'>Se sei curioso di vedere il sorgente <button class='btn' onclick=\"location.href='http://svn.pierotofy.it';\">clicca qui</button></li>
		</ul>", AlertMessage::WARN);
?>


	<div class="center">
		<img src="/images/eagle.jpg" alt="PieroTofy.it" style="float: left; margin-top: 14px; margin-right: 16px; margin-bottom: 16px;"/>
	</div>
	<p>Benvenuti nella versione mobile di <a href="http://www.pierotofy.it">PieroTofy.it</a>! <strong>Questa e' una home page temporanea</strong>, verra' presto rimpiazzata da una lista di discussioni.</p>
	<p>
		Nel frattempo, assicurati di provare ad usare il <a href="/p/forum/">forum</a> e loggati per leggere la tua posta in arrivo.
	</p>
	<div class="clear"></div>

<?php
	require_once(ROOT_PATH . "footer.php");
?>
