<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v029
 * @date 28/10/19
 */
if ( !defined('H-KEI') ) { exit; }

// TODO: cache algoritmust megírni!

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
    private $dbconnect = NULL;
    private $sqlCharSet = NULL;

    private $lastQuery = NULL;
    private $lastQueryId = NULL;
    private $connectCount = 0;

    private $host = "";
    private $username = "";
    private $password = "";
    private $database = "";
    private $sqlprefix = "";

    private $_dbdata = Array();
    private $_dbdata_orAndNextEmpty = FALSE;
    private $_dbdata_level = 0;
    
    public function lq() { return $this->lastQuery; }
    public function lastQuery() { return $this->lastQuery; }
    public function lqid() { return $this->lastQueryId; }
    public function lastQueryId() { return $this->lastQueryId; }
    public function cc() { return $this->connectCount; }
    public function connectCount() { return $this->connectCount; }
    
    public function connect( $host = NULL, $username = NULL, $password = NULL, $database = NULL, $sqlprefix = NULL ) {
        $this->host = ( $host === NULL ) ? CB_SQLHOST : $host;
        $this->username = ( $username === NULL ) ? CB_SQLUSER : $username;
        $this->password = ( $password === NULL ) ? CB_SQLPASS : $password;
        $this->database = ( $database === NULL ) ? CB_SQLBASE : $database;
        $this->sqlprefix = ( $sqlprefix === NULL ) ? CB_SQLPREF : $sqlprefix;
    }

    public function start($sqlcharset = CB_SQLCHARSET) {
        $this->dbconnect = new foo_mysqli( $this->host, $this->username, $this->password , $this->database );

        if( !$this->dbconnect ) die (SQL_CONNECT_ERROR);

        if ( $sqlcharset !== NULL ) { $this->dbconnect->set_charset( $sqlcharset ); }

        $this->sqlCharSet = $this->dbconnect->character_set_name();
    }

    private function close() {
        $this->dbconnect->close();
    }

    function connectTest() {
        $this->connect();
        $this->close();
    }

    /** 
     * Database MySQL query
     * @param mysql_code $sqlQuery
     * @return boolean ( 0 - false, 1 - success )
     */
    public function doQuery($sqlQuery) {
        $sqlQuery = str_replace( "#__", $this->sqlprefix, $sqlQuery );

        $this->lastQuery = $sqlQuery;
        $this->connectCount++;
        $result = $this->dbconnect->query( $sqlQuery );
        
        $this->lastQueryId = $this->dbconnect->insert_id;
        return $result;
    }

    private function getResultArray($sqlResult) {
        $sqlResult = str_replace( "#__", $this->sqlprefix, $sqlResult );

        $result2 = Array();
        $this->lastQuery = $sqlResult;
        $this->connectCount++;
        $result = $this->dbconnect->query($sqlResult);
        if ($result) {
            while ( $result2[] = $result->fetch_assoc() );

            foreach ( $result2 as $k => $v ) {
                if ( empty($result2[$k])) {unset($result2[$k]);}
            }

            $result->free();
            return $result2;
        }
    }

    private function getRow($sqlResult) {
        $sqlResult = str_replace( "#__", $this->sqlprefix, $sqlResult );

        $result2 = Array();
        $this->lastQuery = $sqlResult;
        $this->connectCount++;
        $result = $this->dbconnect->query($sqlResult);
        if ($result) {
            while ( $result2[] = $result->fetch_assoc() );

            foreach ( $result2 as $k => $v ) {
                $result3 = $v;
                break;
            }

            $result->free();
            return $result3;
        }
    }

    private function getResult($sqlResult) {
        $sqlResult = str_replace( "#__", $this->sqlprefix, $sqlResult );

        $result2 = Array();
        $this->lastQuery = $sqlResult;
        $this->connectCount++;
        $result = $this->dbconnect->query($sqlResult);
        if ($result) {
            $result2 = $result->fetch_assoc();

            $result3 = ( !empty($result2) ) ? current($result2) : "";

            $result->free();
            return $result3;
        }
    }

    private function getNumberRows($sqlResult) {
        $sqlResult = str_replace( "#__", $this->sqlprefix, $sqlResult );

        $this->lastQuery = $sqlResult;
        $this->connectCount++;
        $result = $this->dbconnect->query($sqlResult);
        if ($result) {
            $result2 = $result->num_rows;

            $result->free();
            return $result2;
        }
    }

    private function getInteger($sqlResult) {
        $sqlResult = str_replace( "#__", $this->sqlprefix, $sqlResult );

        $result2 = Array();
        $this->lastQuery = $sqlResult;
        $this->connectCount++;
        $result = $this->dbconnect->query($sqlResult);
        if ($result) {
            $result2 = $result->fetch_assoc();

            $result3 = ( !empty($result2) ) ? (int) current($result2) : "";

            $result->free();
            return $result3;
        }
    }
    
    private function getFloat($sqlResult) {
        $sqlResult = str_replace( "#__", $this->sqlprefix, $sqlResult );

        $result2 = Array();
        $this->lastQuery = $sqlResult;
        $this->connectCount++;
        $result = $this->dbconnect->query($sqlResult);
        if ($result) {
            $result2 = $result->fetch_assoc();

            $result3 = ( !empty($result2) ) ? (float) current($result2) : "";

            $result->free();
            return $result3;
        }
    }
    
    /** 
     * Cache-elhető keresés adatbázisban..
     * @param string $type keresés típusa ( "array" - tömb, "row" - sor, "result" - eredmény )
     * @param mysql_code $select mit keres, milyen értéket kér vissza ( mysql forma )
     * @param string_or_array $from hol keressen ( táblázat vagy tömb )
     * @param mysql_code $whereAnd keresési feltételek
     * 
     * @return Array találat;
    */
    public function getSelect( $type = 'array', $select = "*", $from, $whereAnd = "" ) {
        $sqlPref = $this->sqlprefix;	

        if ( is_array($from) ) {
            $from2 = "";
            foreach ($from as $k => $v) {
                if ( !empty($from2) ) { $from2 .= ", "; }
                $from2 .= "`".$sqlPref.$v."` `".$k."`";
            }
        } else {
            $from2 = "`".$sqlPref.$from."`";
        }

        $t = mb_strtolower($type, 'UTF-8');
        switch ($t) {
            case 'array':
                $RET = $this->getResultArray(" SELECT ".$select." FROM ".$from2." ".$whereAnd." ;");
                break;
            case 'row':
                $RET = $this->getRow(" SELECT ".$select." FROM ".$from2." ".$whereAnd." ;");
                break;
            case 'result':
                $RET = $this->getResult(" SELECT ".$select." FROM ".$from2." ".$whereAnd." ;");
                break;
            default:
                $RET = NULL;
        }

        return $RET;
    }

    // FIXME: multilevel nem lézetik, megírni!
    /** 
     * Egy új sor beszúrása adatbázisba..
     * @param string $dbName tábla neve ahova az adatot be kell szúrni
     * @param array $dataArray Tömb amit be kell szúrni ( kulcs - oszlop név, érték - érték )
     * @param boolean $multilevel többszintű array tömb ( FALSE - nem, TRUE - igen )..<br>( WARNING: No debuging! )
     * @return boolean
     */
    public function insertTo( $dbName, $dataArray, $multilevel = FALSE ) {
        if ( $multilevel === TRUE ) { foreach($dataArray as $d) { $this->insertTo($dbName,$d,FALSE); } return TRUE; }
        $dbName = str_replace( "#__", $this->sqlprefix, $dbName );

        if ( empty($dbName) OR empty($dataArray) OR !is_array($dataArray) ) {
            return FALSE;
        }

        $data = "";
        $dataHead = Array();
        $dataBody = Array();
        $c = 0;
        foreach ( $dataArray as $key => $val ) {
            $dataHead[] = $key;
            $dataBody[] = $this->dbconnect->real_escape_string($val);
        }

        $dataTail = "";

        $dataTail .= "(";
            $dataTail .= "'" . implode("', '", $dataBody) . "'";
        $dataTail .= ")";

        $data .= "(`" . implode("`, `",$dataHead) . "`) VALUES " . $dataTail;

        $sql = " INSERT INTO `" . $dbName . "` " . $data . "  ;";

        return $this->doQuery($sql);
    }

    /** 
     * Egy sor frissítése adatbázisban új adatkokkal, kizárólag sor ID alapján! ..
     * @param string $dbName tábla neve ahol a sor módosul
     * @param string $idName a frissítendő sor id neve ( ami alapján azonosít, az értéket a $dataArray tömbbel kell átadni )
     * @param array $dataArray Tömb ami a módosítandó adatokat tartalmazza ( kulcs - oszlop név, érték - érték )
     * @return boolean módosítás sikeressége esetén TRUE egyébként FALSE
     */
    public function updateTo( $dbName, $id, $dataArray ) {
        $dbName = str_replace( "#__", $this->sqlprefix, $dbName );
 
        if ( empty($dbName) OR empty($id) OR empty($dataArray) OR !is_array($dataArray) ) {
            return FALSE;
        }

        $idArray = [];
        if ( !is_array($id) ) { $idArray[] = $id; } else { $idArray = $id; }
        
        $dataSet = "";
        $dataWhere = "";
        
        foreach ( $idArray as $idName ) {
            if ( !isset($dataArray[$idName]) ) { return FALSE; }
            
            $idValue = $dataArray[$idName];
            unset($dataArray[$idName]);
            
            if ( !empty($dataWhere) ) { $dataWhere .= " AND "; }
            $dataWhere .= "`" . $idName . "` = '" . $this->dbconnect->real_escape_string($idValue) . "'";
        }

        foreach ( $dataArray as $key => $val ) {
            if ( !empty($dataSet) ) { $dataSet .= ", "; }
            $dataSet .= "`" . $key . "` = '" . $this->dbconnect->real_escape_string($val) . "'";
        }
        
        $sql = " UPDATE `" . $dbName . "` SET " . $dataSet . " WHERE " . $dataWhere . "  ;";
        unset($dataSet);
        unset($dataWhere);

        return $this->doQuery($sql);
    }
    
    /** 
     * Egy új sor beszúrása adatbázisba, vagy frissítése ha létezik..
     * @param string $dbName tábla neve ahova az adatot be kell szúrni
     * @param array $dataArray Tömb amit be kell szúrni ( kulcs - oszlop név, érték - érték )
     * @return boolean
     */
    public function insertOrUpdate( $dbName, $dataArray ) {
        $dbName = str_replace( "#__", $this->sqlprefix, $dbName );

        if ( empty($dbName) OR empty($dataArray) OR !is_array($dataArray) ) {
            return FALSE;
        }

        $data = "";
        $dataHead = Array();
        $dataBody = Array();
        $c = 0;
        foreach ( $dataArray as $key => $val ) {
            $dataHead[] = $key;
            if ( is_array($val) ) { cbda('ERROR: The value is array, only string allowed. '.$key,0,1);cbda($val,0,1); }
            $dataBody[] = $this->dbconnect->real_escape_string($val);
        }

        $dataTail = "";

        $dataTail .= "(";
        $dataTail .= "'" . implode("', '", $dataBody) . "'";
        $dataTail .= ")";

        $data .= "(`" . implode("`, `",$dataHead) . "`) VALUES " . $dataTail;

        $sql = " INSERT INTO `" . $dbName . "` " . $data . "  ";
        
        $sql .= " ON DUPLICATE KEY UPDATE ";
        
        $sqlTail = "";
        foreach ( $dataHead as $key => $val ) {
            if ( !empty($sqlTail) ) $sqlTail .= ", ";
            $sqlTail .= " `$val`=VALUES(`$val`) ";
        }
        
        $sql .= $sqlTail;
        
        return $this->doQuery($sql);
    }

    /** 
     * Delete MySql table row
     * @param string $dbName Database table name
     * @param array $dataArray What deleting ( $array[field] = value )
     * @param array $dataNotDeleteArray What NOT deleting ( $array[field] = value )
     * @return boolean
     */
    public function deleteFrom( $dbName, $dataArray = array(), $dataNotDeleteArray = array() ) {
        $dbName = str_replace( "#__", $this->sqlprefix, $dbName );

        if ( empty($dbName) OR empty($dataArray) OR !is_array($dataArray) ) {
            return FALSE;
        }

        $data = "";
        $dataHead = Array();
        $dataBody = Array();

        if ( !empty($dataArray) && is_array($dataArray) ) {

            $dataTail = "";

            foreach ( $dataArray as $key => $val ) {
                if ( !empty($dataTail) ) { $dataTail .= " AND "; }
                $dataTail .= " `" . $key . "` = '" . $this->dbconnect->real_escape_string($val) . "' ";
            }

            $data .= " WHERE " . $dataTail;

        } elseif ( !empty($dataArray) && $dataArray == 'ALL' ) {
            $data .= "WHERE 1";
        }
        
        if ( !empty($dataNotDeleteArray) && is_array($dataNotDeleteArray) ) {
            $dataTail = "";

            foreach ( $dataNotDeleteArray as $key => $val ) {
                if ( !empty($dataTail) ) { $dataTail .= " AND "; }
                $dataTail .= " `" . $key . "` != '" . $this->dbconnect->real_escape_string($val) . "' ";
            }
            $data .= " AND (".$dataTail.")";
        }

        $sql = " DELETE FROM `" . $dbName . "` " . $data . "  ;";

        return $this->doQuery($sql);
    }
    
    public function setJSONIn( $dbName, $idArray, $JSON_key, $JSON_path, $JSON_path2, $JSON_value ) {
        $dbName = str_replace( "#__", $this->sqlprefix, $dbName );

        if ( empty($dbName) OR empty($idArray) OR !is_array($idArray) OR empty($JSON_key) OR $JSON_path=="" OR $JSON_path2=="" OR empty($JSON_value) ) {
            return FALSE;
        }

        $data = " SET ";
        $dataTemp = "`$JSON_key` = IF(`$JSON_key` IS NULL, JSON_OBJECT('$JSON_path[$JSON_path2]', '" . $this->dbconnect->real_escape_string($JSON_value) . "'),JSON_SET(`$JSON_key`, '$[$JSON_path][$JSON_path2]' , '" . $this->dbconnect->real_escape_string($JSON_value) . "' ))";
        
        $data .= $dataTemp;
        unset($dataTemp);

        $data .= " WHERE ";
        $emptyData = TRUE;
        foreach ( $idArray as $k=>$v ) {
            if ( $emptyData === FALSE ) { $data .= ' AND '; } else { $emptyData = FALSE; }
            $data .= "`" . $k . "` = '" . $this->dbconnect->real_escape_string($v) . "'";
        }

        $sql = " UPDATE `" . $dbName . "` " . $data . "  ;";

        return $this->doQuery($sql);
    }
    
    
    public function deleteJSONIn( $dbName, $idArray, $JSON_key, $JSON_path, $JSON_path2 ) {
        $dbName = str_replace( "#__", $this->sqlprefix, $dbName );

        if ( empty($dbName) OR empty($idArray) OR !is_array($idArray) OR empty($JSON_key) OR $JSON_path=="" OR $JSON_path2=="" ) {
            return FALSE;
        }

        $data = " SET ";
        $dataTemp = "`$JSON_key` = JSON_REMOVE(`$JSON_key`, '$.$JSON_path.$JSON_path2')";
        
        $data .= $dataTemp;
        unset($dataTemp);

        $data .= " WHERE ";
        $emptyData = TRUE;
        foreach ( $idArray as $k=>$v ) {
            if ( $emptyData === FALSE ) { $data .= ' AND '; } else { $emptyData = FALSE; }
            $data .= "`" . $k . "` = '" . $this->dbconnect->real_escape_string($v) . "'";
        }

        $sql = " UPDATE `" . $dbName . "` " . $data . "  ;";

        return $this->doQuery($sql);
    }
    
    /**
     * Create new simple database query
     */
    public function newQuery() {
        $this->_dbdata = [];
        $this->_dbdata[0] = [
            'select' => '',
            'from' => '',
            'join' => [],
            'where' => '',
            'group' => '',
            'order' => '',
            'limit' => '',
            'cache' => FALSE,
            'queryType' => 'array'
        ];
        return $this;
    }
    private function newQueryIncluce($level) {
        $this->_dbdata[$level] = [
            'select' => '',
            'from' => '',
            'join' => [],
            'where' => '',
            'group' => '',
            'order' => '',
            'limit' => ''
        ];
    }
    
    /**
     * Select what row is needed in database query
     * @param static $content what value is want from the table
     */
    public function select($content) {
        $this->_dbdata[$this->_dbdata_level]['select'] = $content;
        return $this;
    }
        private function sAnd() {
            if (cb_is_not_empty($this->_dbdata[$this->_dbdata_level]['select'])) { $this->_dbdata[$this->_dbdata_level]['select'] .= ", "; }
            return $this;
        }
        public function sSelect($select,$alias="",$pre=NULL) {
            if ( is_array($select) ) { $selectArray = $select; } else { $selectArray[] = $select; }
            foreach ( $selectArray as $selectValue ) {
                $this->sAnd();
                if (!empty($pre)) { $this->_dbdata[$this->_dbdata_level]['select'] .= "`$pre`."; }
                $this->_dbdata[$this->_dbdata_level]['select'] .= "`$selectValue`";
                if (!empty($alias)) { $this->_dbdata[$this->_dbdata_level]['select'] .= " AS `$alias`"; }
            }
            return $this;
        }
        public function sSelectAll($pre=NULL) {
            $this->sAnd();
            if (!empty($pre)) { $this->_dbdata[$this->_dbdata_level]['select'] .= "`$pre`."; }
            $this->_dbdata[$this->_dbdata_level]['select'] .= "*";
            return $this;
        }
        public function sCount($select,$alias="",$pre=NULL) {
            if ( is_array($select) ) { $selectArray = $select; } else { $selectArray[] = $select; }
            foreach ( $selectArray as $selectValue ) {
                $this->sAnd();
                $this->_dbdata[$this->_dbdata_level]['select'] .= "COUNT(";
                if (!empty($pre)) { $this->_dbdata[$this->_dbdata_level]['select'] .= "`$pre`."; }
                $this->_dbdata[$this->_dbdata_level]['select'] .= "`$selectValue`";
                $this->_dbdata[$this->_dbdata_level]['select'] .= ")";
                if (!empty($alias)) { $this->_dbdata[$this->_dbdata_level]['select'] .= " AS `$alias`"; }
            }
            return $this;
        }
        public function sSum($select,$alias="",$pre=NULL) {
            if ( is_array($select) ) { $selectArray = $select; } else { $selectArray[] = $select; }
            foreach ( $selectArray as $selectValue ) {
                $this->sAnd();
                $this->_dbdata[$this->_dbdata_level]['select'] .= "SUM(";
                if (!empty($pre)) { $this->_dbdata[$this->_dbdata_level]['select'] .= "`$pre`."; }
                $this->_dbdata[$this->_dbdata_level]['select'] .= "`$selectValue`";
                $this->_dbdata[$this->_dbdata_level]['select'] .= ")";
                if (!empty($alias)) { $this->_dbdata[$this->_dbdata_level]['select'] .= " AS `$alias`"; }
            }
            return $this;
        }
        public function sAnyValue($select,$alias="",$pre=NULL) {
            if ( is_array($select) ) { $selectArray = $select; } else { $selectArray[] = $select; }
            foreach ( $selectArray as $selectValue ) {
                $this->sAnd();
                $this->_dbdata[$this->_dbdata_level]['select'] .= "ANY_VALUE(";
                if (!empty($pre)) { $this->_dbdata[$this->_dbdata_level]['select'] .= "`$pre`."; }
                $this->_dbdata[$this->_dbdata_level]['select'] .= "`$selectValue`";
                $this->_dbdata[$this->_dbdata_level]['select'] .= ")";
                if (!empty($alias)) { $this->_dbdata[$this->_dbdata_level]['select'] .= " AS `$alias`"; }
            }
            return $this;
        }
        public function sJSONType($select,$path,$alias="",$pre=NULL) {
            if ( is_array($select) ) { $selectArray = $select; } else { $selectArray[] = $select; }
            foreach ( $selectArray as $selectValue ) {
                $this->sAnd();
                $this->_dbdata[$this->_dbdata_level]['select'] .= "JSON_TYPE(JSON_EXTRACT(";
                if (!empty($pre)) { $this->_dbdata[$this->_dbdata_level]['select'] .= "`$pre`."; }
                $this->_dbdata[$this->_dbdata_level]['select'] .= "`$selectValue`,'$.".$path."'";
                $this->_dbdata[$this->_dbdata_level]['select'] .= "))";
                if (!empty($alias)) { $this->_dbdata[$this->_dbdata_level]['select'] .= " AS `$alias`"; }
            }
            return $this;
        }
    
    /**
     * Select table in database query
     * @param static $content database table name
     */
    public function from($content) {
        $this->_dbdata[$this->_dbdata_level]['from'] = $content;
        return $this;
    }
    
    public function fFrom($select,$pre='') {
        $this->_dbdata[$this->_dbdata_level]['from'] .= "`".$select."`";
        if (!empty($pre)) { $this->_dbdata[$this->_dbdata_level]['from'] .= " `$pre`"; }
        return $this;
    }
    
    /**
     * Connenc other table to a simple query
     * @param value $jointype mysql join type parameter in these value ( <u>INNER</u> ; <u>OUTER</u> ; <u>LEFT</u> ; <u>RIGHT</u> )
     * @param mysql_join_on $content parameter after ON text
     */
    public function join($jointype, $content = NULL) {

        if ( $content == NULL ) { 
            print "FATAL ERROR: EMPTY DATABASE JOIN VALUE! ";exit;
        }

        $jointype = strtolower(trim($jointype));
        if ( $jointype == "inner" ) {
            $this->_dbdata[$this->_dbdata_level]['join'][] = array($jointype, $content);
        } else if( $jointype == "outer" ) {
            $this->_dbdata[$this->_dbdata_level]['join'][] = array($jointype, $content);
        } else if( $jointype == "left" ) {
            $this->_dbdata[$this->_dbdata_level]['join'][] = array($jointype, $content);
        } else if( $jointype == "right" ) {
            $this->_dbdata[$this->_dbdata_level]['join'][] = array($jointype, $content);
        } else {
            print "FATAL ERROR: INVALID DATABASE JOIN TYPE: ".$jointype;exit;
        }

        $this->_dbdata[$this->_dbdata_level]['join'][] = $content;
        return $this;
    }
    
    /**
     * Database query WHERE parameter (MYSQL style)
     * @param mysql_parameter $content after mysql <b>WHERE</b> parameter
     */
    public function where($content) {
        $this->_dbdata[$this->_dbdata_level]['where'] = $content;
        return $this;
    }
        private function wAnd() {
            if ( $this->_dbdata_orAndNextEmpty === TRUE ) { $this->_dbdata_orAndNextEmpty = FALSE; RETURN NULL; };
            if (cb_is_not_empty($this->_dbdata[$this->_dbdata_level]['where'])) { $this->_dbdata[$this->_dbdata_level]['where'] .= " AND "; }
            return $this;
        }
        private function wOr() {
            if ( $this->_dbdata_orAndNextEmpty === TRUE ) { $this->_dbdata_orAndNextEmpty = FALSE; RETURN NULL; };
            if (cb_is_not_empty($this->_dbdata[$this->_dbdata_level]['where'])) { $this->_dbdata[$this->_dbdata_level]['where'] .= " OR "; }
            return $this;
        }
        private function wPre($pre) {
            if (!empty($pre)) { $this->_dbdata[$this->_dbdata_level]['where'] .= "`$pre`."; }
            return $this;
        }
        public function wAndBracketStart() {
            $this->wAnd();
            $this->_dbdata_orAndNextEmpty = TRUE;
            $this->_dbdata[$this->_dbdata_level]['where'] .= "(";
            return $this;
        }
        public function wOrBracketStart() {
            $this->wOr();
            $this->_dbdata_orAndNextEmpty = TRUE;
            $this->_dbdata[$this->_dbdata_level]['where'] .= "(";
            return $this;
        }
        public function wAndNotBracketStart() {
            $this->wAnd();
            $this->_dbdata_orAndNextEmpty = TRUE;
            $this->_dbdata[$this->_dbdata_level]['where'] .= "NOT (";
            return $this;
        }
        public function wOrNotBracketStart() {
            $this->wOr();
            $this->_dbdata_orAndNextEmpty = TRUE;
            $this->_dbdata[$this->_dbdata_level]['where'] .= "NOT (";
            return $this;
        }
        public function bracketEnd() {
            $this->_dbdata[$this->_dbdata_level]['where'] .= ")";
            return $this;
        }
        public function be() { return $this->bracketEnd(); }
        
        public function wAndInBracketStart() {
            $this->wAnd();
            $this->_dbdata_orAndNextEmpty = TRUE;
            $this->_dbdata[$this->_dbdata_level]['where'] .= "IN (";
            $this->_dbdata_level++;
            $this->newQueryIncluce($this->_dbdata_level);
            return $this;
        }
        public function wOrInBracketStart() {
            $this->wOr();
            $this->_dbdata_orAndNextEmpty = TRUE;
            $this->_dbdata[$this->_dbdata_level]['where'] .= "IN (";
            $this->_dbdata_level++;
            $this->newQueryIncluce($this->_dbdata_level);
            return $this;
        }
        public function bracketEndIn() {
            $sql=$this->build($this->_dbdata_level); 
            $this->_dbdata_level--;
            $this->_dbdata[$this->_dbdata_level]['where'] .= $sql.")";
            return $this;
        }
        public function bei() { return $this->bracketEndIn(); }
        
        public function wAndIsEqual($when,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` = '$what'";
            return $this;
        }
        public function wAndIsNotEqual($when,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` != '$what'";
            return $this;
        }
        public function wAndIsEqualOrBigger($when,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` >= '$what'";
            return $this;
        }
        public function wAndIsEqualOrSmaller($when,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` <= '$what'";
            return $this;
        }
        public function wAndIsBigger($when,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` > '$what'";
            return $this;
        }
        public function wAndIsSmaller($when,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` < '$what'";
            return $this;
        }
        public function wAndIsLike($when,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` LIKE '$what'";
            return $this;
        }
        public function wAndIsLikeP($when,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` LIKE '%$what%'";
            return $this;
        }
        public function wAndIsNotLike($when,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` NOT LIKE '$what'";
            return $this;
        }
        public function wAndIsBetween($when,$what1,$what2,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` BETWEEN '$what1' AND '$what2'";
            return $this;
        }
        public function wAndIsNotBetween($when,$what1,$what2,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` NOT BETWEEN '$what1' AND '$what2'";
            return $this;
        }
        public function wAndIsNull($when,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` IS NULL";
            return $this;
        }
        public function wAndIsNotNull($when,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` IS NOT NULL";
            return $this;
        }
        public function wAndIsEqualJSON($when,$in,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' = '$what'";
            return $this;
        }
        public function wAndIsNotEqualJSON($when,$in,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' != '$what'";
            return $this;
        }
        public function wAndIsEqualOrBiggerJSON($when,$in,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' >= '$what'";
            return $this;
        }
        public function wAndIsEqualOrSmallerJSON($when,$in,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' <= '$what'";
            return $this;
        }
        public function wAndIsBiggerJSON($when,$in,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' > '$what'";
            return $this;
        }
        public function wAndIsSmallerJSON($when,$in,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' < '$what'";
            return $this;
        }
        public function wAndIsLikeJSON($when,$in,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' LIKE '$what'";
            return $this;
        }
        public function wAndIsLikePJSON($when,$in,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' LIKE '%$what%'";
            return $this;
        }
        public function wAndIsNotLikeJSON($when,$in,$what,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' NOT LIKE '$what'";
            return $this;
        }
        public function wAndIsBetweenJSON($when,$in,$what1,$what2,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' BETWEEN '$what1' AND '$what2'";
            return $this;
        }
        public function wAndIsNotBetweenJSON($when,$in,$what1,$what2,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' NOT BETWEEN '$what1' AND '$what2'";
            return $this;
        }
        public function wAndIsNullJSON($when,$in,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' IS NULL";
            return $this;
        }
        public function wAndIsNotNullJSON($when,$in,$pre=NULL) {
            $this->wAnd();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' IS NOT NULL";
            return $this;
        }
        public function wOrIsEqual($when,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` = '$what'";
            return $this;
        }
        public function wOrIsNotEqual($when,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` != '$what'";
            return $this;
        }
        public function wOrIsEqualOrBigger($when,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` >= '$what'";
            return $this;
        }
        public function wOrIsEqualOrSmaller($when,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` <= '$what'";
            return $this;
        }
        public function wOrIsBigger($when,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` > '$what'";
            return $this;
        }
        public function wOrIsSmaller($when,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` < '$what'";
            return $this;
        }
        public function wOrIsLike($when,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` LIKE '$what'";
            return $this;
        }
        public function wOrIsLikeP($when,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` LIKE '%$what%'";
            return $this;
        }
        public function wOrIsNotLike($when,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` NOT LIKE '$what'";
            return $this;
        }
        public function wOrIsBetween($when,$what1,$what2,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` BETWEEN '$what1' AND '$what2'";
            return $this;
        }
        public function wOrIsNotBetween($when,$what1,$what2,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` NOT BETWEEN '$what1' AND '$what2'";
            return $this;
        }
        public function wOrIsNull($when,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` IS NULL";
            return $this;
        }
        public function wOrIsNotNull($when,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` IS NOT NULL";
            return $this;
        }
        public function wOrIsEqualJSON($when,$in,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' = '$what'";
            return $this;
        }
        public function wOrIsNotEqualJSON($when,$in,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' != '$what'";
            return $this;
        }
        public function wOrIsEqualOrBiggerJSON($when,$in,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' >= '$what'";
            return $this;
        }
        public function wOrIsEqualOrSmallerJSON($when,$in,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' <= '$what'";
            return $this;
        }
        public function wOrIsBiggerJSON($when,$in,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' > '$what'";
            return $this;
        }
        public function wOrIsSmallerJSON($when,$in,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' < '$what'";
            return $this;
        }
        public function wOrIsLikeJSON($when,$in,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' LIKE '$what'";
            return $this;
        }
        public function wOrIsLikePJSON($when,$in,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' LIKE '%$what%'";
            return $this;
        }
        public function wOrIsNotLikeJSON($when,$in,$what,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' NOT LIKE '$what'";
            return $this;
        }
        public function wOrIsBetweenJSON($when,$in,$what1,$what2,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' BETWEEN '$what1' AND '$what2'";
            return $this;
        }
        public function wOrIsNotBetweenJSON($when,$in,$what1,$what2,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' NOT BETWEEN '$what1' AND '$what2'";
            return $this;
        }
        public function wOrIsNullJSON($when,$in,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' IS NULL";
            return $this;
        }
        public function wOrIsNotNullJSON($when,$in,$pre=NULL) {
            $this->wOr();$this->wPre($pre);
            $this->_dbdata[$this->_dbdata_level]['where'] .= "`$when` -> '$.$in' IS NOT NULL";
            return $this;
        }
    /**
     * Database query grouping
     * @param mysql_parameter $content after mysql <b>GROUP</b> parameter
     */
    public function group($content) {
        $this->_dbdata[$this->_dbdata_level]['group'] = $content;
        return $this;
    }
    
    /**
     * Database query ordering
     * @param mysql_parameter $content after mysql <b>ORDER</b> parameter
     */
    public function order($content) {
        $this->_dbdata[$this->_dbdata_level]['order'] = $content;
        return $this;
    }
        private function oPre($pre) {
            if (!empty($pre)) { $this->_dbdata[$this->_dbdata_level]['order'] .= "`$pre`."; }
            return $this;
        }
        public function orderASC($c,$pre=NULL) {
            if ( !empty($this->_dbdata[$this->_dbdata_level]['order']) ) { $this->_dbdata[$this->_dbdata_level]['order'] .= ', '; }
            $this->oPre($pre);
            $this->_dbdata[$this->_dbdata_level]['order'] .= '`'.$c.'` ASC';
            return $this;
        }
        public function orderDESC($c,$pre=NULL) {
            if ( !empty($this->_dbdata[$this->_dbdata_level]['order']) ) { $this->_dbdata[$this->_dbdata_level]['order'] .= ', '; }
            $this->oPre($pre);
            $this->_dbdata[$this->_dbdata_level]['order'] .= '`'.$c.'` DESC';
            return $this;
        }
        
    /**
     * Database query limit
     * @param mysql_parameter $content after mysql <b>LIMIT</b> parameter
     */
    public function limit($content) {
        $this->_dbdata[$this->_dbdata_level]['limit'] = $content;
        return $this;
    }
    
    /**
     * Database cache enabling not work in DEBUG MODE!
     * @param boolean $cDef <b>TRUE</b> or <b>FALSE</b>
     */
    public function cache($cDef = FALSE) {
        if ( CB_DEBUG === 'true' ) {
            $cDef = FALSE;
        }
        $this->_dbdata[0]['cache'] = $cDef;
        return $this;
    }
    
    /**
     * Database query get result type
     * @param value $content value from ( <u>ARRAY</u> ; <u>ROW</u> ; <u>RESULT</u> ; <u>COUNT</u> ; <u>INTEGER</u> ; <u>INT</u> ; <u>FLOAT</u> )
     */
    public function queryType($content = "array") {
        $types = ['array','row','result','count','integer','int','float'];
        $content = strtolower(trim($content));
        if ( in_array($content,$types) ) {
            $this->_dbdata[0]['queryType'] = $content;
        } else {
            print "FATAL ERROR: INVALID DATABASE QUERY TYPE: ".$content;exit;
        }
        return $this;
    }
    
    /**
     * Database query get result type
     * @param value $content value from ( <u>ARRAY</u> ; <u>ROW</u> ; <u>RESULT</u> ; <u>COUNT</u> ; <u>INTEGER</u> ; <u>INT</u> ; <u>FLOAT</u> )
     */
    public function qtype($content) {
        $this->queryType($content);
        return $this;
    }
    
    /**
     * Execute simple database query
     * @return value count, or result, or array, what you want in a <b>queryType</b> parameter
     */
    public function execute() {
        $queryTypeRaw = $this->_dbdata[0]['queryType'];

        switch ($queryTypeRaw) {
            case 'array':
                $queryType = "getResultArray";
                break;
            case 'row':
                $queryType = "getRow";
                break;
            case 'result':
                $queryType = "getResult";
                break;
            case 'count':
                $queryType = "getNumberRows";
                break;
            case 'integer':
            case 'int':
                $queryType = "getInteger";
                break;
            case 'float':
                $queryType = "getFloat";
                break;
        }
        
        $sql = $this->build(0); 
        
        $sqlSHA = $queryTypeRaw . " " . $sql;
        
        if ( $this->_dbdata[0]['cache'] === TRUE ) {
            $mdVal = sha1($sqlSHA, TRUE);
            if ( isset($_SESSION['cachedRequest']) && isset($_SESSION['cachedRequest'][$mdVal]) ) {
                $return = $_SESSION['cachedRequest'][$mdVal];
            } else {
                $return = $_SESSION['cachedRequest'][$mdVal] = $this->$queryType($sql);
            }
        } else {
            $return = $this->$queryType($sql);
        }
        
        $this->newQuery();

        return $return;
    }
    
    private function build($level) {
        $select = " SELECT * ";
        $from = "";
        $join = "";
        $where = " WHERE 1 ";
        $group = "";
        $order = "";
        $limit = "";
        
        $select = " SELECT " . $this->_dbdata[$level]['select'] . " ";	
        $from = " FROM " . $this->_dbdata[$level]['from'] . " ";
        
        if ( !empty($this->_dbdata[$level]['join']) and is_array($this->_dbdata[$level]['join']) ) {
            foreach ( $this->_dbdata[$level]['join'] as $val ) {
                if ( $val[0] == 'inner' ) {
                    $join .= " INNER JOIN " . $val[1] . " ";
                } else if ( $val[0] == 'outner' ) {
                    $join .= " OUTER JOIN " . $val[1] . " ";
                } else if ( $val[0] == 'left' ) {
                    $join .= " LEFT JOIN " . $val[1] . " ";
                } else if ( $val[0] == 'right' ) {
                    $join .= " RIGHT JOIN " . $val[1] . " ";
                }
            }
        }
        
        if ( !empty($this->_dbdata[$level]['where']) ) $where = " WHERE " . $this->_dbdata[$level]['where'] . " ";
        if ( !empty($this->_dbdata[$level]['group']) ) $group = " GROUP BY " . $this->_dbdata[$level]['group'] . " ";
        if ( !empty($this->_dbdata[$level]['order']) ) $order = " ORDER BY " . $this->_dbdata[$level]['order'] . " ";
        if ( !empty($this->_dbdata[$level]['limit']) ) $limit = " LIMIT " . $this->_dbdata[$level]['limit'] . " ";
        
        $sql = " " . $select . $from . $join . $where . $group . $order . $limit . " ;";
        
        return $sql;
    }
}

return; ?>