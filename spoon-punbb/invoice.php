<?php
define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';


$action = isset($_GET['action']) ? $_GET['action'] : null;
$section = isset($_GET['section']) ? $_GET['section'] : null;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$spoon_id = $_GET['spoon_id'];
if ($id < 2)
	message($lang_common['Bad request']);

if ($pun_user['g_read_board'] == '0')
	message($lang_common['No view']);

authaccount($id);
// Load the profile.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/profile.php';
// Load the profile.php/register.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/prof_reg.php';

if(isset($_GET['action'])) {
	//
	// DELETE RECURRING INVOICE
	//
	if($_GET['action'] == "delete" && isset($_GET['recurring_id'])) {
		if ($pun_user['g_id'] >= PUN_MOD)
			message($lang_common['No permission']);
		if(isset($_POST['form_sent'])) {
			$db->query('DELETE FROM recurrings WHERE id = \''.$_GET['recurring_id'].'\'') or error('Unable to delete invoice', __FILE__, __LINE__, $db->error());
			redirect('invoice.php?id='.$id, $lang_profile['Invoice delete redirect']);
		}
		$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Delete Recurring Invoice';
		require PUN_ROOT.'header.php';

?>
<div class="blockform">
	<h2><span>Delete Recurring Invoice</span></h2>
	<div class="box">
		<form id="confirm_del_invoice" method="post" action="invoice.php?action=delete&recurring_id=<?=$_GET['recurring_id']?>&id=<?=$id?>">
			<div><input type="hidden" name="form_sent" value="1" /></div>
			<div class="inform">
				<fieldset>
					<legend>Important: read before deleting invoice</legend>
					<div class="infldset">
						<p>Are you sure you wish to delete this invoice?</p>
						<p class="warntext"><strong>Once deleted, no more invoices will automatically be issued!</strong></p>

					</div>
				</fieldset>
			</div>
			<p><input type="submit" name="delete_invoice_comply" value="Delete" /><a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a></p>
		</form>
	</div>
</div>

<?php
	require PUN_ROOT.'footer.php';
	}
	//
	// DELETE INVOICE
	//
	if($_GET['action'] == "delete" && isset($_GET['invoice_id'])) {
		if ($pun_user['g_id'] >= PUN_MOD)
			message($lang_common['No permission']);
		if(isset($_POST['form_sent'])) {
			$db->query('DELETE FROM invoices WHERE id = \''.$_GET['invoice_id'].'\'') or error('Unable to delete invoice', __FILE__, __LINE__, $db->error());
			redirect('invoice.php?id='.$id, $lang_profile['Invoice delete redirect']);
		}
		$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Delete Invoice #'.$_GET['invoice_id'];
		require PUN_ROOT.'header.php';

?>
<div class="blockform">
	<h2><span>Delete Invoice #<?=$_GET['invoice_id']?></span></h2>
	<div class="box">
		<form id="confirm_del_invoice" method="post" action="invoice.php?action=delete&invoice_id=<?=$_GET['invoice_id']?>&id=<?=$id?>">
			<div><input type="hidden" name="form_sent" value="1" /></div>
			<div class="inform">
				<fieldset>
					<legend>Important: read before deleting invoice</legend>
					<div class="infldset">
						<p>Are you sure you wish to delete this invoice?</p>
					</div>
				</fieldset>
			</div>
			<p><input type="submit" name="delete_invoice_comply" value="Delete" /><a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a></p>
		</form>
	</div>
</div>

<?php
	require PUN_ROOT.'footer.php';
	}
	//
	// VIEW INVOICE
	//
	if($_GET['action'] == "view" && isset($_GET['invoice_id'])) {
	$result = $db->query('SELECT * FROM invoices WHERE (id = \''.$_GET['invoice_id'].'\' AND user_id = \''.$id.'\')') or error('Unable to fetch invoice/account info', __FILE__, __LINE__, $db->error());
	if (!$db->num_rows($result))
		message($lang_common['Bad request']);
	$invoice_data = $db->fetch_assoc($result);
	$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Invoice #'.$_GET['invoice_id'];
	require PUN_ROOT.'header.php';
	$invoice_data['issued'] = date("d/m/y",$invoice_data['issued']);
	$invoice_data['due'] = date("d/m/y",$invoice_data['due']);
	// Status
	if		($invoice_data['status'] == 0) {
		// DUE
		$status = "<span style=\"color: #3B951F; font-weight: bold\">DUE</span>";
	}elseif	($invoice_data['status'] == 1) {
		// PAID
		$status = "<span style=\"color: #03396F; font-weight: bold\">PAID</span>";
	}elseif	($invoice_data['status'] == 2) {
		$status = "<span style=\"color: #CE2424; font-weight: bold\">OVERDUE</span>";
	}
	if ($pun_user['g_id'] < PUN_MOD) {
?>
<div id="admin_invoice" class="block">
	<div class="box">
		<div id="total" class="inbox">
			<table cellspacing="0">
			<tbody>
				<tr>
					<td class="tcl"><a href="#">Edit Invoice</a></td>
					<td class="tc2"><a href="invoice.php?action=delete&invoice_id=<?=$_GET['invoice_id']?>&id=<?=$id?>">Delete Invoice</a></td>
					<td class="tc3"><a href="#">Pay Invoice</a></td>
				</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>
<?php
	}
?>
<div id="invoice" class="blocktable">
	<div class="box">
		<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col">Account Details</th>
					<th class="tc2" scope="col">(<?=$status?>)</th>
					<th class="tc3" scope="col"></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="tcl">Domain</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$invoice_data['domain']?></td>
				</tr>
				<tr>
					<td class="tcl">First name</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$invoice_data['fname']?></td>
				</tr>
				<tr>
					<td class="tcl">Last Name</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$invoice_data['lname']?></td>
				</tr>
				<tr>
					<td class="tcl">Address</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$invoice_data['address1']?><br /><?=$invoice_data['address2']?></td>
				</tr>
				<tr>
					<td class="tcl">City</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$invoice_data['city']?></td>
				</tr>
				<tr>
					<td class="tcl">Country</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$invoice_data['country']?></td>
				</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>
<div id="invoice" class="blocktable">
	<div class="box">
		<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" colspan="3">Description</th>

				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="tcl">Issue date</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$invoice_data['issued']?></td>
				</tr>
				<tr>
					<td class="tcl">Due date</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$invoice_data['due']?></td>
				</tr>
<?php
	if (!$invoice_data['active']) {
		$invoice_data['closed'] = date("d/m/y",$invoice_data['closed']);
?>
				<tr>
					<td class="tcl">Closure date</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$invoice_data['closed']?></td>
				</tr>
<?php
	}
?>
				<tr>
					<td class="tc2" colspan="3"><strong>Description</strong><br /><p><?=$invoice_data['desc']?></p></td>
				</tr>
			</tbody>
			</table>

		</div>
	</div>
</div>

<div id="invoice" class="block">
	<div class="box">
		<div id="total" class="inbox">
			<table cellspacing="0">
			<tbody>
				<tr>
					<td class="tcl"></td>
					<td class="tc2">Total</td>
					<td class="tc3">$<?=$invoice_data['total']?></td>
				</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>

<?php
	require PUN_ROOT.'footer.php';
	}
}
$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Invoices';
require PUN_ROOT.'header.php';

generate_profile_menu('invoice');

?>
	<div class="block">
		<h2>Payment Information</h2>
		<div id="description" class="box">
			<div class="inbox">
				<p>
					Always use the invoice number as a reference when making any payments. This makes our lives easier, and your invoices processed faster.
				</p>
				<p>
					<dl>
						<dt><strong>Bank Transfer</strong><br />Bank:<br />Name:<br />Account #:<br /></dt>
						<dd><br />National Bank<br />Chris Tippett<br />06-0622-0036147-00</dd>
					</dl>
				</p>
			</div>
		</div>
	</div>
	<div id="listinvoice" class="blocktable">
	<h2><span>Due Invoices</span></h2>
	<div class="box">
		<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col">#</th>
					<th class="tc2" scope="col">Domain</th>
					<th class="tc3" scope="col">Total</th>
					<th class="tc4" scope="col">Actions</th>
				</tr>
			</thead>
			<tbody>
<?php
$result = $db->query('SELECT * FROM invoices WHERE (invoices.active = \'1\' AND invoices.user_id = \''.$id.'\') ORDER BY \'id\' DESC') or error('Unable to fetch invoice/account info', __FILE__, __LINE__, $db->error());
if ($db->num_rows($result)) {
	while ($invoice_data = $db->fetch_assoc($result)) {
		$actions = '<a href="invoice.php?action=view&id='.$id.'&invoice_id='.$invoice_data['id'].'">View</a>';
?>
				<tr>
					<td class="tcl"><?=$invoice_data['id']?></td>
					<td class="tc2"><?=$invoice_data['domain']?></td>
					<td class="tc3">$<?=$invoice_data['total']?></td>
					<td class="tc4"><?=$actions?></td>
				</tr>
<?php
	}
}else{
	echo "\t\t\t\t\t".'<tr><td class="tcl" colspan="6">No invoice data to show.</td></tr>'."\n";
}
?>
			</tbody>
			</table>
		</div>
	</div>
</div>
<?php

require PUN_ROOT.'footer.php';
