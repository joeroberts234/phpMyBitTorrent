<?php
include("header.php");

# Table Names
$old_tableprefix = "users"; // Old table name
$new_tableprefix = "div_users"; //New Table Name

$query = $db->sql_query("SELECT id, username, email, added, secret, passhash, uploaded, downloaded, gender, status FROM {$old_tableprefix}") or sqlerr(__FILE__,__LINE__);

OpenTable("User Import");
echo "I will try to update user table --> ";
$count=0;
while ($olduser = $db->sql_fetchrow($query))
{
$id = $olduser['id'];
$username = $olduser['username'];
$email = $olduser['email'];
$added = $olduser['added'];
$uploaded = $olduser['uploaded'];
$downloaded = $olduser['downloaded'];
$tempass = RandomAlpha(8)
$act_key = RandomAlpha(32);
$status = ($olduser['status']=="confirmed")? 1 :0;
                                                                        if($force_passkey){
                                                                                        do {
                                                                                                $passkey = ", '".RandomAlpha(32)."'";
                                                                                                //Check whether passkey already exists
                                                                                                $sqll = "SELECT passkey FROM ".$new_tableprefix." WHERE passkey = '".$passkey."';";
                                                                                                $resl = mysql_query($sqll)OR print("error");
                                                                                                $cnt = @mysql_num_rows($sqll);
                                                                                                @mysql_free_result($resl);
                                                                                        } while ($cnt > 0);
                                                                                        $passkeyrow = ', passkey';
                                                                                        }else{
                                                                                        $passkeyrow = NULL;
                                                                                        $passkey = NULL;
                                                                                        }



$sqlnew = "INSERT INTO ".$new_tableprefix." (id,username,clean_username,email,regdate,password,act_key,uploaded,downloaded,active".$passkeyrow.")
VALUES ('$id', '$username', '".strtolower($username)."', '$email', '$added', '$tempass', '$act_key', '$uploaded', '$downloaded', '$status' $passkey)";
$gonew = $db->sql_query($sqlnew);
if(!$gonew)echo "<br>Error:<br>Not able to creat ".$username." Maybe a duplicate Intry<br>";
$count++;
}

echo "Done..<br><br>Total {$count} users has been updaded...<br>Note: All users should recover their password...";
CloseTable();
include("footer.php");
?> 