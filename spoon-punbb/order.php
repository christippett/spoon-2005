<?php
define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';


// If we are logged in, go to step 2
if (!$pun_user['is_guest']) {
	$step = 2;
}

// Load the register.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/order.php';

// Load the register.php/profile.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/prof_reg.php';

if ($pun_config['o_regs_allow'] == '0')
	message($lang_register['No new regs']);


// User pressed the cancel button
if (isset($_GET['cancel']))
	redirect('index.php', $lang_register['Reg cancel redirect']);


else if ($pun_config['o_rules'] == '1' && !isset($_GET['agree']) && !isset($_POST['form_sent']))
{
	$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / '.$lang_register['Register'];
	require PUN_ROOT.'header.php';

?>
<div class="blockform">
	<h2><span><?php echo $lang_register['Forum rules'] ?></span></h2>
	<div class="box">
		<form method="get" action="order.php">
			<div class="inform">
				<fieldset>
					<legend><?php echo $lang_register['Rules legend'] ?></legend>
					<div class="infldset">
						<p><?php echo $pun_config['o_rules_message'] ?></p>
					</div>
				</fieldset>
			</div>
			<p><input type="submit" name="agree" value="<?php echo $lang_register['Agree'] ?>" /><input type="submit" name="cancel" value="<?php echo $lang_register['Cancel'] ?>" /></p>
		</form>
	</div>
</div>
<?php

	require PUN_ROOT.'footer.php';
}

else if ($_POST['form_sent'] == 1)
{
	$username = pun_trim($_POST['req_username']);
	$email1 = strtolower(trim($_POST['req_email1']));

	if ($pun_config['o_regs_verify'] == '1')
	{
		$email2 = strtolower(trim($_POST['req_email2']));

		$password1 = random_pass(8);
		$password2 = $password1;
	}
	else
	{
		$password1 = trim($_POST['req_password1']);
		$password2 = trim($_POST['req_password2']);
	}

	// Convert multiple whitespace characters into one (to prevent people from registering with indistinguishable usernames)
	$username = preg_replace('#\s+#s', ' ', $username);

	// Validate username and passwords
	if (strlen($username) < 3)
		message($lang_prof_reg['Username too short']);
	else if (pun_strlen($username) > 25)	// This usually doesn't happen since the form element only accepts 25 characters
	    message($lang_common['Bad request']);
	else if (strlen($password1) < 4)
		message($lang_prof_reg['Pass too short']);
	else if ($password1 != $password2)
		message($lang_prof_reg['Pass not match']);
	else if (!strcasecmp($username, 'Guest') || !strcasecmp($username, $lang_common['Guest']))
		message($lang_prof_reg['Username guest']);
	else if (preg_match('/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/', $username))
		message($lang_prof_reg['Username IP']);
	else if ((strpos($username, '[') !== false || strpos($username, ']') !== false) && strpos($username, '\'') !== false && strpos($username, '"') !== false)
		message($lang_prof_reg['Username reserved chars']);
	else if (preg_match('#\[b\]|\[/b\]|\[u\]|\[/u\]|\[i\]|\[/i\]|\[color|\[/color\]|\[quote\]|\[quote=|\[/quote\]|\[code\]|\[/code\]|\[img\]|\[/img\]|\[url|\[/url\]|\[email|\[/email\]#i', $username))
		message($lang_prof_reg['Username BBCode']);

	// Check username for any censored words
	if ($pun_config['o_censoring'] == '1')
	{
		// If the censored username differs from the username
		if (censor_words($username) != $username)
			message($lang_register['Username censor']);
	}

	// Check that the username (or a too similar username) is not already registered
	$result = $db->query('SELECT username FROM '.$db->prefix.'users WHERE UPPER(username)=UPPER(\''.$db->escape($username).'\') OR UPPER(username)=UPPER(\''.$db->escape(preg_replace('/[^\w]/', '', $username)).'\')') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());

	if ($db->num_rows($result))
	{
		$busy = $db->result($result);
		message($lang_register['Username dupe 1'].' '.pun_htmlspecialchars($busy).'. '.$lang_register['Username dupe 2']);
	}


	// Validate e-mail
	require PUN_ROOT.'include/email.php';

	if (!is_valid_email($email1))
		message($lang_common['Invalid e-mail']);
	else if ($pun_config['o_regs_verify'] == '1' && $email1 != $email2)
		message($lang_register['E-mail not match']);

	// Check if it's a banned e-mail address
	if (is_banned_email($email1))
	{
		if ($pun_config['p_allow_banned_email'] == '0')
			message($lang_prof_reg['Banned e-mail']);

		$banned_email = true;	// Used later when we send an alert e-mail
	}
	else
		$banned_email = false;

	// Check if someone else already has registered with that e-mail address
	$dupe_list = array();

	$result = $db->query('SELECT username FROM '.$db->prefix.'users WHERE email=\''.$email1.'\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
	if ($db->num_rows($result))
	{
		if ($pun_config['p_allow_dupe_email'] == '0')
			message($lang_prof_reg['Dupe e-mail']);

		while ($cur_dupe = $db->fetch_assoc($result))
			$dupe_list[] = $cur_dupe['username'];
	}

	$timezone = intval($_POST['timezone']);
	$language = isset($_POST['language']) ? $_POST['language'] : $pun_config['o_default_lang'];
	$save_pass = (!isset($_POST['save_pass']) || $_POST['save_pass'] != '1') ? '0' : '1';

	$email_setting = intval($_POST['email_setting']);
	if ($email_setting < 0 || $email_setting > 2) $email_setting = 1;

	// Insert the new user into the database. We do this now to get the last inserted id for later use.
	$now = time();

	$intial_group_id = ($pun_config['o_regs_verify'] == '0') ? $pun_config['o_default_user_group'] : PUN_UNVERIFIED;
	$password_hash = pun_hash($password1);

	// Add the user
	$db->query('INSERT INTO '.$db->prefix.'users (username, group_id, password, email, email_setting, save_pass, timezone, language, style, registered, registration_ip, last_visit) VALUES(\''.$db->escape($username).'\', '.$intial_group_id.', \''.$password_hash.'\', \''.$email1.'\', '.$email_setting.', '.$save_pass.', '.$timezone.' , \''.$db->escape($language).'\', \''.$pun_config['o_default_style'].'\', '.$now.', \''.get_remote_address().'\', '.$now.')') or error('Unable to create user', __FILE__, __LINE__, $db->error());
	$new_uid = $db->insert_id();


	// If we previously found out that the e-mail was banned
	if ($banned_email && $pun_config['o_mailing_list'] != '')
	{
		$mail_subject = 'Alert - Banned e-mail detected';
		$mail_message = 'User \''.$username.'\' registered with banned e-mail address: '.$email1."\n\n".'User profile: '.$pun_config['o_base_url'].'/profile.php?id='.$new_uid."\n\n".'-- '."\n".'Forum Mailer'."\n".'(Do not reply to this message)';

		pun_mail($pun_config['o_mailing_list'], $mail_subject, $mail_message);
	}

	// If we previously found out that the e-mail was a dupe
	if (!empty($dupe_list) && $pun_config['o_mailing_list'] != '')
	{
		$mail_subject = 'Alert - Duplicate e-mail detected';
		$mail_message = 'User \''.$username.'\' registered with an e-mail address that also belongs to: '.implode(', ', $dupe_list)."\n\n".'User profile: '.$pun_config['o_base_url'].'/profile.php?id='.$new_uid."\n\n".'-- '."\n".'Forum Mailer'."\n".'(Do not reply to this message)';

		pun_mail($pun_config['o_mailing_list'], $mail_subject, $mail_message);
	}

	// Should we alert people on the admin mailing list that a new user has registered?
	if ($pun_config['o_regs_report'] == '1')
	{
		$mail_subject = 'Alert - New registration';
		$mail_message = 'User \''.$username.'\' registered in the forums at '.$pun_config['o_base_url']."\n\n".'User profile: '.$pun_config['o_base_url'].'/profile.php?id='.$new_uid."\n\n".'-- '."\n".'Forum Mailer'."\n".'(Do not reply to this message)';

		pun_mail($pun_config['o_mailing_list'], $mail_subject, $mail_message);
	}

	// Must the user verify the registration or do we log him/her in right now?
	if ($pun_config['o_regs_verify'] == '1')
	{
		// Load the "welcome" template
		$mail_tpl = trim(file_get_contents(PUN_ROOT.'lang/'.$pun_user['language'].'/mail_templates/welcome.tpl'));

		// The first row contains the subject
		$first_crlf = strpos($mail_tpl, "\n");
		$mail_subject = trim(substr($mail_tpl, 8, $first_crlf-8));
		$mail_message = trim(substr($mail_tpl, $first_crlf));

		$mail_subject = str_replace('<board_title>', $pun_config['o_board_title'], $mail_subject);
		$mail_message = str_replace('<base_url>', $pun_config['o_base_url'].'/', $mail_message);
		$mail_message = str_replace('<username>', $username, $mail_message);
		$mail_message = str_replace('<password>', $password1, $mail_message);
		$mail_message = str_replace('<login_url>', $pun_config['o_base_url'].'/login.php', $mail_message);
		$mail_message = str_replace('<board_mailer>', $pun_config['o_board_title'].' '.$lang_common['Mailer'], $mail_message);

		pun_mail($email1, $mail_subject, $mail_message);

		message($lang_register['Reg e-mail'], true);
	}

	pun_setcookie($new_uid, $password_hash, ($save_pass != '0') ? $now + 31536000 : 0);

	redirect('order.php?step=2', $lang_register['Reg complete']);
}


else if ($_POST['form_sent'] == 2)
{	
	$now = time();
	$id = $pun_user['id'];
	$result = $db->query('SELECT * FROM invoices WHERE user_id = \''.$id.'\'') or error('Unable to retrieve account invoice details', __FILE__, __LINE__, $db->error());
	while($invoices = $db->fetch_assoc($result)) {
		if($now > $invoices['due'])
			message($lang_common['Deny acct, invoice']);
	}
	if($_POST['req_domain'] != "www." && $_POST['req_domain'] != "") {
		if(!ereg("^[a-z]", $_POST['req_domain']))
			message("Domain must be in lower case.");
		$domain = format_domain($_POST['req_domain'], 1);
		$result = $db->query('SELECT domain FROM accounts WHERE domain = \''.$_POST['req_domain'].'\'') or error('Unable to fetch account info', __FILE__, __LINE__, $db->error());
		if ($db->num_rows($result)) {
			message($lang_prof_reg['Domain reserved']);
		}elseif($_POST['req_domainoptions'] == 1){
			if(!check_domain($_POST['req_domain']))
				message($lang_prof_reg['Domain registered']);
		}
	}else{
		message($lang_prof_reg['Empty domain']);
	}
	
	if(!$_POST['req_fname']) {
		message($lang_prof_reg['Empty fname']);
	}else if(!$_POST['req_lname']) {
		message($lang_prof_reg['Empty lname']);
	}elseif(!$_POST['req_address1']) {
		message($lang_prof_reg['Empty address1']);
	}elseif(!$_POST['req_city']) {
		message($lang_prof_reg['Empty city']);
	}
	$step = 3;
}
else if ($_POST['form_sent'] == 3)
{	
	require PUN_ROOT.'include/da_functions.php'; // CALL DA
	$now = time();

	$filter = array('!','@','#','$','%','^','&','*','(',')','-','_','.','+','=');
	$username = format_domain($_POST['req_domain'], 0);
	$username = str_replace($filter,"",$username);
	$username = substr($username, 0, 10);
	$likeusername = substr($username, 0, 9);
	$result = $db->query('SELECT * FROM accounts WHERE username LIKE \''.$likeusername.'%\'') or error('Unable to retrieve user details', __FILE__, __LINE__, $db->error());
	if($numrow = $db->num_rows($result)) {
		for ($i = 1; $i <= $numrow; $i++) {
		$replace = $i+1;
		$username = substr_replace($username, $replace, 9, 0);
		$username = substr($username, 0, 10);
		$result2 = $db->query('SELECT * FROM accounts WHERE username = \''.$username.'\'') or error('Unable to retrieve user details', __FILE__, __LINE__, $db->error());
		if(!$db->num_rows($result2)) 
			break;
		}
	}
	$domain = format_domain($_POST['req_domain'], 1);
	$email = $pun_user['email'];
	$password = random_pass(8);
	$package = plan($_POST['req_plan']);
	//
	// INSERT USING DA FUNCTION
	// ========================
	//
	$doit = $da->add_user($username,$email,$password,$domain,$package,"210.54.62.122");
	if($doit != 0) {
		message(substr($doit, 2));
	}
	$doit = $da->set_package_user($username,$package);
	//
	// MAKE account
	// ===========
	$db->query('INSERT INTO accounts (user_id, plan_id, type, ordered, domain, domain_reg, username, password, fname, lname, address1, address2, city, country) VALUES(\''.$pun_user['id'].'\', '.$_POST['req_plan'].', \'1\', \''.$now.'\', \''.$domain.'\', \''.$_POST['req_domainoptions'].'\', \''.$username.'\', \''.$password.'\',\''.$_POST['req_fname'].'\', \''.$_POST['req_lname'].'\', \''.$_POST['req_address1'].'\' , \''.$_POST['req_address2'].'\', \''.$_POST['req_city'].'\', \''.$_POST['req_country'].'\')') or error('Unable to create account', __FILE__, __LINE__, $db->error());
	$new_accountid = $db->insert_id();
	$db->query('UPDATE '.$db->prefix.'users SET hosting = \'1\' WHERE id = \''.$pun_user['id'].'\'') or error('Unable to create account', __FILE__, __LINE__, $db->error());
	
	//
	// RECURRING INVOICE
	// =================
	$next = $now+2419200;
	$db->query('INSERT INTO recurrings (`account_id`, `user_id`, `amount`, `next`, `desc`, `type`, `active`) VALUES (\''.$new_accountid.'\', \''.$pun_user['id'].'\',\''.$_POST['price'].'\', \''.$next.'\', \'SPOON Hosting\', \'1\', \'1\')') or error('Unable to create account', __FILE__, __LINE__, $db->error());
	$new_rid = $db->insert_id();
	//
	// MAKE INVOICE
	// ============
	// Hosting
	$new_invoice['account_id'] = $new_accountid;
	$new_invoice['user_id'] = $pun_user['id'];
	$new_invoice['recurring_id'] = $new_rid;
	$new_invoice['type'] = 1;
	$new_invoice['active'] = 1;
	$new_invoice['status'] = 0; // Due
	$new_invoice['total'] = $_POST['price'];
	$new_invoice['desc'] = "SPOON Hosting";
	$new_invoice['issued'] = $now;
	$new_invoice['due'] = $now;
	
	$new_invoice['domain'] = $_POST['req_domain'];
	$new_invoice['fname'] = $_POST['req_fname'];
	$new_invoice['lname'] = $_POST['req_lname'];
	$new_invoice['address1'] = $_POST['req_address1'];
	$new_invoice['address2'] = $_POST['req_address2'];
	$new_invoice['city'] = $_POST['req_city'];
	$new_invoice['country'] = $_POST['req_country'];

	$db->query('INSERT INTO invoices (account_id, user_id, recurring_id, type, active, status, total, `desc`, issued, due, domain, fname, lname, address1, address2, city, country) VALUES (\''.$new_invoice['account_id'].'\', \''.$new_invoice['user_id'].'\',\''.$new_invoice['recurring_id'].'\', \''.$new_invoice['type'].'\', \''.$new_invoice['active'].'\', \''.$new_invoice['status'].'\',\''.$new_invoice['total'].'\', \''.$new_invoice['desc'].'\',\''.$new_invoice['issued'].'\', \''.$new_invoice['due'].'\', \''.$new_invoice['domain'].'\', \''.$new_invoice['fname'].'\', \''.$new_invoice['lname'].'\', \''.$new_invoice['address1'].'\', \''.$new_invoice['address2'].'\', \''.$new_invoice['city'].'\', \''.$new_invoice['country'].'\')') or error('Unable to insert invoice data', __FILE__, __LINE__, $db->error());
	//
	// MAKE INVOICE
	// ============
	// Domain (opt)
	if($_POST['req_domainoptions']) {
		$next = $now+31536000;
	$db->query('INSERT INTO recurrings (`account_id`, `user_id`, `amount`, `next`, `desc`, `type`, `active`) VALUES (\''.$new_accountid.'\', \''.$pun_user['id'].'\',\''.$_POST['price'].'\', \''.$next.'\', \'SPOON Hosting\', \'2\', \'1\')') or error('Unable to create account', __FILE__, __LINE__, $db->error());
		$new_rid = $db->insert_id();

		$new_invoice['account_id'] = $new_accountid;
		$new_invoice['user_id'] = $pun_user['id'];
		$new_invoice['recurring_id'] = $new_rid;
		$new_invoice['type'] = 2;
		$new_invoice['active'] = 1;
		$new_invoice['status'] = 0; // Due
		$new_invoice['total'] = $_POST['domain'];
		$new_invoice['desc'] = "SPOON Domain: ".$_POST['req_domain'];
		$new_invoice['issued'] = $now;
		$new_invoice['due'] = $now;
		
		$new_invoice['domain'] = $_POST['req_domain'];
		$new_invoice['fname'] = $_POST['req_fname'];
		$new_invoice['lname'] = $_POST['req_lname'];
		$new_invoice['address1'] = $_POST['req_address1'];
		$new_invoice['address2'] = $_POST['req_address2'];
		$new_invoice['city'] = $_POST['req_city'];
		$new_invoice['country'] = $_POST['req_country'];
	
		$db->query('INSERT INTO invoices (account_id, user_id, recurring_id, type, active, status, total, `desc`, issued, due, domain, fname, lname, address1, address2, city, country) VALUES (\''.$new_invoice['account_id'].'\', \''.$new_invoice['user_id'].'\',\''.$new_invoice['recurring_id'].'\', \''.$new_invoice['type'].'\', \''.$new_invoice['active'].'\', \''.$new_invoice['status'].'\',\''.$new_invoice['total'].'\', \''.$new_invoice['desc'].'\',\''.$new_invoice['issued'].'\', \''.$new_invoice['due'].'\', \''.$new_invoice['domain'].'\', \''.$new_invoice['fname'].'\', \''.$new_invoice['lname'].'\', \''.$new_invoice['address1'].'\', \''.$new_invoice['address2'].'\', \''.$new_invoice['city'].'\', \''.$new_invoice['country'].'\')') or error('Unable to insert invoice data', __FILE__, __LINE__, $db->error());
	}
	// EMAIL account
	// ============
	// The first row contains the subject.
	$mail_tpl = trim(file_get_contents(PUN_ROOT.'lang/'.$pun_user['language'].'/mail_templates/order.tpl'));

	$first_crlf = strpos($mail_tpl, "\n");
	$mail_subject = trim(substr($mail_tpl, 8, $first_crlf-8));
	$mail_message = trim(substr($mail_tpl, $first_crlf));

	$mail_subject = str_replace('<spoon_domain>', $domain, $mail_subject);
	$mail_message = str_replace('<base_url>', $pun_config['o_base_url'].'/', $mail_message);
	$mail_message = str_replace('<id>', $pun_user['id'], $mail_message);
	$mail_message = str_replace('<spoon_domain>', $domain, $mail_message);
	$mail_message = str_replace('<username>', $username, $mail_message);
	$mail_message = str_replace('<password>', $password, $mail_message);
	require PUN_ROOT.'include/email.php';
	pun_mail($email, $mail_subject, $mail_message);
	$activation_message = "<p><strong>Thank you for your order!</strong></p><p>Your account is active and ready for use. For verification purposes, your username and password have been emailed to you.</p><br /><p>Your account is in debit! For more information on how to pay and to view your current invoices, please <a href=\"invoice.php?id=".$pun_user['id']."\">click here</a>.</p>";
	message($activation_message, true);
}
if ($step == 2)
{
	$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / '.$lang_register['Register'];
	$focus_element = array('register', 'req_domain');
	require PUN_ROOT.'header.php';
?>
<div class="blockform">
	<h2><span><?php echo $lang_register['Register'] ?></span></h2>
	<div class="box">
		<form id="register" method="post" action="order.php" onsubmit="this.register.disabled=true;if(process_form(this)){return true;}else{this.register.disabled=false;return false;}">
			<div class="inform">
				<fieldset>
					<legend>Hosting details</legend>
					<div class="infldset">
						<input type="hidden" name="form_sent" value="2" />
						<label><strong>Plan</strong><br />
							<select name="req_plan">
							  <option value="1" selected>Plan 01</option>
							  <option value="2">Plan 02</option>
							  <option value="3">Plan 03</option>
							</select><br />
						</label>
						<label><strong>Domain</strong><br /><input name="req_domain" type="text" value="" size="35" maxlength="50" /><br /></label>
						<div class="rbox">
						<label><input name="req_domainoptions" type="radio" class="radio" value="1" checked />I want SPOON to register my domain</span><br /></label>
						<label><input name="req_domainoptions" type="radio" value="0" class="radio" />I am transferring my own domain</span></label>			
						</div>
					</div>
				</fieldset>
			</div>
			<div class="inform">
				<fieldset>
					<legend>Enter your personal details</legend>
					<div class="infldset">
						<label><strong>First Name</strong><br /><input type="text" name="req_fname" size="40" maxlength="40" /><br /></label>
						<label><strong>Last Name</strong><br /><input type="text" name="req_lname" size="40" maxlength="40" /><br /></label>
					</div>
				</fieldset>
			</div>
			<div class="inform">
				<fieldset>
					<legend>Enter your contact details</legend>
					<div class="infldset">
						<label><strong>Address</strong><br /><input type="text" name="req_address1" size="30" maxlength="35" /><br /></label>
						<label><input type="text" name="req_address2" size="30" maxlength="35" /><br /></label>
						<label><strong>City</strong><br /><input type="text" name="req_city" size="30" maxlength="35" /><br /></label>
						<label><strong>Country</strong><br /><? countrylist("req_country") ?><br /></label>
					</div>
				</fieldset>
			</div>
			<p><input type="submit" name="register" value="Order -> Invoice & Payment Details" /></p>
		</form>
	</div>
</div>

<?php
	require PUN_ROOT.'footer.php';
	
}
elseif ($step == 3)
{
$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / '.$lang_register['Register'];
require PUN_ROOT.'header.php';
$result = $db->query('SELECT * FROM '.$db->prefix.'plans WHERE id = \''.$_POST['req_plan'].'\'') or error('Unable to fetch account info', __FILE__, __LINE__, $db->error());
$plan = $db->fetch_assoc($result);
$plan['bandwidth'] = mbgb($plan['bandwidth']);
$plan['diskspace'] = mbgb($plan['diskspace']);
if($_POST['req_domainoptions']) {
	$price['domain'] = 35;
	$price['total'] = $price['domain'] + $plan['price'];
	$price['domain'] = num_format($price['domain']);
	$price['domain'] = "$".$price['domain']." /per year";
}else{
	$price['domain'] = "-";
	$price['total'] = $plan['price'];
}	
$price['total'] = num_format($price['total']);
?>
<div id="invoice" class="blocktable">
	<div class="box">
		<div class="inbox">
			<table cellspacing="0">
			<thead>
				<tr>
					<th class="tcl" scope="col">Confirm Details</th>
					<th class="tc2" scope="col"></th>
					<th class="tc3" scope="col"></th>
				</tr>
			</thead>
	
			<tbody>
				<tr>
					<td class="tcl">Domain</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$_POST['req_domain']?></td>
				</tr>
				<tr>
					<td class="tcl">First name</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$_POST['req_fname']?></td>
				</tr>
				<tr>
					<td class="tcl">Last Name</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$_POST['req_lname']?></td>
				</tr>
				<tr>
					<td class="tcl">Address</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$_POST['req_address1']?><br /><?=$_POST['req_address2']?></td>
				</tr>
				<tr>
					<td class="tcl">City</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$_POST['req_city']?></td>
				</tr>
				<tr>
					<td class="tcl">Country</td>
					<td class="tc2"></td>
					<td class="tc3"><?=$_POST['req_country']?></td>
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
					<th class="tcl" scope="col">Invoice</th>
					<th class="tc2" scope="col"></th>
					<th class="tc3" scope="col"></th>
				</tr>
			</thead>
	
			<tbody>
				<tr>
					<td class="tcl"><?=$plan['plan_name']?></td>
					<td class="tc2">
					Disk space<br />
					Bandwidth<br />
					Price
					</td>
					<td class="tc3">
					<?=$plan['diskspace']?><br />
					<?=$plan['bandwidth']?><br />
					$<?=$plan['price']?> /per month
					</td>
				</tr>
				<tr>
					<td class="tcl">Domain</td>
					<td class="tc2"><?=$_POST['req_domain']?></td>
					<td class="tc3"><?=$price['domain']?></td>
				</tr>
			</tbody>
			</table>

		</div>		
	</div>
</div>
<div id="invoice" class="block">
	<div class="box">
		<div class="inbox">
			<form id="accept" method="post" action="order.php" onsubmit="this.accept.disabled=true;if(process_form(this)){return true;}else{this.accept.disabled=false;return false;}">
			<input name="req_plan" type="hidden" value="<?=$_POST['req_plan']?>" />
			<input name="req_domain" type="hidden" value="<?=$_POST['req_domain']?>">
			<input name="req_domainoptions" type="hidden" value="<?=$_POST['req_domainoptions']?>" />
			<input name="req_fname" type="hidden" value="<?=$_POST['req_fname']?>" />
			<input name="req_lname" type="hidden" value="<?=$_POST['req_lname']?>" />
			<input name="req_address1" type="hidden" value="<?=$_POST['req_address1']?>" />
			<input name="req_address2" type="hidden" value="<?=$_POST['req_address2']?>" />
			<input name="req_city" type="hidden" value="<?=$_POST['req_city']?>" />
			<input name="req_country" type="hidden" value="<?=$_POST['req_country']?>" />
			<input name="price" type="hidden" value="<?=$plan['price']?>" />
			<input name="domain" type="hidden" value="35" />
			<input type="hidden" name="form_sent" value="3" />
			<table cellspacing="0">
			<tbody>
				<tr>
					<td class="tcl"><input type="submit" name="accept" value="Accept" /></td>
					<td class="tc2"><strong>Total</strong></td>
					<td class="tc3">$<?=$price['total']?><br /><em>($<?=$plan['price']?> per month)</em></td>
				</tr>			
			</tbody>
			</table>
			</form>	
		</div>		
	</div>
</div>	
<?php
	require PUN_ROOT.'footer.php';
}else{

$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / '.$lang_register['Register'];
$required_fields = array('req_username' => $lang_common['Username'], 'req_password1' => $lang_common['Password'], 'req_password2' => $lang_prof_reg['Confirm pass'], 'req_email1' => $lang_common['E-mail'], 'req_email2' => $lang_common['E-mail'].' 2');
$focus_element = array('register', 'req_username');
require PUN_ROOT.'header.php';

?>
<div class="blockform">
	<h2><span>Invoice for <?=$accounts['domain']?></span></h2>
	<div class="box">
		<form id="register" method="post" action="order.php?action=register" onsubmit="this.register.disabled=true;if(process_form(this)){return true;}else{this.register.disabled=false;return false;}">
			<div class="inform">
				<fieldset>
					<legend><?php echo $lang_register['Username legend'] ?></legend>
					<div class="infldset">
						<input type="hidden" name="form_sent" value="1" />
						<label><strong><?php echo $lang_common['Username'] ?></strong><br /><input type="text" name="req_username" size="25" maxlength="25" /><br /></label>
					</div>
				</fieldset>
			</div>
<?php if ($pun_config['o_regs_verify'] == '0'): ?>			<div class="inform">
				<fieldset>
					<legend><?php echo $lang_register['Pass legend 1'] ?></legend>
					<div class="infldset">
						<label class="conl"><strong><?php echo $lang_common['Password'] ?></strong><br /><input type="password" name="req_password1" size="16" maxlength="16" /><br /></label>
						<label class="conl"><strong><?php echo $lang_prof_reg['Confirm pass'] ?></strong><br /><input type="password" name="req_password2" size="16" maxlength="16" /><br /></label>
						<p class="clearb"><?php echo $lang_register['Pass info'] ?></p>
					</div>
				</fieldset>
			</div>
<?php endif; ?>			<div class="inform">
				<fieldset>
					<legend><?php echo ($pun_config['o_regs_verify'] == '1') ? $lang_prof_reg['E-mail legend 2'] : $lang_prof_reg['E-mail legend'] ?></legend>
					<div class="infldset">
<?php if ($pun_config['o_regs_verify'] == '1'): ?>			<p><?php echo $lang_register['E-mail info'] ?></p>
<?php endif; ?>					<label><strong><?php echo $lang_common['E-mail'] ?></strong><br />
						<input type="text" name="req_email1" size="50" maxlength="50" /><br /></label>
<?php if ($pun_config['o_regs_verify'] == '1'): ?>						<label><strong><?php echo $lang_register['Confirm e-mail'] ?></strong><br />
						<input type="text" name="req_email2" size="50" maxlength="50" /><br /></label>
<?php endif; ?>					</div>
				</fieldset>
			</div>
			<input name="save_pass" type="hidden" value="1">
			<input name="email_setting" type="hidden" value="1">
			<input name="timezone" type="hidden" value="12">
			<p><input type="submit" name="register" value="Order -> Hosting & Personal Details" /></p>
		</form>
	</div>
</div>
<?php

require PUN_ROOT.'footer.php';
}