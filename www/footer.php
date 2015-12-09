<?php 
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
?>
	</div><!-- /content -->

<div style="text-align: center">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Mobile pierotofy.it -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:50px"
     data-ad-client="ca-pub-3144450577280402"
     data-ad-slot="8674430179"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

	<div id="footer">
		<a href="<?php echo DESKTOP_VERSION_URL; ?>/nomobile.php?url=<?php echo urlencode(UrlBridge::ToDesktop($_SERVER["REQUEST_URI"])); ?>">Versione classica</a> | 
		<a href="<?php 
			echo "http://svn.pierotofy.it/filedetails.php?repname=mobile-devel&path=" . urlencode(str_replace("/mobile/", "/", str_replace($home_dir, "/", $_SERVER['SCRIPT_NAME'])));
		?>">Vedi il sorgente</a>
	</div><!-- /footer -->
</div><!-- /container -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-6669942-11', 'pierotofy.it');
  ga('send', 'pageview');

</script>
</body>
</html>
