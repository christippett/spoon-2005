<?php
define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';


if ($pun_user['g_read_board'] == '0')
	message($lang_common['No view']);


// Load the index.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/index.php';

$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Plans';
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';
generate_forum_menu('plans');
$result = $db->query('SELECT * FROM '.$db->prefix.'plans WHERE id=\'1\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
$plan[1] = $db->fetch_assoc($result);
$result = $db->query('SELECT * FROM '.$db->prefix.'plans WHERE id=\'2\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
$plan[2] = $db->fetch_assoc($result);
$result = $db->query('SELECT * FROM '.$db->prefix.'plans WHERE id=\'3\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
$plan[3] = $db->fetch_assoc($result);
$plan['1']['diskspace'] = mbgb($plan['1']['diskspace']);
$plan['2']['diskspace'] = mbgb($plan['2']['diskspace']);
$plan['3']['diskspace'] = mbgb($plan['3']['diskspace']);
$plan['1']['bandwidth'] = mbgb($plan['1']['bandwidth']);
$plan['2']['bandwidth'] = mbgb($plan['2']['bandwidth']);
$plan['3']['bandwidth'] = mbgb($plan['3']['bandwidth']);
?>
	<div id="plantable" class="blocktable">
		<h2><span>SPOON Hosting Plans</span></h2>
		<div class="box">
			<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col"></th>
					<th class="tc2" scope="col"><strong><?=$plan[1][plan_name]?></strong></th>
					<th class="tc3" scope="col"><strong><?=$plan[2][plan_name]?></strong></th>
					<th class="tc4" scope="col"><strong><?=$plan[3][plan_name]?></strong></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="tcl">Price (per month)</td>
					<td class="tc2"><a href="/forum/order.php">$<?=$plan[1][price]?></a></td>
					<td class="tc3"><a href="/forum/order.php">$<?=$plan[2][price]?></a></td>
					<td class="tc4"><a href="/forum/order.php">$<?=$plan[3][price]?></a></td>
				</tr>
				<tr>
					<td class="tcl">Disk space</td>
					<td class="tc2"><?=$plan[1][diskspace]?></td>
					<td class="tc3"><?=$plan[2][diskspace]?></td>
					<td class="tc4"><?=$plan[3][diskspace]?></td>
				</tr>
				<tr>
					<td class="tcl">Bandwidth</td>
					<td class="tc2"><?=$plan[1][bandwidth]?></td>
					<td class="tc3"><?=$plan[2][bandwidth]?></td>
					<td class="tc4"><?=$plan[3][bandwidth]?></td>
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
					<th class="tc3" scope="col"></th>
					<th class="tc4" scope="col"></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="tcl">Domains</td>
					<td class="tc2"><?=$plan[1][domains]?></td>
					<td class="tc3"><?=$plan[2][domains]?></td>
					<td class="tc4"><?=$plan[3][domains]?></td>
				</tr>
				<tr>
					<td class="tcl">Sub-Domains</td>
					<td class="tc2"><?=$plan[1][domains_sub]?></td>
					<td class="tc3"><?=$plan[2][domains_sub]?></td>
					<td class="tc4"><?=$plan[3][domains_sub]?></td>
				</tr>
				<tr>
					<td class="tcl">Dedicated IP</td>
					<td class="tc2">-</td>
					<td class="tc3">-</td>
					<td class="tc4">-</td>
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
					<th class="tc3" scope="col"></th>
					<th class="tc4" scope="col"></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="tcl">POP/IMAP accounts</td>
					<td class="tc2"><?=$plan[1][email_act]?></td>
					<td class="tc3"><?=$plan[2][email_act]?></td>
					<td class="tc4"><?=$plan[3][email_act]?></td>
				</tr>
				<tr>
					<td class="tcl">Email forwarding</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
				<tr>
					<td class="tcl">Email responders</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
				<tr>
					<td class="tcl">SPAM filtering</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
				<tr>
					<td class="tcl">Web mail</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
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
					<th class="tc3" scope="col"></th>
					<th class="tc4" scope="col"></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="tcl">PHP</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
				<tr>
					<td class="tcl">Perl</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
				<tr>
					<td class="tcl">CGI-BIN</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
				<tr>
					<td class="tcl">.htaccess override</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
				<tr>
					<td class="tcl">FrontPage extensions</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
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
					<th class="tc3" scope="col"></th>
					<th class="tc4" scope="col"></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="tcl">MySQL Databases</td>
					<td class="tc2"><?=$plan[1][mysql_db]?></td>
					<td class="tc3"><?=$plan[2][mysql_db]?></td>
					<td class="tc4"><?=$plan[3][mysql_db]?></td>
				</tr>
				<tr>
					<td class="tcl">PHPMyAdmin</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
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
					<th class="tc3" scope="col"></th>
					<th class="tc4" scope="col"></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="tcl">Weekly backup</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
				<tr>
					<td class="tcl">SSH</td>
					<td class="tc2">-</td>
					<td class="tc3">-</td>
					<td class="tc4">-</td>
				</tr>
				<tr>
					<td class="tcl">SSL support</td>
					<td class="tc2"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc3"><img src="/images/check.gif" alt="YES" /></td>
					<td class="tc4"><img src="/images/check.gif" alt="YES" /></td>
				</tr>
			</tbody>
			</table>
			</div>
		</div>
	</div>
	<div id="planorder" class="blocktable">
		<div class="box">
			<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col"></th>
					<th class="tc2" scope="col"><a href="/order.php">Order</a></th>
					<th class="tc3" scope="col"><a href="/order.php">Order</a></th>
					<th class="tc4" scope="col"><a href="/order.php">Order</a></th>
				</tr>
			</thead>
			</table>
			</div>
		</div>
	</div>
</div>
<?php
$footer_style = 'index';
require PUN_ROOT.'footer.php';
