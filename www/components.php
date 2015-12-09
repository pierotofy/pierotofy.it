<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	$pagSection = "TEST: Componenti";
	
	require_once("__inc__.php");
	require_once(ROOT_PATH . "header.php");

?>

<h1>Input</h1>
<input type="button" value="Bottone" />
<input type="text" value="Casella di testo" /><br/><br/>

<input type="radio" id="radiotestc" name="radiotest" value="test" /><label for="radiotestc">Clicca qui</label><br/>
<input type="radio" id="radiotestc2" name="radiotest" value="test" /><label for="radiotestc2">oppure qui</label><br/>

<label for="checkboxtest">Missili nucleari attivi: </label><input type="checkbox" id="checkboxtest" checked /><br/>
<label for="checkboxtest2">Questo sito spacca: </label><input type="checkbox" id="checkboxtest2" class="yes-no" /><br/>

<label for="checkboxtest3">Check: </label><div id="checkboxtest3" class="checkbox" data-value="checked"></div> <div id="checkboxtest4" class="checkbox white" data-value=""></div>

<h1>Links</h1>

<a href="javascript:void(0);">Link testuale</a>

<a href="javascript:void(0);" class="btn">Bottone link</a>

<a href="javascript:void(0);" class="btn disabled">Bottone link disabilitato</a>

<h1>Liste</h1>

<ul class="nav-list">

	<li class="nav-title">Menu principale</li>
	<li><a href="/p/forum/">Forum <span class="tag">Reti & Internet</span></a></li>
	<ul class="nav-list">
		<ul class="nav-list">
			<li>Programmi</li>
			<li>Articoli</li>
			<li>Canale forum</li>
			<li>Progetti</li>
		</ul>
		<li>C++</li>
		<li>Java</li>
		<li>Visual Basic .NET</li>
		<li>Ruby</li>
	</ul>
	<li>Sorgenti <span class="bubble">13</span></li>
	<li class="nav-title">Informatica generale</li>
	<ul class="nav-list">
		<li>C++</li>
		<li>Java</li>
		<li>Visual Basic .NET</li>
		<li>Ruby</li>
	</ul>
	<li>Programmi <span class="bubble red">5</span></li>
</ul>

<h1>Testo</h1>

<p>Paragrafo normale</p>

<p>Un altro paragrafo normale</p>

<p class="quote">Quotazione</p>

<p class="quote">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae libero lectus. Sed non eros condimentum, posuere turpis in, luctus leo. Integer faucibus, erat eu sagittis facilisis, eros augue aliquam neque, sit amet posuere est nunc quis diam. Fusce consectetur leo sed ultrices congue. Maecenas semper risus at bibendum aliquet. Quisque interdum viverra sem vitae ultricies. Praesent ornare condimentum ante eu posuere. Fusce quis quam id lorem dignissim semper in sed leo. Suspendisse fringilla dui vitae leo aliquam molestie. Duis molestie sit amet diam in placerat. Fusce nibh nisl, tincidunt sit amet ligula vitae, ullamcorper adipiscing sapien. Nullam sed sodales lacus. Curabitur placerat ante congue hendrerit adipiscing. Phasellus lectus nibh, varius at elementum ut, imperdiet aliquam mauris. Duis vestibulum viverra libero, vitae venenatis lorem.</p>

<p>Avvisi</p>

<div class="alert">
	<span class="icon icon-information_black"></span> Lo sapevi che... ?
</div>

<div class="alert warning">
	<span class="icon icon-warning"></span> Non hai i permessi per...
</div>

<?php
	require_once(ROOT_PATH . "footer.php");
?>