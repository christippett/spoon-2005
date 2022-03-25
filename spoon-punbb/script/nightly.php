<?php
if($_SERVER['REMOTE_ADDR'] != "210.54.62.122") {
	exit("must be executed from host machine");
}else{
	// This variable is used throughout this script,
	// so we better make it consistant:
	$now = time();
	// Connect to DB
	require '../include/dblayer/mysql.php';
	require 'da_functions.php';
	$db = new DBLayer("localhost", "spoon_punbb", "pass0010", "spoon_punbb", "", 0);
	//
	// LOG FUNCTIONS
	// =============
	// Because logs are fun D;
	function logme($desc) {
		$logtime = time();
		$logtime = date("[d/m/y (H:i)]",$logtime);
		$desc = "\n".$logtime." ".$desc;
		// Write to log
		$fp = fopen("log", "a");
		fwrite($fp, $desc);
		fclose($fp);
		
	}
	// Make new entry in log:
	$now_format = date("F d, Y", $now);
	logme("--- ".$now_format." ---");
	//
	// CREATE DUE INVOICES
	// =======================
	// This section checks whether a new recurring invoice is
	// due to be made. If so, it creates the invoice. <8^D
	$result = $db->query('SELECT recurrings.*, accounts.plan_id, accounts.domain, accounts.fname, accounts.lname, accounts.address1, accounts.address2, accounts.city, accounts.country FROM recurrings, accounts WHERE (recurrings.account_id=accounts.id AND accounts.type = \'1\' AND recurrings.active = \'1\')') or logme("WARNING: Could not retrieve account/recurrings details!");
	$temp['issue'] = $now+864000;
	while($recurrings = $db->fetch_assoc($result)) {
		if($temp['issue'] >= $recurrings['next']) {
			// It's time to issue a new invoice!
			logme("(".$recurrings['domain']."): Within 10 days of due date. Creating new invoice...");
			// Prepare the variables for the new invoice
			// 28 days = 2419200
			$new_invoice = array();
			$new_invoice['account_id'] = $recurrings['account_id'];
			$new_invoice['user_id'] = $recurring['user_id'];
			$new_invoice['recurring_id'] = $recurrings['id'];
			$new_invoice['type'] = $recurrings['type'];
			$new_invoice['active'] = 1;
			$new_invoice['status'] = 0; // Due
			$new_invoice['total'] = $recurrings['amount'];
			$new_invoice['issued'] = $now;
			$new_invoice['due'] = $recurrings['next'];
			
			$new_invoice['domain'] = $recurrings['domain'];
			$new_invoice['fname'] = $recurrings['fname'];
			$new_invoice['lname'] = $recurrings['lname'];
			$new_invoice['address1'] = $recurrings['address1'];
			$new_invoice['address2'] = $recurrings['address2'];
			$new_invoice['city'] = $recurrings['city'];
			$new_invoice['country'] = $recurrings['country'];
			// Make invoice
			$db->query('INSERT INTO invoices (account_id, user_id, recurring_id, type, active, status, total, issued, due, domain, fname, lname, address1, address2, city, country) VALUES (\''.$new_invoice['account_id'].'\', \''.$new_invoice['user_id'].'\',\''.$new_invoice['recurring_id'].'\', \''.$new_invoice['type'].'\', \''.$new_invoice['active'].'\', \''.$new_invoice['status'].'\',\''.$new_invoice['total'].'\', \''.$new_invoice['issued'].'\', \''.$new_invoice['due'].'\', \''.$new_invoice['domain'].'\', \''.$new_invoice['fname'].'\', \''.$new_invoice['lname'].'\', \''.$new_invoice['address1'].'\', \''.$new_invoice['address2'].'\', \''.$new_invoice['city'].'\', \''.$new_invoice['country'].'\')') or logme("WARNING (".$recurrings['domain']."): Could not create new invoice!");
			// A reminder email could be inserted here. However, I can't be bothered - i'll leave that as a W.I.P
			
			// Type Index:
			// 1 	= Normal hosting plan.
			// 2	= Domain renewal
			// 3	= Custom
			if($recurrings['type'] == 1) {
				// If type == 1, then we want to update the next
				// recurring invoice with the latest plan prices!
				$result = $db->query('SELECT * FROM plans WHERE id = \''.$recurrings['plan_id'].'\'');
				$plans = $db->fetch_assoc($result);
				$temp['amount'] = $plans['price'];
				$db->query('UPDATE recurrings SET amount=\''.$temp['amount'].'\' WHERE id=\''.$recurrings['id'].'\'') or logme("WARNING (".$recurrings['domain']."): Could not update new plan price for recurring invoice!");
				logme("(".$recurrings['domain']."): Updated recurring invoice with new plan prices");
			}	
			// Update the recurring table for next month's due date
			$temp['next'] = $recurrings['next']+2419200;
			$db->query('UPDATE recurrings SET next=\''.$temp['next'].'\' WHERE id=\''.$recurrings['id'].'\'') or logme("WARNING (".$recurrings['domain']."): Could not update new due date for recurring invoice!");	
		}else{
			logme("(".$recurrings['domain']."): Not due for next invoice. Skipping...");
		}
	}
	//
	// SUSPEND OVERDUE ACCOUNTS
	// ========================
	// A account has 1 week following their due date
	// to make their payment. If they don't, suspend 'em. ='(
	// Call DA's functions:
	//$result = $db->query('SELECT accounts.*, invoices.due FROM accounts, invoices WHERE (accounts.id=invoices.account_id AND invoices.active = \'1\' AND accounts.type = \'1\')') or logme("WARNING (".$recurrings['domain']."): Could not retrieve invoice details!");
	$result = $db->query('SELECT * FROM invoices WHERE active = \'1\'') or logme("WARNING: Could not retrieve invoice details!");
	if ($db->num_rows($result)) {	
		while($invoices = $db->fetch_assoc($result)) {
			// Give accounts a 1-week margin for overdue invoices
			$temp['due'] = $invoices['due']+604800;
			if($now > $temp['due']) {
				// Uh oh, this is an overdue invoice!
				logme("(".$invoices['domain']."): Found overdue invoice. Suspending...");
				$result2 = $db->query('SELECT * FROM accounts WHERE (id = \''.$invoices['account_id'].'\')') or logme("(".$invoices['domain']."): Could not retrieve account details!");
				if($db->num_rows($result2)) {
					$account_data = $db->fetch_assoc($result2);
					$username = $account_data['username'];
					// Is the user already suspended, if so, we don't want to unsuspend
					$status = $da->is_suspended_user($username);
					if($status == 0) {
						// Not current suspended, so let's do it:
						$da->suspend_user($username);
						logme("(".$invoices['domain']."): Suspended user.");
					}else{
						logme("(".$invoices['domain']."): User already suspended. Skipping...");
					}
					// Set account to "suspended":
					$db->query('UPDATE accounts SET type = \'2\' WHERE id = \''.$invoices['account_id'].'\'') or logme("WARNING (".$invoices['domain']."): Unable to update account entry in database.");
					// Set invoices to "Overdue":
					$db->query('UPDATE invoices SET status = \'2\' WHERE id = \''.$invoices['id'].'\'') or logme("WARNING (".$invoices['domain']."): Unable to update invoice entry in database.");
				}
			}else{
				logme("(".$invoices['domain']."): No overdue invoices found. Skipping...");
			}
		}
	}
}
?>