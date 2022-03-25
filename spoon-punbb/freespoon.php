<?php
define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';

// Load the index.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/index.php';

$page_title = pun_htmlspecialchars($pun_config['o_board_title']);
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';
generate_forum_menu('freespoon');
$result = $db->query('SELECT * FROM '.$db->prefix.'plans WHERE id=\'0\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
$plan[0] = $db->fetch_assoc($result);
$plan['0']['diskspace'] = mbgb($plan['0']['diskspace']);
$plan['0']['bandwidth'] = mbgb($plan['0']['bandwidth']);

?>
	<div class="blockpost">
		<h2>Free SPOON</h2>
		<div class="box">
			<div class="inbox">
				<div class="postright">
					<div class="postmsg">
						<p>Free SPOON is a free hosting service available to all registered SPOON members.<br /><br />
						Although not feature-packed like SPOON's paid plans, Free SPOON accounts include PHP support and web mail access.
						<br /><br /><a href="viewtopic.php?id=17">Click here for more information on activating your Free SPOON.</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="plantable" class="blocktable">
		<div class="box">
			<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col">Features</th>
					<th class="tc2" scope="col">Free SPOON</th>
				</tr>
			</thead>
	
			<tbody>
				<tr>
					<td class="tcl">Price (per month)</td>
					<td class="tc2">$<?=$plan[0][price]?></td>
				</tr>
				<tr>
					<td class="tcl">Disk space</td>
					<td class="tc2"><?=$plan[0][diskspace]?></td>
				</tr>
				<tr>
					<td class="tcl">Bandwidth</td>
					<td class="tc2"><?=$plan[0][bandwidth]?></td>
				</tr>
			</tbody>
			</table>		
			</div>
		</div>
	</div>
	<div id="plantable" class="blocktable">
		<div class="box">
			<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col">Domain/IP Features</th>
					<th class="tc2" scope="col"></th>
				</tr>
			</thead>
	
			<tbody>
				<tr>
					<td class="tcl">Domains</td>
					<td class="tc2"><?=$plan[0][domains]?></td>
				</tr>
				<tr>
					<td class="tcl">Dedicated IP</td>
					<td class="tc2">-</td>
				</tr>
			</tbody>
			</table>
			</div>
		</div>
	</div>
	<div id="plantable" class="blocktable">
		<div class="box">
			<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col">Email Features</th>
					<th class="tc2" scope="col"></th>
				</tr>
			</thead>
	
			<tbody>
				<tr>
					<td class="tcl">POP/IMAP accounts</td>
					<td class="tc2"><?=$plan[0][email_act]?></td>
				</tr>
				<tr>
					<td class="tcl">Email forwarding</td>
					<td class="tc2">-</td>
				</tr>
				<tr>
					<td class="tcl">Email responders</td>
					<td class="tc2">-</td>
				</tr>
				<tr>
					<td class="tcl">SPAM filtering</td>
					<td class="tc2">-</td>
				</tr>
				<tr>
					<td class="tcl">Web mail</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
			</tbody>
			</table>
			</div>
		</div>
	</div>
	<div id="plantable" class="blocktable">
		<div class="box">
			<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col">Developer Features</th>
					<th class="tc2" scope="col"></th>
				</tr>
			</thead>
	
			<tbody>
				<tr>
					<td class="tcl">PHP</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
				<tr>
					<td class="tcl">Perl</td>
					<td class="tc2">-</td>
				</tr>
				<tr>
					<td class="tcl">CGI-BIN</td>
					<td class="tc2">-</td>
				</tr>
				<tr>
					<td class="tcl">.htaccess override</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
				<tr>
					<td class="tcl">FrontPage extensions</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
			</tbody>
			</table>
			</div>
		</div>
	</div>
	<div id="plantable" class="blocktable">
		<div class="box">
			<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col">Database Features</th>
					<th class="tc2" scope="col"></th>
				</tr>
			</thead>
	
			<tbody>
				<tr>
					<td class="tcl">MySQL Databases</td>
					<td class="tc2"><?=$plan[0][mysql_db]?></td>
				</tr>
				<tr>
					<td class="tcl">PHPMyAdmin</td>
					<td class="tc2">-</td>
				</tr>
			</tbody>
			</table>
			</div>
		</div>
	</div>
	<div id="plantable" class="blocktable">
		<div class="box">
			<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col">Security Features</th>
					<th class="tc2" scope="col"></th>
				</tr>
			</thead>
	
			<tbody>
				<tr>
					<td class="tcl">Weekly backup</td>
					<td class="tc2">-</td>
				</tr>
				<tr>
					<td class="tcl">SSH</td>
					<td class="tc2">-</td>
				</tr>
				<tr>
					<td class="tcl">SSL support</td>
					<td class="tc2">-</td>
				</tr>
			</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
<?php
require PUN_ROOT.'footer.php';
?>