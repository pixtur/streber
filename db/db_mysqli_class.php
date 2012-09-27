<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}


/**
*
* eTalkers CMS 2006 code for streber project
* GNU General Public License (GPL)
*
* by Lolo Irie
*
*/

define('DEBUG_SQL_DISPLAY', 0);

interface sql_interface{
    // Define SQL values (server, user, pwd, database...)
    function __construct($tmpserver='', $tmpuser='', $tmppwd='', $tmpdb='');
    // Set error msg
    # function error($msg=false);
    // Connection Database
    function connect();
    // Select Database
    function selectdb();
    // Execute query
    function execute($tmp_query);
    // Fetch Array
    function fetchArray($type = "MYSQLI_ASSOC");
    // Fetch row
    function fetchRow();
    // Secure variable
    function secure($var);
    // Get last ID
    function lastId();
}

# Class to connect the database
class sql_class implements sql_interface{
    # Attributes to connect DB
    private $server; # string: DB Server
    private $user; # string: DB User
    private $pwd; # string: DB Password
    private $database; # string: DB database
    private $connect=false; # resource: DB connection
    private $result; # resource: result SQL Query
    private $lastId; # integer/string: last Id

    # Attributes to execute queries
    public $error; # string: Error message
    public $errno; # integer: error no

    ## Following attributes probably not used by Streber... ##
    public $tables; # array: Table(s) (for queries)
    public $fields; # array: Field(s) (for queries)
    public $where; # string: Where statement (for queries)
    public $order; # string: Order by (for queries)
    public $asc; # string:  Order direction (for queries)
    public $from; # integer: First result (for queries)
    public $nbr; # integer: Nbr results (for queries)
    public $query; # string: Final query

    /**
    * Constructor: Check database and PHP versions
    */
    function __construct($tmpserver='', $tmpuser='', $tmppwd='', $tmpdb=''){
        $this->lastId = 0;
        $this->error = false;
        $this->errno = false;
        $this->server = $tmpserver;
        $this->user = $tmpuser;
        $this->pwd = $tmppwd;
        $this->database = $tmpdb;
        if(!function_exists('mysqli_connect')){
            if(function_exists('mysqli_connect_error')) {
                $this->error = mysqli_connect_error();
            }
            if(function_exists('mysqli_connect_errno')) {
                $this->errorno = mysqli_connect_errno();
            }
            trigger_error('Function mysqli_connect() does not exists. mysqli extension is not enabled?', E_USER_ERROR);
            return false;
        }
        return true;
    }

    /**
    * accessing connect for MySQLiError output
    */
    public function getConnect() 
    {
        return $this->connect;
    }
    
    
    /**
    * method error: Set error msg
    */
    private function error($msg=false){
        $this->error = $msg;
    }

    /**
    * method connect: Connect DB
    */
    public function connect(){
        if($this->connect = @mysqli_connect(
            $this->server,
            $this->user,
            $this->pwd
            )){
            $this->error('Connection using mysqli_connect SUCCESSFUL');
            return true;
        }
        $this->error('Connection using mysqli_connect FAILED');
        return false;
    }

    public function selectdb(){
        if(@mysqli_select_db($this->connect, $this->database)){
            $this->error('Database '.$this->database.' exists');
            return true;
        }
        $this->error('Database '.$this->database.' does NOT exist');
        return false;
    }


    /**
    * method execute: execute query
    */
    public function execute($tmp_query){

        if($this->result = @mysqli_query($this->connect, $tmp_query)){
            $this->error('Query successful: '.$tmp_query);
            if(DEBUG_SQL_DISPLAY == 1){echo $tmp_query.'<br /><br />';}
            return true;
        }
        $this->error('Query error: '.$tmp_query);
        return false;
    }

    /**
    * method fetchArray: fetch array
    */
    public function fetchArray($type = "MYSQLI_ASSOC"){

        if(isset($this->result)){
            $tmp = @mysqli_fetch_array($this->result, constant($type));
        }else{
            return false;
        }
        if(DEBUG_SQL_DISPLAY == 1){echo '<pre>'.print_r($tmp, 1).'</pre><br /><hr />';}
        return $tmp;
    }

    /**
    * method fetchRow: fetch array
    */
    public function fetchRow(){

        if(isset($this->result)){
            $tmp = @mysqli_fetch_array($this->result);
        }else{
            return false;
        }
        if(DEBUG_SQL_DISPLAY == 1){echo '<pre>'.print_r($tmp, 1).'</pre><br /><hr />';}
        return $tmp;
    }


    /**
    * method secure: secure variable
    */
    public function secure($var){
        return mysqli_real_escape_string($this->connect, $var);
    }

    /**
    * method lastId: get last ID
    */
    function lastId(){
        $this->lastId = mysqli_insert_id($this->connect);

        if(DEBUG_SQL_DISPLAY == 1){echo 'LAST ID: '.$this->lastId.'<br />';}
        return $this->lastId;
    }
}

# Function to secure values if $sql_obj not available
if(!function_exists('mysql_real_escape_string')){
    function mysql_real_escape_string($var){
        if(get_magic_quotes_gpc()){
            return $var;
        }else{
            return addslashes($var);
        }
    }
}
?>
