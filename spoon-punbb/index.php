<?php
define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
require PUN_ROOT.'include/parser.php';

// Load the index.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/index.php';

$page_title = pun_htmlspecialchars($pun_config['o_board_title']);
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';
generate_forum_menu('index');
$result = $db->query('SELECT id, subject, sticky FROM '.$db->prefix.'topics WHERE forum_id = \'5\' ORDER BY sticky DESC, posted DESC LIMIT 0,4');
while ($news = $db->fetch_assoc($result)) {
	$result2 = $db->query('SELECT posted, poster, message, hide_smilies FROM '.$db->prefix.'posts WHERE topic_id='.$news['id'].' ORDER BY posted ASC LIMIT 1') or error('Unable to fetch topic list', __FILE__, __LINE__, $db->error());
	$post = $db->fetch_assoc($result2);
	$message = parse_message($post['message'], $post['hide_smilies']);
	$result3 = $db->query('SELECT * FROM '.$db->prefix.'posts WHERE topic_id='.$news['id'].'') or error('Unable to fetch topic list', __FILE__, __LINE__, $db->error());
	$comments = $db->num_rows($result3)-1;
	$posted = format_time($post['posted'], true)

?>
	<div class="blockpost">
		<h2><?=$news['subject']?></h2>
		<div class="box">
			<div class="inbox">
				<div class="postright">
					<div class="postmsg">
						<?=$message?>	
					</div>
				</div>
<? if (!$news['sticky']) { ?>
				<div class="postedby">
						<div class="posted"><?=$posted?></div>
						<div class="comments"><a href="viewtopic.php?id=<?=$news['id']?>">Comments (<?=$comments?>)</a></div>
				</div>
<? } ?>
			</div>
		</div>
	</div>
<?php
	if($news['sticky']) {
		echo "\t<br />";
		echo "\t<div class=\"block\">";
		echo "\t\t<h2><span>SPOON News</span></h2>";
	}
}
echo "</div>";
require PUN_ROOT.'footer.php';
?>