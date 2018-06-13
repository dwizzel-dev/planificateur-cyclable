<?php
class Utils {
	
	private $reg;
		
	public function __construct($reg) {
		$this->reg = $reg;
		}
		
	public function getTransfertNumber(){	
		$query = 'LOCK TABLE '.DB_PREFIX.'numbers WRITE;';
		$this->reg->get('db')->query($query);		
		$query = 'SELECT '.DB_PREFIX.'numbers.value AS "counter" FROM '.DB_PREFIX.'numbers WHERE '.DB_PREFIX.'numbers.name = "transfert_id" LIMIT 0,1';
		$rs = $this->reg->get('db')->query($query);	
		$cmd_id = $rs->rows[0]['counter'];
		$query = 'UPDATE '.DB_PREFIX.'numbers SET '.DB_PREFIX.'numbers.value = "'.($cmd_id + 1).'" WHERE '.DB_PREFIX.'numbers.name = "transfert_id"';
		$this->reg->get('db')->query($query);	
		$query = 'UNLOCK TABLES';
		$this->reg->get('db')->query($query);		
		return $cmd_id;
		}	
		
	public function getCategorieInfoFromPage($categorie_id){
		$query = 'SELECT '.DB_PREFIX.'page.link AS "link", '.DB_PREFIX.'page.position AS "position", '.DB_PREFIX.'page.name AS "name", '.DB_PREFIX.'page.name_en AS "name_en", '.DB_PREFIX.'page.image AS "image", '.DB_PREFIX.'page.brand_id AS "brand_id", '.DB_PREFIX.'page.categorie_id AS "categorie_id" FROM '.DB_PREFIX.'page WHERE '.DB_PREFIX.'page.categorie_id = "'.$categorie_id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];
			}
		return false;	
		}	
		

	public function getBrand(){
		$query = 'SELECT '.DB_PREFIX.'brand.id AS "id", '.DB_PREFIX.'brand.name AS "name", '.DB_PREFIX.'brand.image AS "image", '.DB_PREFIX.'brand.site AS "site", '.DB_PREFIX.'brand.slogan AS "slogan", '.DB_PREFIX.'brand.slogan_en AS "slogan_en" FROM '.DB_PREFIX.'brand ORDER BY '.DB_PREFIX.'brand.name ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}

	public function getBrandById($brand_id){
		$query = 'SELECT '.DB_PREFIX.'brand.id AS "id", '.DB_PREFIX.'brand.name AS "name", '.DB_PREFIX.'brand.name_en AS "name_en", '.DB_PREFIX.'brand.image AS "image", '.DB_PREFIX.'brand.site AS "site", '.DB_PREFIX.'brand.slogan AS "slogan", '.DB_PREFIX.'brand.slogan_en AS "slogan_en" FROM '.DB_PREFIX.'brand WHERE '.DB_PREFIX.'brand.id = "'.$brand_id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];
			}
		return false;	
		}	
		
	public function getBrandFromCategorieId($categorie_id){
		$query = 'SELECT '.DB_PREFIX.'brand.id AS "id", '.DB_PREFIX.'brand.name AS "name", '.DB_PREFIX.'brand.name_en AS "name_en", '.DB_PREFIX.'categorie_brand.image AS "image", '.DB_PREFIX.'categorie_brand.categorie_id AS "categorie_id" FROM '.DB_PREFIX.'categorie_brand LEFT JOIN '.DB_PREFIX.'brand ON '.DB_PREFIX.'categorie_brand.brand_id = '.DB_PREFIX.'brand.id WHERE '.DB_PREFIX.'categorie_brand.categorie_id = "'.$categorie_id.'" ORDER BY '.DB_PREFIX.'categorie_brand.position ASC;';
		$rs = $this->reg->get('db')->query($query);
		//echo $query;
		return $rs->rows;
		}	
		
	public function getTheme(){
		$query = 'SELECT '.DB_PREFIX.'theme.id AS "id", '.DB_PREFIX.'theme.name AS "name", '.DB_PREFIX.'theme.image AS "image" FROM '.DB_PREFIX.'theme ORDER BY '.DB_PREFIX.'theme.name ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}

	public function getThemeById($theme_id){
		$query = 'SELECT '.DB_PREFIX.'theme.id AS "id", '.DB_PREFIX.'theme.name AS "name", '.DB_PREFIX.'theme.name_en AS "name_en", '.DB_PREFIX.'theme.slogan AS "slogan", '.DB_PREFIX.'theme.slogan_en AS "slogan_en", '.DB_PREFIX.'theme.image AS "image" FROM '.DB_PREFIX.'theme WHERE '.DB_PREFIX.'theme.id = "'.$theme_id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];
			}
		return false;
		}

	public function getTypeById($type_id){
		$query = 'SELECT '.DB_PREFIX.'categorie.id AS "id", '.DB_PREFIX.'categorie.name AS "name", '.DB_PREFIX.'categorie.name_en AS "name_en", '.DB_PREFIX.'categorie.slogan AS "slogan", '.DB_PREFIX.'categorie.slogan_en AS "slogan_en", '.DB_PREFIX.'categorie.image AS "image" FROM '.DB_PREFIX.'categorie WHERE '.DB_PREFIX.'categorie.id = "'.$type_id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];
			}
		return false;
		}	
	
	public function getGrandeur(){
		$query = 'SELECT '.DB_PREFIX.'product_grandeur.id AS "id", '.DB_PREFIX.'product_grandeur.name AS "name", '.DB_PREFIX.'product_grandeur.name_en AS "name_en", '.DB_PREFIX.'product_grandeur.code AS "code", '.DB_PREFIX.'product_grandeur.code_en AS "code_en", '.DB_PREFIX.'product_grandeur.position AS "position", '.DB_PREFIX.'product_grandeur.ref_retail1 AS "ref_retail1" FROM '.DB_PREFIX.'product_grandeur ORDER BY '.DB_PREFIX.'product_grandeur.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}
	
	public function getCouleur(){
		$query = 'SELECT '.DB_PREFIX.'product_couleur.id AS "id", '.DB_PREFIX.'product_couleur.name AS "name", '.DB_PREFIX.'product_couleur.name_en AS "name_en", '.DB_PREFIX.'product_couleur.ref_retail1 AS "ref_retail1" FROM '.DB_PREFIX.'product_couleur  ORDER BY '.DB_PREFIX.'product_couleur.id ASC;;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}
		
	public function getProvince(){
		$query = 'SELECT '.DB_PREFIX.'province.id AS "id", '.DB_PREFIX.'province.name AS "name", '.DB_PREFIX.'province.name_en AS "name_en", '.DB_PREFIX.'province.code AS "code" FROM '.DB_PREFIX.'province  ORDER BY '.DB_PREFIX.'province.id ASC;;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	

	public function getDispo(){
		$query = 'SELECT '.DB_PREFIX.'product_dispo.id AS "id", '.DB_PREFIX.'product_dispo.name AS "name", '.DB_PREFIX.'product_dispo.name_en AS "name_en" FROM '.DB_PREFIX.'product_dispo  ORDER BY '.DB_PREFIX.'product_dispo.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	
		
	public function getLivraison(){
		$query = 'SELECT '.DB_PREFIX.'product_livraison_delai.id AS "id", '.DB_PREFIX.'product_livraison_delai.name AS "name", '.DB_PREFIX.'product_livraison_delai.name_en AS "name_en" FROM '.DB_PREFIX.'product_livraison_delai  ORDER BY '.DB_PREFIX.'product_livraison_delai.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	

	public function getCoupe(){
		$query = 'SELECT '.DB_PREFIX.'product_coupe.id AS "id", '.DB_PREFIX.'product_coupe.name AS "name", '.DB_PREFIX.'product_coupe.name_en AS "name_en", '.DB_PREFIX.'product_coupe.ref_retail1 AS "ref_retail1" FROM '.DB_PREFIX.'product_coupe  ORDER BY '.DB_PREFIX.'product_coupe.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	

	public function getMagasin(){
		$query = 'SELECT '.DB_PREFIX.'magasin.id AS "id", '.DB_PREFIX.'magasin.status AS "status", '.DB_PREFIX.'magasin.name AS "name", '.DB_PREFIX.'magasin.code AS "code", '.DB_PREFIX.'magasin.adresse AS "adresse", '.DB_PREFIX.'magasin.ville AS "ville", '.DB_PREFIX.'magasin.province_id AS "province_id", '.DB_PREFIX.'magasin.code_postal AS "code_postal", '.DB_PREFIX.'magasin.telephone AS "telephone", '.DB_PREFIX.'magasin.fax AS "fax", '.DB_PREFIX.'magasin.heures_ouvertures AS "heures_ouvertures", '.DB_PREFIX.'magasin.heures_ouvertures_en AS "heures_ouvertures_en", '.DB_PREFIX.'magasin.stationnement AS "stationnement", '.DB_PREFIX.'magasin.google_mapcoord AS "google_mapcoord", '.DB_PREFIX.'magasin.ref_retail1 AS "ref_retail1" FROM '.DB_PREFIX.'magasin  ORDER BY '.DB_PREFIX.'magasin.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}

	
	public function getSingleMagasin($magasin_id){
		$query = 'SELECT '.DB_PREFIX.'magasin.id AS "id", '.DB_PREFIX.'magasin.status AS "status", '.DB_PREFIX.'magasin.name AS "name", '.DB_PREFIX.'magasin.code AS "code", '.DB_PREFIX.'magasin.adresse AS "adresse", '.DB_PREFIX.'magasin.ville AS "ville", '.DB_PREFIX.'magasin.province_id AS "province_id", '.DB_PREFIX.'magasin.code_postal AS "code_postal", '.DB_PREFIX.'magasin.telephone AS "telephone", '.DB_PREFIX.'magasin.fax AS "fax", '.DB_PREFIX.'magasin.heures_ouvertures AS "heures_ouvertures", '.DB_PREFIX.'magasin.heures_ouvertures_en AS "heures_ouvertures_en", '.DB_PREFIX.'magasin.stationnement AS "stationnement", '.DB_PREFIX.'magasin.google_mapcoord AS "google_mapcoord", '.DB_PREFIX.'magasin.ref_retail1 AS "ref_retail1" FROM '.DB_PREFIX.'magasin WHERE '.DB_PREFIX.'magasin.id = "'.$magasin_id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows[0];
		}	

	public function getComposition(){
		$query = 'SELECT '.DB_PREFIX.'composition.id AS "id", '.DB_PREFIX.'composition.name AS "name", '.DB_PREFIX.'composition.name_en AS "name_en" FROM '.DB_PREFIX.'composition  ORDER BY '.DB_PREFIX.'composition.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	
		
	public function getLavage(){
		$query = 'SELECT '.DB_PREFIX.'product_lavage.id AS "id", '.DB_PREFIX.'product_lavage.name AS "name", '.DB_PREFIX.'product_lavage.name_en AS "name_en" FROM '.DB_PREFIX.'product_lavage  ORDER BY '.DB_PREFIX.'product_lavage.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}

	public function getSechage(){
		$query = 'SELECT '.DB_PREFIX.'product_sechage.id AS "id", '.DB_PREFIX.'product_sechage.name AS "name", '.DB_PREFIX.'product_sechage.name_en AS "name_en" FROM '.DB_PREFIX.'product_sechage  ORDER BY '.DB_PREFIX.'product_sechage.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	

	public function getJavelisant(){
		$query = 'SELECT '.DB_PREFIX.'product_javelisant.id AS "id", '.DB_PREFIX.'product_javelisant.name AS "name", '.DB_PREFIX.'product_javelisant.name_en AS "name_en" FROM '.DB_PREFIX.'product_javelisant  ORDER BY '.DB_PREFIX.'product_javelisant.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	

	public function getRepassage(){
		$query = 'SELECT '.DB_PREFIX.'product_repassage.id AS "id", '.DB_PREFIX.'product_repassage.name AS "name", '.DB_PREFIX.'product_repassage.name_en AS "name_en" FROM '.DB_PREFIX.'product_repassage  ORDER BY '.DB_PREFIX.'product_repassage.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	
		
	public function getItems(){
		$query = 'SELECT retail.inv_sku AS "id", class_desc AS "class_desc", inv_size_desc AS "grandeur_text", color_desc AS "couleur_text", size_group AS "coupe_text", inv2_store AS "magasin_code", inv_style AS "style", STOCK AS "quantite" FROM retail;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}

	public function getItemsWithFilter($arrFiltre){
		$strFiltre = '';
		foreach($arrFiltre as $k=>$v){
			$strFiltre .= '"'.$v.'",';
			}
		if($strFiltre != ''){
			$strFiltre = substr($strFiltre, 0, strlen($strFiltre)-1);
			}
		$query = 'SELECT retail.sty_supplier AS "fournisseur", retail.class_code AS "class_code", retail.inv_style AS "style", retail.inv_sku AS "id", retail.color_desc AS "couleur_text", retail.inv_size_desc AS "grandeur_text", retail.inv_width_desc AS "coupe_text" FROM retail WHERE retail.class_desc IN ('.$strFiltre.') GROUP BY retail.inv_sku ORDER BY retail.class_desc, retail.inv_sku, retail.color_desc, retail.inv_size_desc ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	
		
	public function getProductListWithFilter($arrFiltre){
		$strFiltre = '';
		foreach($arrFiltre as $k=>$v){
			$strFiltre .= '"'.$v.'",';
			}
		if($strFiltre != ''){
			$strFiltre = substr($strFiltre, 0, strlen($strFiltre)-1);
			}
		//on chercher le path de l'image aussi et le nom du produits
		$query = 'SELECT '.DB_PREFIX.'product.id AS "id", '.DB_PREFIX.'product.name AS "name", '.DB_PREFIX.'product.image AS "image" FROM '.DB_PREFIX.'product WHERE '.DB_PREFIX.'product.categorie_id IN ('.$strFiltre.');';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	
		
	public function getDistinctClassDescItems(){
		$query = 'SELECT '.DB_PREFIX.'product_desc_class.class_desc AS "class_desc", '.DB_PREFIX.'product_desc_class.class_code AS "class_code" FROM '.DB_PREFIX.'product_desc_class ORDER BY '.DB_PREFIX.'product_desc_class.class_desc ASC;';
		//$query = 'SELECT DISTINCT(retail.class_desc) AS "class_desc", retail.class_code AS "class_code" FROM retail ORDER BY retail.class_desc ASC;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}	

	public function getInventaireWithFiltre($filtre){
		$query = 'SELECT  '.DB_PREFIX.'product_inventaire.style_id AS "style_id", '.DB_PREFIX.'product_inventaire.sku AS "sku", '.DB_PREFIX.'product_inventaire.product_id AS "product_id", '.DB_PREFIX.'product_inventaire.grandeur_id AS "grandeur_id", '.DB_PREFIX.'product_inventaire.couleur_id AS "couleur_id", '.DB_PREFIX.'product_inventaire.coupe_id AS "coupe_id", '.DB_PREFIX.'product_inventaire.magasin_id AS "magasin_id", '.DB_PREFIX.'product_inventaire.quantite AS "quantite" FROM '.DB_PREFIX.'product_inventaire WHERE '.DB_PREFIX.'product_inventaire.style_id LIKE "%'.$filtre.'%" ORDER BY '.DB_PREFIX.'product_inventaire.style_id ASC;';
		//echo $query;
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows;
		}

	public function calculateTps($total){
		$prctTps = TPS;
		$tps = $total * $prctTps;
		return $tps;
		}

	public function calculateTvq($total){
		$prctTvq = TVQ;
		$tvq = $total * $prctTvq;
		return $tvq;
		}	
	
	public function CanToUsConvertion($total){
		//get the currency change for the day in the database
		$currency = 0.68;
		return $currency * $total;;
		}
	
	public function UsToCanConvertion($total){
		//get the currency change for the day in the database
		$currency = 1.4705882352941176470588235294118;
		return $currency * $total;;
		}	
	
	public function writeNewFile($filename, $content){
		$fh = fopen($filename, 'w');
		if($fh){
			fwrite($fh, $content);
			fclose($fh);
			}
		}	

	public function addHoursToDate($date, $hours){
		return date("Y-m-d H:i:s", strtotime($date) + ((60*60) * $hours));
		}	
		
	}
?>