<!-- end #mainContent --></div>
<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
   <div id="footer">
	<center><small>
     <p>Page generated in <?php echo round($exec_time,4);?> sec.
        Query's: (Realm DB: <?php echo $DB->_statistics['count']; ?>,
        World DB: <?php echo $WDB->_statistics['count']?>,
        Character DB: <?php echo $CDB->_statistics['count']?>)<br/>
		<?php echo $cfg->get('copyright')."<br />"; echo $site_copyright; ?> 
	 </p>
	</small></center>
  <!-- end #footer --></div>
<!-- end #container --></div>
</body>
</html>