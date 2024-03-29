<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="ROBOTS" content="NOINDEX, FOLLOW"><title>SPOON Hosting / Register</title>

<link rel="stylesheet" type="text/css" href="register_files/Spoon.css">
<script type="text/javascript">
<!--
function process_form(the_form)
{
	var element_names = new Object()
	element_names["req_username"] = "Username"
	element_names["req_password1"] = "Password"
	element_names["req_password2"] = "Confirm password"
	element_names["req_email1"] = "E-mail"
	element_names["req_email2"] = "E-mail 2"

	if (document.all || document.getElementById)
	{
		for (i = 0; i < the_form.length; ++i)
		{
			var elem = the_form.elements[i]
			if (elem.name && elem.name.substring(0, 4) == "req_")
			{
				if (elem.type && (elem.type=="text" || elem.type=="textarea" || elem.type=="password" || elem.type=="file") && elem.value=='')
				{
					alert("\"" + element_names[elem.name] + "\" is a required field in this form.")
					elem.focus()
					return false
				}
			}
		}
	}

	return true
}
// -->
</script></head>


<body onload="document.getElementById('register').req_username.focus()">

<div id="punwrap">
<div id="punregister" class="pun">

<div id="brdheader" class="block">
	<div class="box">
		<div id="headerimg"><img src="register_files/header.gif" alt="SPOON Hosting"></div>
		<div id="brdmenu" class="inbox">
			<ul>
				<li id="navindex"><a href="http://spoon.net.nz/index.php">Index</a></li>
				<li id="navuserlist"><a href="http://spoon.net.nz/userlist.php">User list</a></li>
				<li id="navsearch"><a href="http://spoon.net.nz/search.php">Search</a></li>
				<li id="navregister"><a href="http://spoon.net.nz/register.php">Register</a></li>
				<li id="navlogin"><a href="http://spoon.net.nz/login.php">Login</a></li>
			</ul>
		</div>
		<div id="brdwelcome" class="inbox">
			<p>You are not logged in.</p>
		</div>
	</div>
</div>



<div class="blockform">
	<h2><span>Register</span></h2>
	<div class="box">
		<form id="register" method="post" action="register.php?action=register" onsubmit="this.register.disabled=true;if(process_form(this)){return true;}else{this.register.disabled=false;return false;}">
			<div class="inform">
				<div class="forminfo">
					<h3>Important information</h3>
					<p>Registration
will grant you access to a number of features and capabilities
otherwise unavailable. These functions include the ability to edit and
delete posts, design your own signature that accompanies your posts and
much more. If you have any questions regarding this forum you should
ask an administrator.</p>
					<p>Below is a form you must fill out in
order to register. Once you are registered you should visit your
profile and review the different settings you can change. The fields
below only make up a small part of all the settings you can alter in
your profile.</p>
				</div>
				<fieldset>
					<legend>Please enter a username between 2 and 25 characters long</legend>
					<div class="infldset">
						<input name="form_sent" value="1" type="hidden">
						<label><strong>Username</strong><br><input name="req_username" size="25" maxlength="25" type="text"><br></label>
					</div>
				</fieldset>
			</div>
			<div class="inform">
				<fieldset>
					<legend>Please enter and confirm your chosen password</legend>
					<div class="infldset">
						<label class="conl"><strong>Password</strong><br><input name="req_password1" size="16" maxlength="16" type="password"><br></label>
						<label class="conl"><strong>Confirm password</strong><br><input name="req_password2" size="16" maxlength="16" type="password"><br></label>
						<p class="clearb">Passwords can be between 4 and 16 characters long. Passwords are case sensitive.</p>
					</div>
				</fieldset>
			</div>
			<div class="inform">
				<fieldset>
					<legend>Enter a valid e-mail address</legend>
					<div class="infldset">
					<label><strong>E-mail</strong><br>
						<input name="req_email1" size="50" maxlength="50" type="text"><br></label>
					</div>
				</fieldset>
			</div>
			<div class="inform">
				<fieldset>
					<legend>Set your localisation options</legend>
					<div class="infldset">
						<label>Timezone: For the forum to display times correctly you must select your local timezone.						<br><select id="time_zone" name="timezone"><option value="-12">-12</option><option value="-11">-11</option><option value="-10">-10</option><option value="-9.5">-9.5</option><option value="-9">-09</option><option value="-8.5">-8.5</option><option value="-8">-08 PST</option><option value="-7">-07 MST</option><option value="-6">-06 CST</option><option value="-5">-05 EST</option><option value="-4">-04 AST</option><option value="-3.5">-3.5</option><option value="-3">-03 ADT</option><option value="-2">-02</option><option value="-1">-01</option><option value="0" selected="selected">00 GMT</option><option value="1">+01 CET</option><option value="2">+02</option><option value="3">+03</option><option value="3.5">+03.5</option><option value="4">+04</option><option value="4.5">+04.5</option><option value="5">+05</option><option value="5.5">+05.5</option><option value="6">+06</option><option value="6.5">+06.5</option><option value="7">+07</option><option value="8">+08</option><option value="9">+09</option><option value="9.5">+09.5</option><option value="10">+10</option><option value="10.5">+10.5</option><option value="11">+11</option><option value="11.5">+11.5</option><option value="12">+12</option><option value="13">+13</option><option value="14">+14</option></select>
						<br></label>
					</div>
				</fieldset>
			</div>
			<div class="inform">
				<fieldset>
					<legend>Set your privacy options</legend>
					<div class="infldset">
						<p>Select
whether you want your e-mail address to be viewable to other users or
not and if you want other users to be able to send you e-mail via the
forum (form e-mail) or not.</p>
						<div class="rbox">
							<label><input name="email_setting" value="0" type="radio">Display your e-mail address.<br></label>
							<label><input name="email_setting" value="1" checked="checked" type="radio">Hide your e-mail address but allow form e-mail.<br></label>
							<label><input name="email_setting" value="2" type="radio">Hide your e-mail address and disallow form e-mail.<br></label>
						</div>
						<p>This
option sets whether the forum should "remember" you between visits. If
enabled, you will not have to login every time you visit the forum. You
will be logged in automatically. Recommended.</p>
						<div class="rbox">
							<label><input name="save_pass" value="1" checked="checked" type="checkbox">Save username and password between visits.<br></label>
						</div>
					</div>
				</fieldset>
			</div>
			<p><input name="register" value="Register" type="submit"></p>
		</form>
	</div>
</div>

<div id="brdfooter" class="block">
	<h2><span>Board footer</span></h2>
	<div class="box">
		<div class="inbox">
			<p class="conr">Powered by <a href="http://www.punbb.org/">PunBB</a><br>� Copyright 2002&#8211;2005 Rickard Andersson</p>
			<div class="clearer"></div>
		</div>
	</div>
</div>

</div>
</div>

<div id="plans">
  <img src="register_files/front_plans.gif" alt="Plans" height="43" width="89"><br>
  <div id="plan1">
	  <span class="plans">500 MB disk space</span><br>
	  <span class="plans">2.5 GB bandwidth</span><br>
	  <div class="price"><a href="http://spoon.net.nz/plans.php"><img src="register_files/plan_1.gif" alt="Plan 01"></a></div>
  </div>
  <div id="plan2">
	  <span class="plans">2 GB disk space</span><br>
	  <span class="plans">10 GB bandwidth</span><br>
	  <div class="price"><a href="http://spoon.net.nz/plans.php"><img src="register_files/plan_2.gif" alt="Plan 02"></a></div>
  </div>
  <div id="plan3">
	  <span class="plans">5 GB disk space</span><br>
	  <span class="plans">25 GB bandwidth</span><br></div>
	  <div class="price"><a href="http://spoon.net.nz/plans.php"><img src="register_files/plan_3.gif" alt="Plan 03"></a></div>
  </div>  


</body></html>