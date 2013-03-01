<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v000
|     Date: 2012. 09. 15.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

class foo_mysqli extends mysqli {
    public function __construct($host, $user, $pass, $db) {
        parent::__construct($host, $user, $pass, $db);

        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
    }
}

class database {
var $dbconnect = NULL;
var $sqlCharSet = NULL;

var $lostQuery = NULL;
var $connectCount = 0;

var $host = "";
var $username = "";
var $password = "";
var $database = "";

public function connect( $host = SQLHOST, $username = SQLUSER , $password = SQLPASS , $database = SQLBASE ) {
	$this->host = $host;
	$this->username = $username;
	$this->password = $password;
	$this->database = $database;
}

public function start() {
	$this->dbconnect = new foo_mysqli( $this->host, $this->username, $this->password , $this->database );

	if( !$this->dbconnect ) die (SQL_CONNECT_ERROR);

	if ( defined('SQLCHARSET') ) {
	
		$this->dbconnect->set_charset( SQLCHARSET );
		
	}
	
	$this->sqlCharSet = $this->dbconnect->character_set_name();
}

private function close() {

	$this->dbconnect->close();
	
}

function connectTest() {
	$this->connect();
	$this->close();
}

public function doQuery($sqlQuery) {
	$this->lostQuery = $sqlQuery;
	$this->connectCount++;
	$result = $this->dbconnect->query( $sqlQuery );
	if ($result) {
		return $result;
	}
}

public function getResultArray($sqlResult) {
	$result2 = Array();
	$this->lostQuery = $sqlResult;
	$this->connectCount++;
	$result = $this->dbconnect->query($sqlResult);
	if ($result) {
		while ( $result2[] = $result->fetch_assoc() );
		
		foreach ( $result2 as $k => $v ) {
			if ( empty($result2[$k])) {unset($result2[$k]);}
		}
		
		return $result2;
	}
}

public function getRow($sqlResult) {
	$result2 = Array();
	$this->lostQuery = $sqlResult;
	$this->connectCount++;
	$result = $this->dbconnect->query($sqlResult);
	if ($result) {
		while ( $result2[] = $result->fetch_assoc() );
		
		foreach ( $result2 as $k => $v ) {
			$result2 = $v;
			break;
		}
		
		return $result2;
	}
}

public function getResult($sqlResult) {
	$result2 = Array();
	$this->lostQuery = $sqlResult;
	$this->connectCount++;
	$result = $this->dbconnect->query($sqlResult);
	if ($result) {
		$result2 = $result->fetch_assoc();
		
		$result3 = ( !empty($result2) ) ? current($result2) : "";
		
		return $result3;
	}
}

public function getNumberRows($sqlResult) {
	$this->lostQuery = $sqlResult;
	$this->connectCount++;
	$result = $this->dbconnect->query($sqlResult);
	$result2 = $result->num_rows();
	return $result2;
}

public function getSelect( $type = 'array', $select = "*", $from, $whereAnd = "" ) {
	$sqlPref = SQLPREF;	
	$RET = NULL;
	
	if ( is_array($from) ) {
		$from2 = "";
		foreach ($from as $k => $v) {
			if ( !empty($from2) ) { $from2 .= ", "; }
			$from2 .= "`".$sqlPref.$v."` `".$k."`";
		}
	} else {
		$from2 = $sqlPref.$from;
	}
	
	if ( mb_strtolower($type, 'UTF-8') == 'array' ) {
		$RET = $this->getResultArray(" SELECT ".$select." FROM ".$from2." ".$whereAnd." ;");
	} elseif ( mb_strtolower($type, 'UTF-8') == 'row' ) {
		$RET = $this->getRow(" SELECT ".$select." FROM ".$from2." ".$whereAnd." ;");
	} elseif ( mb_strtolower($type, 'UTF-8') == 'result' ) {
		$RET = $this->getResult(" SELECT ".$select." FROM ".$from2." ".$whereAnd." ;");
	}
	
	return $RET;
}

public function insertTo( $where, $what ) {
	$sqlPref = SQLPREF;
	
	if ( empty($where) OR empty($what) OR !is_array($what) ) {
		return 0;
	}
	
	$data = "";
	$dataHead = Array();
	$dataBody = Array();
	$c = 0;
	foreach ( $what as $key => $val ) {
		$dataHead[] = $key;
		if ( !is_array($val) ) {
			$val[0] = $val;
		}
		$dataBody[] = $val;
	}
	
	$dataTail = "";
	foreach ( $dataBody as $value ) {
		$dataTail .= ( !empty($dataTail) ) ? ", " : "";
		$dataTail .= "(";
		$dataTail .= "'" . implode("', '", $value) . "'";
		$dataTail .= ")";
	}
	
	$data .= "(`" . implode("`, `",$dataHead) . "`) VALUES " . $dataTail;
	
	$from2 = $sqlPref.$where;
	
	$RET = $this->doQuery(" INSERT INTO `" . $from2 . "` " . $data . "  ;");
	
	return $RET;
}

}

?>