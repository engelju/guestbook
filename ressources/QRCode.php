<?PHP

include_once("$_SERVER[DOCUMENT_ROOT]//config5.inc.php");

/****c* _includes/classes5/QRCode
* NAME
*  QRCode -- Klasse QR Code
*
* DESCRIPTION
*  Diese Klasse repraesentiert einen QR Code und beinhaltet Methoden zur Verwaltung von
*  QR Codes.
*
******
*/


/**
 * This class manages a QR-code.
 *
 * @author 	Julie Engel
 * @class 	QRCode
 * @extends DbObject
 * @package pnn
 * @brief 	Get and set Constants, access rigths and other stuff
 */

class QRCode extends DbObject {

	/* datenbankfelder */
	public $id_qrcode;			/** primary key */
	public $link_plattform;		/** feld in dem text für qrcode gespeichert wird */
	public $link_qr;			/** redirect link, welcher auf den text weiterleitet (redirect-functionality) */
	public $tracking;			/** zähler für die anzahl aufrufe von $link_qr */
	public $erw_tracking;		/** enabled erweiteres tracking (UNUSED YET) */
	public $sprachversion;		/** sprache vom decodierten text, kann idr aus $link_plafform gewonnen werden */
	public $domain_id;			/** domain des decodierten textes, aus $link_plafform oder manuell */
	public $einstelldatum;		/** datum, an welchem $link_plafform in db gespeichert wurde */
	public $status;				/** 1 = aktiv, 0 = registriert aber inaktiv etc. */
	public $qr_picture_local;	/** locales gespeichertes qr bild (UNUSED YET) */

	/** Metadefinitionen, aus DbOject geerbt */
	public static $aMeta = array(
		'label' 		 => array('d' => 'QRCode', 	'f' => 'QRCode'),
		'label_plur' 	 => array('d' => 'QRCodes', 'f' => 'QRCodes'),
		'url_param_name' => 'qrid'
	);

	/**
	 * Constructor wird ausschliesslich zur Datenbankanbindung verwendet,
	 * um eine neue Instanz zu erstellen, bitte folgendermassen vorgehen:
	 *
	 * <code>
	 *		$oNewQRCode = QRCode::newQRCode();				// gibt leeres DbObj zurück
	 *		$oNewQRCode->createQRCode($qrcode_content);		// setzt defaults und qr_content
	 *		$oNewQRCode->update();							// und speichert diese in db
	 * </code>
	 *
	 * @param int $id
	 */
	public function QRCode($id) {

		/* datenbankinfos, aus DbObject geerbt */
		$this->db 	   = 'pnn_kunden';
		$this->id 	   = $id;
		$this->table   = 'qr_code';
		$this->idField = 'id_qrcode';

		$this->connectDB();

		if ($id != null) {
			$res = mysql_query("select *
								from $this->table
								where $this->idField = $this->id");

			if ($row = mysql_fetch_array($res)) {
				$this->id_qrcode = $row['id_qrcode'];
				$this->link_plattform = $row['link_plattform'];
				$this->link_qr = $row['link_qr'];
				$this->sprachversion = $row['sprachversion'];
				$this->tracking = $row['tracking'];
				$this->erw_tracking	= $row['erw_tracking'];
				$this->domain_id = $row['domain_id'];
				$this->einstelldatum = $row['einstelldatum'];
				$this->status = $row['status'];
				$this->qr_picture_local = $row['qr_picture_local'];	// unused?
			}
		} else {
			/* id nicht mitgegeben, evtl gerade newQRCode() aufrufen? */
		}
	}

	/**
	 * Erstellt leeres Objekt in der DB, welches dann in einem zweiten
	 * Schritt gefüllt wird.
	 *
	 * Um eine neue Instanz von QRCode zu erstellen, bitte immer diese
	 * Funktion benutzen (siehe auch Kommentar beim Constructor).
	 *
	 * @return new QRCode which is already in DB
	 */
	public static function newQRCode() {

		$oDummy = new QRCode(null);
		$oDummy->connectDB();

		$sql = "INSERT INTO $oDummy->table VALUES()";

		if (mysql_query($sql)) {
			return new QRCode(mysql_insert_id());
		}
	}

	/**
	 * Setzt die Defaultwerte und den QR-Text eines QRCode-Objektes.
	 *
	 * @param String $url
	 */
	public function createQRCode($qr_content) {

		$this->link_plattform = $qr_content;
		$this->link_qr = "http://www.pnn.ch/qr.php?id=$this->id";
		$this->einstelldatum = date('Y-m-d');

		// TODO:
		//		defaults für $sprache (von URL) und $domain (URL)
		//		funzen noch nicht.

		// FALSCH: diese nehmen die params von der actual URL
		global $sprache;
		global $did;

		/* get params from URL (FIXME: doesn't work yet) */
		if (isset($sprache)) {
			$this->sprachversion = $sprache;
		}
		if (isset($did)) {
			$this->domain_id = $did;
		}
	}

	// public static function getQRCode($id) { return new QRCode($id); }

 	/**
 	* Updates an existing QRCode from the DB.
 	*
 	* @class 	QRCode
 	* @method 	public update
 	*
 	* @return 	bool 0 if update successful, -1 if not
 	*/
	public function update() {

		$this->connectDB();

		$corr_id_qrcode 		= addslashes($this->id_qrcode);
		$corr_link_plattform 	= addslashes($this->link_plattform);
		$corr_link_qr 			= addslashes($this->link_qr);
		$corr_sprachversion 	= addslashes($this->sprachversion);
		$corr_tracking 			= addslashes($this->tracking);
		$corr_erw_tracking 		= addslashes($this->erw_tracking);
		$corr_domain_id 		= addslashes($this->domain_id);
		$corr_einstelldatum 	= addslashes($this->einstelldatum);
		$corr_status 			= addslashes($this->status);
		$corr_qr_picture_local 	= addslashes($this->qr_picture_local);

		$sql = "UPDATE $this->table
				 SET
				 	id_qrcode='$corr_id_qrcode',
				 	link_plattform='$corr_link_plattform',
				 	link_qr= '$corr_link_qr',
				 	sprachversion='$corr_sprachversion',
				 	tracking='$corr_tracking',
				 	erw_tracking='$corr_erw_tracking',
				 	domain_id='$corr_domain_id',
				 	einstelldatum='$corr_einstelldatum',
				 	status='$corr_status',
				 	qr_picture_local='$corr_qr_picture_local'
				 WHERE $this->idField='$this->id'";

		$res = mysql_query($sql);
		if (!$res) {
			$message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
			$message .= 'Gesamte Abfrage: ' . $sql;
			die($message);
			return -1;
		} else return 0;
	}

 	/**
 	* Deletes a QRCode from the DB.
 	*
 	* @class 	QRCode
 	* @method 	public drop
 	*
 	* @return 	bool deletion successful or not
 	*/
 	public function drop() {

 		$this->connectDB();

		/* delete from QRCode table */
 		$sql = "DELETE FROM $this->table
 				WHERE $this->idField='$this->id'";

 		$res = mysql_query($sql);
		if (!$res) {
			$message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
			$message .= 'Gesamte Abfrage: ' . $sql;
			die($message);
			return -1;
		} else return 0;
 	}

	/**
	 * Gibt den IMG-Tag des QR-Codes zurück.
	 *
	 * Anwendung wie folgt:
	 * 		<p>$oQRCode->getQRImageTag()</p>
	 * ergibt:
	 * 		<p><img src="ww.pnn.ch/_includes/scripts/qrcode/qr_img.php?d=HelloWorld" alt="This is the title"></p>
	 */
	public function getQRImageTag($aMore = array()) {
		global $PNN_HTTPS;

		if ($aMore['link'] == true) {
			return "<a href='$PNN_HTTPS/admin5/benutzer/scripts/qrcode/qr_img.php?d=$this->link_qr&s=40'><img src='$PNN_HTTPS/admin5/benutzer/scripts/qrcode/qr_img.php?d=$this->link_qr' alt='QRCode $this->link_plattform'></a>";
		}
		if ($aMore['size'] == 'big') {
			return "<img src='$PNN_HTTPS/admin5/benutzer/scripts/qrcode/qr_img.php?d=$this->link_qr&s=40' alt='QRCode $this->link_plattform'>";
		}

		// sane default
		return "<img src='$PNN_HTTPS/admin5/benutzer/scripts/qrcode/qr_img.php?d=$this->link_qr' alt='QRCode $this->link_plattform'>";
	}

} ?>