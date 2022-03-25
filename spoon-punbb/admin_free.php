<?php
// Tell header.php to use the admin template
define('PUN_ADMIN_CONSOLE', 1);

define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
require PUN_ROOT.'include/common_admin.php';


if ($pun_user['g_id'] > PUN_MOD)
	message($lang_common['No permission']);


$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Admin / Free SPOONs';
require PUN_ROOT.'header.php';
generate_admin_menu('listfree');
?>
	<div id="activate" class="blocktable">
		<h2><span>Free SPOONs</span></h2>
		<div class="box">
			<div class="inbox">
				<table cellspacing="0">
				<thead>
					<tr>
						<th class="tcl" scope="col">Username</th>
						<th class="tc2" scope="col">Domain</th>
						<th class="tc3" scope="col">Registered</th>
						<th class="tc4" scope="col">Actions</th>
					</tr>
				</thead>
				<tbody>
<?php
$result = $db->query('SELECT * FROM accounts WHERE `type` = \'0\'') or error('Unable to fetch account info', __FILE__, __LINE__, $db->error());
if ($db->num_rows($result)) {
	while ($account_data = $db->fetch_assoc($result)) {
		$result2 = $db->query('SELECT * FROM '.$db->prefix.'users WHERE id = \''.$account_data['user_id'].'\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
		$user_data = $db->fetch_assoc($result2);
		$actions = '<a href="hosting.php?action=massdelete&id='.$account_data['user_id'].'">Delete</a>';
		$ordered = format_time($account_data['ordered'], true)
?>
					<tr>
						<td class="tcl"><?php echo '<a href="profile.php?id='.$user_data['id'].'">'.pun_htmlspecialchars($user_data['username']).'</a>' ?></td>
						<td class="tc2"><?php echo $account_data['domain'] ?></td>
						<td class="tc3"><?php echo $ordered ?></td>
						<td class="tc4"><?php echo $actions ?></td>
					</tr>
<?php
	}
}else{
	echo "\t\t\t\t\t".'<tr><td class="tcl" colspan="6">No users.</td></tr>'."\n";
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
