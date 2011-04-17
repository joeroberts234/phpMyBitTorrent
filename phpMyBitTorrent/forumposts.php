<?php
 if ($user->user)
 {
require_once "include/functions_phpBB3.php";
 if (isset($user->id))$pmbtuser=$user;

define("folder", $forumbase);
define("basefile2", "./".$phpbb2_basefile); 
define("basefile", "./".$phpbb2_basefile."?"); 
define("basefile3", $phpbb2_basefile);
    define( 'IN_PHPBB', true );
    $phpbb_root_path = './'.$forumbase.'/'; // change in your own root path.
    $phpEx = substr(strrchr(__FILE__, '.'), 1);
    include($phpbb_root_path . 'common.' . $phpEx);
    include($phpbb_root_path . 'includes/functions_display.' . $phpEx);
    include($phpbb_root_path . 'includes/bbcode.' . $phpEx);
    
    $user->session_begin();
    $auth->acl( $user->data );
    $user->setup();
define('BT_SHARE', true);

    //-- Fetch the data from the specified fora
    $bbcode = new bbcode();
    $news_fora_id = array( 25,22,29,16); // Change in the fora id's you need
    $output = '';
    
    $topic_count = '10'; // Change in the number of topics you want to show.
    $query = "
        SELECT p.topic_id, p.forum_id, p.post_time, p.post_subject, p.post_text, p.bbcode_bitfield, p.bbcode_uid,
            u.user_id, u.user_email, u.username, u.user_posts, u.user_rank, u.user_colour, u.user_allow_viewonline, u.user_allow_viewemail,
            t.topic_title,
                (
                    SELECT COUNT( post_id )
                    FROM " . POSTS_TABLE . "
                        WHERE topic_id = p.topic_id
                ) AS aantal_posts
        FROM " . POSTS_TABLE . " AS p, " . USERS_TABLE . " AS u, " . TOPICS_TABLE . " AS t
            WHERE  u.user_id = p.poster_id
                AND t.topic_id = p.topic_id
        GROUP BY topic_id
        ORDER BY t.topic_last_post_time DESC
        LIMIT 0, {$topic_count} 
    ";

    //die('<pre>' . $query );
    $result = $db->sql_query( $query )or btsqlerror($query);
		$output .= "<table class=\"torrenttable\" border=\"0\" cellpadding=\"3\" width=\"100%\">";
		$output .="<thead>\n<tr><th><p>Topics</p></th>";
		$output .="<th><p>Replies</p></th>";
		$output .="<th><p>Views</p></th>";

        $output .= "</tr></thead>\n";

    while( $row = $db->sql_fetchrow($result) )
    {
	$sql_view ="SELECT * FROM " . TOPICS_TABLE . " WHERE topic_id = ". $row['topic_id'] . "";
$res_views = $db->sql_query($sql_view);
$row_views = $db->sql_fetchrow($res_views);
        // Parse the message and subject
        $message = censor_text($row['post_text']);

        // Second parse bbcode here
        if ($row['bbcode_bitfield'])
        {
            $bbcode->bbcode_second_pass($message, $row['bbcode_uid'], $row['bbcode_bitfield']);
        }

        //$message = bbcode($message);
        $message = smiley_text($message);
        
        // Send data to output var
        $output .= "<tbody>\n";
        $output .="<td class=\"torrenttable\">";
        $output .= "<a href=\"phpBB.php?page=viewtopic&amp;f={$row['forum_id']}&amp;t={$row['topic_id']}\" title=\""  . censor_text($row['post_subject']) . "\">".censor_text($row['post_subject'])."</a>      <br>By <a href=\"phpBB.php?page=memberlist&mode=viewprofile&u=" . $row['user_id'] . "\"  style='color:#9E8DA7'>" . $row['username'] ."</a> on \n";
        $output .= $user->format_date($row['post_time'])."\n" ;
        $output .= "</td>\n" ;
        $output .="<td>";
        $output .= $row['aantal_posts']-1 ."\n";
        $output .="</td>";
        $output .="<td>";
        $output .= $row_views['topic_views']."\n";
        $output .="</td>";
		$output .="</tbody>\n";
    }
		$output .="</table>\n";

    // print the output
OpenTable('Recent Forum Posts');
    print( $output);
CloseTable();	
 if (isset($pmbtuser))$user=$pmbtuser;
}
?>