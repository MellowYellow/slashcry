</td>
	</tr>
	<tr><td colspan="2" style="border-top: 1px dotted #666666;">
	<div class="footer">
	<center>
     <p>Page generated in <?php echo round($exec_time,4);?> sec.
        Query's: (Realm DB: <?php echo $DB->_statistics['count']; ?>,
        World DB: <?php echo $WDB->_statistics['count']?>,
        Character DB: <?php echo $CDB->_statistics['count']?>)<br/>
		<?php echo $site_copyright; // DONOT remove!!! ?> 
	 </p>
	</center>
	</td></tr>
</table>
</body>