<?php
// Tell header.php to use the admin template
define('PUN_ADMIN_CONSOLE', 1);

define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
require PUN_ROOT.'include/common_admin.php';


if ($pun_user['g_id'] > PUN_MOD)
	message($lang_common['No permission']);


$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Admin / Recurring Invoices';
require PUN_ROOT.'header.php';
generate_admin_menu('recurring');
?>
	<div class="block">
		<h2>Recurring Invoices</h2>
		<div id="description" class="box">
			<div class="inbox">
				<p>
					"Recurrings" are on-going billing subscriptions. Such as SPOON's monthly hosting plans or annual domain renewals.
				</p>
				<p>
					<a href="#">New reccuring invoice</a>
				</p>
			</div>
		</div>
	</div>
	<div id="recurrings" class="blocktable">
		<div class="box">
			<div class="inbox">
				<table cellspacing="0">
				<thead>
					<tr>
						<th class="tcl" scope="col">Domain</th>
						<th class="tc2" scope="col">Type</th>
						<th class="tc3" scope="col">Actions</th>
					</tr>
				</thead>
				<tbody>
<?php
$result = $db->query('SELECT recurrings.*, accounts.domain FROM recurrings, accounts WHERE (recurrings.account_id = accounts.id AND active = \'1\')') or error('Unable to fetch recurrings info', __FILE__, __LINE__, $db->error());
if ($db->num_rows($result)) {
	while ($recurrings_data = $db->fetch_assoc($result)) {
		$actions = '<a href="admin_recurring.php?action=pause&recurrings_id='.$recurrings_data['id'].'\">Pause</a> - <a href="admin_recurring.php?action=edit&recurrings_id='.$recurrings_data['id'].'\">Edit</a> - <a href="invoice.php?action=delete&recurring_id='.$recurrings_data['id'].'&id='.$recurrings_data['user_id'].'">Delete</a>';
		if($recurrings_data['type'] == 1)
			$type = "Hosting";
		elseif($recurrings_data['type'] == 2)
			$type = "Domain";
		else
			$type = "Misc";
?>
					<tr>
						<td class="tcl"><?=$recurrings_data['domain']?></td>
						<td class="tc2"><?=$type?></td>
						<td class="tc3"><?=$actions?></td>
					</tr>
<?php
	}
}else{
	echo "\t\t\t\t\t".'<tr><td class="tcl" colspan="6">No recurring invoices available.</td></tr>'."\n";
}
?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php
require PUN_ROOT.'footer.php';
?>
