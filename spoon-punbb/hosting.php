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

//
// CHECK AUTHORIZATION
//	
$result = $db->query('SELECT * FROM '.$db->prefix.'users WHERE id=\''.$id.'\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
$temp = $db->fetch_assoc($result);
$email = $temp['email'];
$hosting = $temp['hosting'];
$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE user_id=\''.$id.'\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
$temp = $db->fetch_assoc($result);
if ($hosting) {
	if (!$db->num_rows($result))
		message($lang_common['Bad request']);
	if ($temp['user_id'] != $pun_user['id'] && $pun_user['g_id'] > PUN_MOD)
		message($lang_common['No permission']);
	if (($db->num_rows($result) == 1) && ($spoon_id != $temp[id]) && isset($spoon_id))
		message($lang_common['Bad request']);
}else{
	if ($pun_user['id'] != $id && $pun_user['g_id'] > PUN_MOD)
		message($lang_common['No permission']);
	if (isset($spoon_id) && ($spoon_id != $temp[id]))
		message($lang_common['Bad request']);
}

// Load the profile.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/profile.php';

if(isset($_GET['action'])) {
	//
	// ACTION: CREATE FREE ACCOUNT
	//
	if($_GET['action'] == "activate" && isset($_POST['form_sent'])) {
		// Direct admin username's only allow lowercase a-z, between 3-10 characters long. This ereg pattern checks to make sure
		// ths is true.
		if(!ereg("^[a-z]{3,10}",$_POST['subdomain']))
			message("Your domain may only contain the characters \"a-z\" (lower case) and must be between 3 and 10 characters long.");
		$password = random_pass(8);
		
		$username = substr($_POST['subdomain'], 0, 10);
		$likeusername = substr($username, 0, 9);
		$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE username LIKE \''.$likeusername.'%\'') or error('Unable to retrieve user details', __FILE__, __LINE__, $db->error());
		if($numrow = $db->num_rows($result)) {
			for ($i = 1; $i <= $numrow; $i++) {
			$replace = $i+1;
			$username = substr_replace($username, $replace, 9, 0);
			$username = substr($username, 0, 10);
			$result2 = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE username = \''.$username.'\'') or error('Unable to retrieve user details', __FILE__, __LINE__, $db->error());
			if(!$db->num_rows($result2)) 
				break;
			}
		}
		
		$package = plan($_POST['plan']);
		$domain = $_POST['domain'];
		$domainfull = $_POST['subdomain'].".".$_POST['domain'];
		$now = time();
		// Check subdomain doesn't already exist
		$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE domain = \''.$domainfull.'\'') or error('Unable to modify user info', __FILE__, __LINE__, $db->error());
		if($db->num_rows($result))
			message("That sub-domain already exists. Please go back and try again.");
		// DIRECT ADMIN
		require PUN_ROOT.'include/da_functions.php'; // CALL DA
		$doit = $da->add_user($username,$email,$password,$domainfull,$package,"210.54.62.122");
		if($doit != 0) {
			message(substr($doit,2).".");
		}
		$doit = $da->set_package_user($username,$package);
		// DO IIEEETT
		$result = $db->query('INSERT INTO '.$db->prefix.'clients (user_id, plan_id, type, ordered, domain, domain_reg, username, password) VALUES (\''.$id.'\', \'0\', \'0\', \''.$now.'\', \''.$domainfull.'\', \'0\', \''.$username.'\', \''.$password.'\')') or error('Unable to modify user info', __FILE__, __LINE__, $db->error());
		$result = $db->query('UPDATE '.$db->prefix.'users SET hosting = \'1\' WHERE id=\''.$id.'\'') or error('Unable to modify user info 2', __FILE__, __LINE__, $db->error());

		$mail_tpl = trim(file_get_contents(PUN_ROOT.'lang/'.$pun_user['language'].'/mail_templates/activate.tpl'));

		// The first row contains the subject
		$first_crlf = strpos($mail_tpl, "\n");
		$mail_subject = trim(substr($mail_tpl, 8, $first_crlf-8));
		$mail_message = trim(substr($mail_tpl, $first_crlf));
	
		$mail_subject = str_replace('<spoon_domainfull>', $domainfull, $mail_subject);
		$mail_message = str_replace('<base_url>', $pun_config['o_base_url'].'/', $mail_message);
		$mail_message = str_replace('<spoon_domainfull>', $domainfull, $mail_message);
		$mail_message = str_replace('<spoon_domain>', $domain, $mail_message);
		$mail_message = str_replace('<username>', $username, $mail_message);
		$mail_message = str_replace('<password>', $password, $mail_message);
		require PUN_ROOT.'include/email.php';
		pun_mail($email, $mail_subject, $mail_message);
		$activation_message = "Your free SPOON is now activated! For verification purposes, your password has been emailed to you.";
		message($activation_message, true);

	//
	// ACTION: RESET PASSWORD / RE-SEND EMAIL
	//
	}elseif ($_GET['action'] == "reset" && isset($_POST['form_sent'])) {
		require PUN_ROOT.'include/da_functions.php'; // CALL DA
		$password = random_pass(8);
		$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE id = \''.$spoon_id.'\'') or error('Unable to retrieve user info', __FILE__, __LINE__, $db->error());
		$client_data = $db->fetch_assoc($result);
		$da->change_password($client_data['username'], $password);
		$result = $db->query('UPDATE '.$db->prefix.'clients SET password=\''.$password.'\' WHERE id = \''.$spoon_id.'\'') or error('Unable to modify user info', __FILE__, __LINE__, $db->error());
						
		$mail_tpl = trim(file_get_contents(PUN_ROOT.'lang/'.$pun_user['language'].'/mail_templates/spoon_password.tpl'));

		// The first row contains the subject
		$first_crlf = strpos($mail_tpl, "\n");
		$mail_subject = trim(substr($mail_tpl, 8, $first_crlf-8));
		$mail_message = trim(substr($mail_tpl, $first_crlf));

		$mail_subject = str_replace('<spoon_domainfull>', $client_data['domain'], $mail_subject);
		$mail_message = str_replace('<base_url>', $pun_config['o_base_url'].'/', $mail_message);
		$mail_message = str_replace('<spoon_domainfull>', $client_data['domain'], $mail_message);
		$mail_message = str_replace('<spoon_domain>', "spoon.net.nz", $mail_message);
		$mail_message = str_replace('<username>', $client_data['username'], $mail_message);
		$mail_message = str_replace('<password>', $password, $mail_message);
		require PUN_ROOT.'include/email.php';
		pun_mail($email, $mail_subject, $mail_message);
		$activation_message = "Your free SPOON is now activated! For verification purposes, your password has been emailed to you.";
		message($activation_message, true);
	//
	// ADMIN ONLY - DELETE ALL DOMAINS
	//
	}elseif ($_GET['action'] == "massdelete") {
		if($pun_user['g_id'] > PUN_MOD) // forbid normal users deleting domains
			message($lang_common['No permission']);
		if(isset($_POST['form_sent'])) {
			require PUN_ROOT.'include/da_functions.php'; // CALL DA
			$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE user_id='.$id) or error('Unable to retrieve user details', __FILE__, __LINE__, $db->error());
			while($client_data = $db->fetch_assoc($result)) {
				$da->delete_user($client_data['username']);
			}
			// other stuff:
			$db->query('DELETE FROM '.$db->prefix.'clients WHERE user_id='.$id) or error('Unable to delete user', __FILE__, __LINE__, $db->error());
			$db->query('UPDATE '.$db->prefix.'users SET hosting = \'0\' WHERE id='.$id) or error('Unable to delete user', __FILE__, __LINE__, $db->error());
	
			redirect('admin_free.php', $lang_profile['User delete redirect']);
		}else{
			$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Delete SPOON';
			define('PUN_ALLOW_INDEX', 1);
			require PUN_ROOT.'header.php';

?>
<div class="blockform">
	<h2><span><?php echo $lang_profile['Confirm delete user'] ?></span></h2>
	<div class="box">
		<form id="confirm_del_user" method="post" action="hosting.php?action=massdelete&id=<?php echo $id ?>">
			<div><input type="hidden" name="form_sent" value="1" /></div>
			<div class="inform">
				<fieldset>
					<legend><?php echo $lang_profile['Confirm delete legend'] ?></legend>
					<div class="infldset">
						<p>Are you sure you wish to delete this user's SPOONs?</p>
						<p class="warntext"><strong>All hosting accounts under this user will be deleted, and all data lost. Remember, you can delete individual accounts if necessary.</strong></p>
					</div>
				</fieldset>
			</div>
			<p><input type="submit" name="delete_user_comply" value="<?php echo $lang_profile['Delete'] ?>" /><a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a></p>
		</form>
	</div>
</div>
<?php
			require PUN_ROOT.'footer.php';
		}
	//
	// ADMIN ONLY - DELETE ONE DOMAIN
	//
	}elseif ($_GET['action'] == "delete") {
		if($pun_user['g_id'] > PUN_MOD) // forbid normal users deleting domains
			message($lang_common['No permission']);
		if(isset($_POST['form_sent'])) {
			require PUN_ROOT.'include/da_functions.php'; // CALL DA
			$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE id='.$spoon_id) or error('Unable to retrieve user details', __FILE__, __LINE__, $db->error());
			$client_data = $db->fetch_assoc($result);
			$da->delete_user($client_data['username']);
			// other stuff:
			$db->query('DELETE FROM '.$db->prefix.'clients WHERE id='.$spoon_id) or error('Unable to delete user', __FILE__, __LINE__, $db->error());
			$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE user_id='.$id) or error('Unable to retrieve user details', __FILE__, __LINE__, $db->error());
			if(!$db->num_rows($result))
				$db->query('UPDATE '.$db->prefix.'users SET hosting = \'0\' WHERE id='.$id) or error('Unable to delete user', __FILE__, __LINE__, $db->error());
	
			redirect('hosting.php?id='.$id, $lang_profile['User delete redirect']);
		}else{
			$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Delete SPOON';
			define('PUN_ALLOW_INDEX', 1);
			require PUN_ROOT.'header.php';
?>
<div class="blockform">
	<h2><span><?php echo $lang_profile['Confirm delete user'] ?></span></h2>
	<div class="box">
		<form id="confirm_del_user" method="post" action="hosting.php?action=delete&id=<?=$id?>&spoon_id=<?=$spoon_id?>">
			<div><input type="hidden" name="form_sent" value="1" /></div>
			<div class="inform">
				<fieldset>
					<legend><?php echo $lang_profile['Confirm delete legend'] ?></legend>
					<div class="infldset">
						<p>Are you sure you wish to delete this SPOON?</p>
						<p class="warntext"><strong>All data on this account will be deleted, including files, emails and settings. If you still wish to continue, press delete.</strong></p>
					</div>
				</fieldset>
			</div>
			<p><input type="submit" name="delete_user_comply" value="<?php echo $lang_profile['Delete'] ?>" /><a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a></p>
		</form>
	</div>
</div>
<?php
			require PUN_ROOT.'footer.php';
		}			
	//
	// ADMIN ONLY - SUSPEND DOMAIN
	//
	}elseif ($_GET['action'] == "suspend") {
		if($pun_user['g_id'] > PUN_MOD) // forbid normal users deleting domains
			message($lang_common['No permission']);
		if(isset($_POST['form_sent'])) {
			require PUN_ROOT.'include/da_functions.php'; // CALL DA
			$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE id='.$spoon_id) or error('Unable to retrieve user details', __FILE__, __LINE__, $db->error());
			$client_data = $db->fetch_assoc($result);
			$status = $da->is_suspended_user($client_data['username']);
			$da->suspend_user($client_data['username']);
			if($status == 0) {
				$db->query('UPDATE '.$db->prefix.'clients set type = \'2\' WHERE id='.$spoon_id) or error('Unable to delete user', __FILE__, __LINE__, $db->error());
			}else{
				if($client_data['plan_id'] == 0) {
					$db->query('UPDATE '.$db->prefix.'clients set type = \'0\' WHERE id='.$spoon_id) or error('Unable to delete user', __FILE__, __LINE__, $db->error());			
				}else{
					$db->query('UPDATE '.$db->prefix.'clients set type = \'1\' WHERE id='.$spoon_id) or error('Unable to delete user', __FILE__, __LINE__, $db->error());			
				}
			}
			redirect('hosting.php?id='.$id, "Suspended / un-suspended user. Redirecting ...");
		}else{
			$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE id='.$spoon_id) or error('Unable to retrieve user details', __FILE__, __LINE__, $db->error());
			$client_data = $db->fetch_assoc($result);
			$status = $da->is_suspended_user($client_data['username']);
			if ($status == 0) $status = "suspend";
			if ($status == 1) $status = "un-suspend";
			$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Suspend SPOON';
			define('PUN_ALLOW_INDEX', 1);
			require PUN_ROOT.'header.php';
?>
<div class="blockform">
	<h2><span>Action: <?=$status?></span></h2>
	<div class="box">
		<form id="confirm_del_user" method="post" action="hosting.php?action=suspend&id=<?=$id?>&spoon_id=<?=$spoon_id?>">
			<div><input type="hidden" name="form_sent" value="1" /></div>
			<div class="inform">
				<fieldset>
					<legend><?=$client_data['domain']?></legend>
					<div class="infldset">
						<p>Are you sure you wish to <?=$status?> this SPOON?</p>
					</div>
				</fieldset>
			</div>
			<p><input type="submit" name="suspend_user_comply" value="Suspend / un-suspend" /><a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a></p>
		</form>
	</div>
</div>
<?php
			require PUN_ROOT.'footer.php';
		}				
	}
}
if(isset($_GET['section'])) {
	//
	// SECTION: RESET PASSWORD / RE-SEND EMAIL
	//
	if($_GET['section'] == "reset") {
		$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE id=\''.$spoon_id.'\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
		$client_data = $db->fetch_assoc($result);
		$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Hosting';
		define('PUN_ALLOW_INDEX', 1);
		require PUN_ROOT.'header.php';
		generate_profile_menu('hosting');
?>
	<div class="blockform">
		<h2><span>Reset</span></h2>
		<div class="box">
			<form id="confirm_activate" method="post" action="hosting.php?action=reset&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">
			<div><input type="hidden" name="form_sent" value="1" /></div>
			<div class="inform">
				<fieldset>
					<legend><?=$client_data['domain']?></legend>
					<div class="infldset">
						<p>Your new password will be sent to your current email address. Please make sure this is correct before continuing.</p>
					</div>
				</fieldset>
			</div>
			<p><input type="submit" name="continue" value="Continue" /><a href="javascript:history.go(-1)">Go back</a></p>	
			</form>
		</div>
	</div>
</div>
<?php
	require PUN_ROOT.'footer.php';
	}else{
	
	}
}
$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / Hosting';
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';
generate_profile_menu('hosting');

$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE user_id=\''.$id.'\' AND type = \'0\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
$client_data = $db->fetch_assoc($result);
if(!$hosting) {
?>
	<div class="blockform">
		<h2><span>Free SPOON</span></h2>
		<div class="box">
			<form id="spoonfree" method="post" action="hosting.php?action=activate&id=<?=$id?>">
			<div><input type="hidden" name="form_sent" value="1" /><input type="hidden" name="domain" value="spoon.net.nz" /><input type="hidden" name="plan" value="0" /></div>
			<div class="inform">
				<fieldset>
					<legend>Activate your free SPOON hosting</legend>
					<div class="infldset">
						<label>Your username, password and other important details will be emailed to you once your hosting is activated.</label>
						<label>Please make sure your email address is valid before activating your hosting. </label>
						<label><input type="text" name="subdomain" size="10" maxlength="10" />&nbsp;&nbsp;<select name="extension" disabled><option value="spoon.net.nz" selected>.spoon.net.nz</option></select></label>
						<label><input type="submit" name="activate" value="Activate!" /></label>
					</div>
				</fieldset>
			</div>
			</form> 
		</div>
	</div>
<?php
}else{	
	if($db->num_rows($result)) {
?>
	<div class="blockform">
		<h2><span>Free SPOON</span></h2>
		<div class="box">
			<div class="fakeform">
				<div class="inform">
					<fieldset>
						<legend><?=$client_data['domain']?></legend>
						<div class="infldset">
							<label>- <a href="hosting.php?section=upgrade&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Upgrade account</a> (W.I.P)</label>
							<label>- <a href="hosting.php?section=reset&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Reset password</a></label>
						</div>
					</fieldset>
<?php
		if ($pun_user['g_id'] < PUN_MOD) {
?>
					<br />
					<fieldset>
						<legend><strong>Admin:</strong></legend>
						<div class="infldset">
							<label>- <a href="hosting.php?action=delete&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Delete account</a></label>
							<label>- <a href="hosting.php?action=suspend&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Suspend / unsuspend account</a></label>
							<label>- <a href="hosting.php?action=promote&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Promote account</a></label>
						</div>
					</fieldset>
<?php
		}
?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE user_id=\''.$id.'\' AND type = \'1\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
	if($db->num_rows($result)) {
?>
	<div class="blockform">
		<h2><span>Paying SPOON (W.I.P)</span></h2>
<?php
		while($client_data = $db->fetch_assoc($result)) {
?>
		<div class="box">
			<div class="fakeform">
				<div class="inform">
					<fieldset>
						<legend><?=$client_data['domain']?></legend>
						<div class="infldset">
							<label>- <a href="hosting.php?section=upgrade&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Upgrade account</a></label>
							<label>- <a href="hosting.php?section=reset&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Reset password</a></label>
						</div>
					</fieldset>
<?php
			if ($pun_user['g_id'] < PUN_MOD) {
?>
					<br />
					<fieldset>
						<legend><strong>Admin:</strong></legend>
						<div class="infldset">
							<label>- <a href="hosting.php?action=delete&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Delete account</a></label>
							<label>- <a href="hosting.php?action=suspend&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Suspend / unsuspend account</a></label>
							<label>- <a href="hosting.php?action=promote&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Promote account</a></label>
						</div>
					</fieldset>
<?php
			}
?>

				</div>
			</div>
		</div>
	</div>
	<div class="blockform">
<?php
		}
?>
		<!-- WASTED DIV FROM SPOON PAID LOOP -->						
	</div>
<?php
	}
// DWHDOWDWH*W(DHWDIUWHDIUWDHWIUDWWHUDHWIHIWUDHIDIUWHDWHWD
	$result = $db->query('SELECT * FROM '.$db->prefix.'clients WHERE user_id=\''.$id.'\' AND type = \'2\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
	if($db->num_rows($result)) {
?>
	<div class="blockform">
		<h2><span>Suspended SPOON</span></h2>
<?php
		while($client_data = $db->fetch_assoc($result)) {
?>
		<div class="box">
			<div class="fakeform">
				<div class="inform">
					<fieldset>
						<legend><?=$client_data['domain']?></legend>
						<div class="infldset">
							<label>- <a href="hosting.php?section=upgrade&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Upgrade account</a></label>
							<label>- <a href="hosting.php?section=reset&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Reset password</a></label>
						</div>
					</fieldset>
<?php
			if ($pun_user['g_id'] < PUN_MOD) {
?>
					<br />
					<fieldset>
						<legend><strong>Admin:</strong></legend>
						<div class="infldset">
							<label>- <a href="hosting.php?action=delete&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Delete account</a></label>
							<label>- <a href="hosting.php?action=suspend&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Suspend / unsuspend account</a></label>
							<label>- <a href="hosting.php?action=promote&id=<?=$id?>&spoon_id=<?=$client_data['id']?>">Promote account</a></label>
						</div>
					</fieldset>
<?php
			}
?>

				</div>
			</div> 
		</div>
	</div>
	<div class="blockform">
<?php
		}
?>
		<!-- WASTED DIV FROM SPOON PAID LOOP -->						
	</div>
</div>
<?php
	}
// WDNWIDUNWUD(W* W*(DW*(D(W*DH(*WDH(*WHDWHD*(W(HDWHD
}
require PUN_ROOT.'footer.php';
?>