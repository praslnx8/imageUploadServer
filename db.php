<?php
/**
 * Created by PhpStorm.
 * User: prasi
 * Date: 3/2/16
 * Time: 8:54 PM
 */

class DBManager
{
    static $debug = false;
    static $local_debug = true;

    static $mysql_dhost = "localhost";
    static $mysql_ddatabase = "uploads";
    static $mysql_duser = "root";
    static $mysql_dpassword = "prasi123";

    static $mysql_uhost = "mysql8.000webhost.com";
    static $mysql_udatabase = "a2706933_locad";
    static $mysql_uuser = "a2706933_locad";
    static $mysql_upassword = "prasi123";

    static $mysql_user_table = "USERS";
    static $mysql_offer_table = "OFFERS";
    static $mysql_friends_table = "FRIEND_LIST";
    static $mysql_gcm_table = "GCM";
    static $mysql_location_table = "LOCATION";
    static $mysql_status_table = "STATUS";
    static $mysql_inbox_table = "INBOX";
    static $mysql_chat_history_table = "CHAT_HISTORY";

    public static function dosql($sql)
    {
        if(DBManager::$local_debug)
        {
            $conn =  mysqli_connect (DBManager::$mysql_dhost, DBManager::$mysql_duser, DBManager::$mysql_dpassword );
            mysqli_select_db($conn, DBManager::$mysql_ddatabase);
        }
        else
        {
            $conn =  mysqli_connect (DBManager::$mysql_uhost, DBManager::$mysql_uuser, DBManager::$mysql_upassword );
            mysqli_select_db($conn, DBManager::$mysql_udatabase);
        }

        $result = mysqli_query($conn, $sql);


        if(DBManager::$debug)
        {
            echo "[Sql stmnt is: ".$sql;
        }


        return $result;
    }

}
