<?
// DIRECT ADMIN STUFF
$dahost	 	= '210.54.62.122';
$daadmin 	= 'spoon';
$dapass 	= 'qapmoc__';
$daip 		= '210.54.62.122'; // assign ip for users
require 'da_api.php';
$da=new DirectAdmin($dahost, $daadmin, $dapass);

class DirectAdmin
{
    var $s;
    function DirectAdmin($host,$auser,$apass)
    {
        $this->s = new HTTPSocket;
        $this->s->connect($host,2222);
        $this->s->set_login($auser,$apass);
        return $this->check_auth($auser,$apass);
    }
    function check_auth($user,$pass)
    {
        $this->s->query('/CMD_API_VERIFY_PASSWORD',
            array(
                'user' => $user,
                'pass' => $pass,
            ));
        $ret=$this->s->fetch_parsed_body();
        if(! isset($ret['error']))
            return 0;
        else
            return $ret['details'];
    }
    function add_user($name,$email,$passwd,$domain,$package,$ip)
    {
        $this->s->query('/CMD_API_ACCOUNT_USER', array(
                'action' => 'create',
                'username' => $name,
                'email' => $email,
                'passwd' => $passwd,
                'passwd2' => $passwd,
                'domain' => $domain,
                'package' => $package,
                'ip' => $ip,
                'notify' => 'no'
            ));
        $ret=$this->s->fetch_parsed_body();
        if(!isset($ret['error']))
            return 0;
        else
            return $ret['error'].' '.$ret['details'];
    }
    function get_user_info($name)
    {
        $this->s->query('/CMD_API_SHOW_USER_CONFIG',
            array(
                'user' => $name,
            ));
        $ret=$this->s->fetch_parsed_body();
        if(!isset($ret['error']))
            return $ret;
        else
            return false;
    }
    function is_suspended_user($name)
    {
        $info=$this->get_user_info($name);
        return ($info['suspended']=='no')?0:1;
    }
    function is_active_user($name)
    {
        $info=$this->get_user_info($name);
        return ($info['suspended']=='no')?1:0;
    }

    function suspend_user($name)
    {
        $this->s->query('/CMD_SELECT_USERS',
            array(
                'location' => 'CMD_SELECT_USERS',
                'suspend' => 'Suspend/Unsuspend',
                'select0' => $name
            ));
        return $this->s->fetch_body();
    }

    function activate_user($name)
    {
        if($this->is_active_user($name)) return 0;
        $this->s->query('/CMD_SELECT_USERS',
            array(
                'location' => 'CMD_SELECT_USERS',
                'suspend' => 'Suspend/Unsuspend',
                'select0' => $name
            ));
        return $this->s->fetch_body();
    }
    function set_package_user($name,$package)
    {

        $this->s->query('/CMD_API_MODIFY_USER',
            array(
                'action' => 'package',
                'user' => $name,
                'package' => $package
            ));

        $ret=$this->s->fetch_parsed_body();


        if(!$ret['error'])
            return 0;
        else
            return $ret['error'].' '.$ret['details'];

    }
    function get_users()
    {

        $this->s->query('/CMD_API_SHOW_USERS');
        $ret=$this->s->fetch_parsed_body();
        return $ret['list'];

    }
    function get_packages()
    {

        $this->s->query('/CMD_API_PACKAGES_USER');
        $r=$this->s->fetch_parsed_body();
        return $r['list'];

    }
    function delete_user($name)
    {
        $this->s->set_method('get');
        $this->s->query('/CMD_SELECT_USERS',
            array(
                'location' => 'CMD_SELECT_USERS',
                'confirmed' => 'Confirm',
                'delete' => 'yes',
                'select0' => $name
            ));
        return $this->s->fetch_body();
    }
    function change_password($name, $newpass)
    {
        $this->s->set_method('post');
        $this->s->query('/CMD_USER_PASSWD',
            array(
                'location' => 'CMD_USER_PASSWD',
				'username' => $name,
                'passwd' => $newpass,
                'passwd2' => $newpass,
                'submit' => 'Submit'
            ));
        return $this->s->fetch_body();
    }
	function create_subdomain($subdomain, $domain) {
        $this->s->set_method('post');
        $this->s->query('/CMD_SUBDOMAIN',
            array(
                'location' => 'CMD_SUBDOMAIN',
				'action' => "create",
                'domain' => $domain,
                'subdomain' => $subdomain,
                'submit' => 'Create'
            ));
        return $this->s->fetch_body();	
	}
	function delete_subdomain($subdomain, $domain) {
        $this->s->set_method('post');
        $this->s->query('/CMD_SUBDOMAIN',
            array(
                'location' => 'CMD_SUBDOMAIN',
				'action' => "delete",
				'contents' => "yes",
                'domain' => $domain,
                'select0' => $subdomain,
                'submit' => 'Delete Selected'
            ));
        return $this->s->fetch_body();	
	}
	function create_ftp($username, $password, $domain) {
        $this->s->set_method('post');
        $this->s->query('/CMD_FTP',
            array(
                'location' => 'CMD_FTP',
				'action' => "create",
                'domain' => $domain,
                'user' => $username,
				'passwd' => $password,
				'passwd2' => $password,
				'type' => "custom",
				'custom_val' => "/home/spoon/domains/".$domain."/public_html/".$username,
                'submit' => 'Delete Selected'
            ));
        return $this->s->fetch_body();	
	}
}
?>
