<?php

require_once('DbConnect.php');
class GbEntry extends DbConnect {

    /* datenbankfelder */
    private $id_gbentry;
    private $author;
    private $title;
    private $text;
    private $date;
    
    public function __construct($author = "", $title = "", $text = "") {
    
        /* set fields */
        $this->author = $author;
        $this->title  = $title;
        $this->text   = $text;
        //$this->date   = $date;
        
        /* db infos from DbObject*/
        
        $this->table    = 'gbentry';
        $this->idField  = 'id_gbentry';
    }
    
    public static function newEntry($author = "", $title = "", $text = "") {
        
        if (empty($author))  $errors[] = "Name Fehlt.";
        if (empty($title))   $errors[] = "Titel fehlt.";
        if (empty($text))    $errors[] = "Beitrag fehlt.";

        if (count($errors) > 0) {
            return $errors;
        } else {
            $oEntry = new GbEntry($author, $title, $text);
            $retval = $oEntry->saveEntry();
            return $retval;
        }
    }
    
    public function saveEntry() {
        /* insert or update ? */
        
        $pdo_conn = $this->dbConnect();
        
        $stmt = $pdo_conn->prepare("INSERT INTO $this->table (`author`, `title`, `text`, `date`)
                                    VALUES (:author, :title, :text, NOW())");
                                    
        return $stmt->execute(array('author' => $this->author,
                                    'title'  => $this->title,
                                    'text'   => $this->text));
    }
    
    public function updateEntry() {
        /* insert or update ? */
    }
    
    public function deleteEntry() {
    }
    
    public function displayEntry() {
            $html .= "<hr>";
            $html .=  "Eintrag Nummer: " . $this->id_gbentry;
            $html .=  " von " . $this->author;
            $html .=  " vom " . date("d.m.Y - H:i:s", strtotime($this->date));
            $html .=  "<br>Titel: " . $this->title;
            $html .=  "<br>Text: ". str_replace("\n", "<br>", $this->text);
            $html .=  "<hr>";
            return $html;
    }
    
    public static function allEntries() {
        $oGbDummy = new GbEntry();
        $pdo_conn = $oGbDummy->dbConnect();
        return $pdo_conn->query("SELECT * FROM $oGbDummy->table")->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'GbEntry');
    }
}


?>