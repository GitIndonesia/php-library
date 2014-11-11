<?php

class Database {
    
    private $config;
    /**
     * @var Object 
     */
    private static $instance;
    
    /**
     * @var Object
     */
    private $stmt;
    
    /**
     * @var array 
     */
    private $error = array();
    
    /**
     * @var int
     */
    private $sentinel = 1;
    
    /**
     * @var int 
     */
    private $affectedRows = 0;
    
    /**
     * @var int 
     */
    private $countRows = 0;
    
    /**
     * getInstance().
     */
    private function __construct() {
        $this->config = new Config();
        try {
            $this->instance = new PDO($this->config->driver.':host='.$this->config->dbhost.';dbname='.$this->config->dbname, $this->config->dbuser, $this->config->dbpass);
            return $this->instance;
        } catch (Exception $e) {
            echo "Connection Failed."; 
        }
    }
    
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function query($sql,$params = null) {
        if(isset($this->config->prefix)){
            $sql = str_replace('#__',$this->config->prefix,$sql);
        }
        $this->stmt = $this->instance->prepare($sql);
        $this->stmt->execute($params);
        $this->checkQuery();
    }
    
    public function Result(){
        $singleResult = $this->stmt->fetch(PDO::FETCH_NUM);
        return $singleResult[0];
    }
    
    public function Column(){
        $columnList = array();
        while($row = $this->stmt->fetch(PDO::FETCH_NUM)){
            $columnList[] = $row[0];
        }
        $this->countRows = count($columnList);
        return $columnList;
    }

    public function Object($class_name = "stdClass"){
        $object = $this->stmt->fetchObject($class_name);
        return $object;
    }
    
    public function ObjectList($class_name = "stdClass"){
        $objectList = array();
        while($object = $this->stmt->fetchObject($class_name)){
            $objectList[] = $object;
        }
        $this->countRows = count($objectList);
        return $objectList;
    }
    
    public function AssocRow(){
        $assocRow = $this->stmt->fetch(PDO::FETCH_ASSOC);
        return $assocRow;
    }
    
    public function AssocList(){
        $assocList = array();
        while($row = $this->stmt->fetch(PDO::FETCH_ASSOC)){
            $assocList[] = $row;
        }
        $this->countRows = count($assocList);
        return $assocList;
    }
    
    public function IndexedRow(){
        $indexedRow = $this->stmt->fetch(PDO::FETCH_NUM);
        return $indexedRow;
    }
    
    public function IndexedList(){
        $indexedList = array();
        while($row = $this->stmt->fetch(PDO::FETCH_NUM)){
            $indexedList[] = $row;
        }
        $this->countRows = count($indexedList);
        return $indexedList;
    }
    
    public function JsonObjectList(){
        return json_encode($this->AssocList());
    }
    
    /**
     * @param string $version version document XML.
     * @param string $encoding document XML.
     * @param string $root document.
     * @param string $elementName.
     * @return string
     */
    public function XmlDocument($file = null, $root = 'query',$elementName = 'entry'){
        $xml = new DOMDocument('1.0','utf-8');
        $table = $xml->createElement($root);
        foreach ($this->AssocList() as $entry){ 
            $element = $xml->createElement($elementName);
            foreach ($entry as $node => $value) {
                if ($this->valideXmlValue($value)) {
                    $field = $xml->createElement($node,$value);
                    $element->appendChild($field);
                } else {
                    $field = $xml->createElement($node);
                    $cdata = $xml->createCDATASection($value);
                    $field->appendChild($cdata);
                    $element->appendChild($field);
                }  
            }
            $table->appendChild($element);
        }
        $xml->appendChild($table);
        if ($file != null) {
            return file_put_contents($file, $xml->saveXML());
        } else {
            return $xml->saveXML();
        }
    } 
    
    public function CSVFile($file = null){
        if($file == null){
            $file = date('Ymd-His');
        }
        $writer = fopen($file.'.csv', 'w');
        $temp = $this->IndexedList();
        foreach ($temp as $row){
            fputcsv($writer, $row);
        }
        return fclose($writer); 
    }
    
    public function startTransaction(){
        $this->instance->beginTransaction();
        $this->sentinel = 1;
        $this->affectedRows = 0;
    }
    
    public function endTransaction(){
       if ($this->sentinel == 1) {
           $this->instance->commit();
       } else {
           $this->instance->rollBack();
       }
       return $this->sentinel;
    }
    
    public function getAffectedRows(){
        return $this->affectedRows;
    }

    public function getCountRows(){
        return $this->countRows;
    }

    public function getLastId(){
        return $this->instance->lastInsertId();
    }

    public function getError(){
        $e = array();
        $e['ref'] = $this->error[0];
        $e['code'] = $this->error[1];
        $e['desc'] = $this->error[2];
        return $e;
    }
    
    private function checkQuery(){
        $this->error = $this->stmt->errorInfo();
        if ($this->error[0] != 00000) {
            $this->sentinel = 0;
        }

        $this->affectedRows = $this->stmt->rowCount();
        if ($this->affectedRows == 0){
            $this->sentinel = 0;
        }
    }

    private function valideXmlValue($value){
        $chars = array('<','>','&');
        foreach($chars as $ilegal) {
            $state = strpos($value, $ilegal);
            if($state !== FALSE){
                return FALSE;
            }
        }
        return TRUE;
    }
}
?>
