<?php
class DB{
    static private $db;
        
    static public function SetConn($host, $username, $password, $db){
        if (isset(self::$db)){
            return self::$db;
        } else {
            self::$db = new mysqli($host, $username, $password, $db);
            return self::$db;
        }
    }
    
    static public function CheckInput($value){
        //去除斜杠
        if (get_magic_quotes_gpc()){
            $value = stripslashes($value);
        }
        
        //如果不是数字则加引号
        if (!is_numeric($value)){
            //少改点吧
            $value = self::$db->real_escape_string($value);
//            $value = "'" . self::$db->real_escape_string($value) . "'";
        }
        
        return $value;
    }
}


$conn = DB::SetConn('localhost', 'root', '000000', 'paike');
if ($conn->connect_error) {
    die('数据库链接错误 (' . $conn->connect_errno . ') '
            . $conn->connect_error);
}

//这应该是首选的用于改变字符编码的方法，不建议使用mysqli_query()执行SQL请求的SET NAMES ...（如 SET NAMES utf8）
$conn->set_charset('utf8');

$sql_ini = "SELECT * FROM `ini_year_term` WHERE 1";
$result_ini = $conn->query($sql_ini);
$db_year="";
while($info_ini = $result_ini->fetch_array())
	$db_year = $info_ini['year_term'];//设置年
$default_password = md5('000000');

//服务器时间
$var_serversTime = getdate();
$servers_time = $var_serversTime['mon'] . '@' . $var_serversTime['mday']
?>
