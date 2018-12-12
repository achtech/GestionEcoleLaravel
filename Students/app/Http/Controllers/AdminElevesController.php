<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use PDF;

	class AdminElevesController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = false;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = true;
			$this->button_export = true;
			$this->table = "eleves";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Nom","name"=>"nom"];
			$this->col[] = ["label"=>"Prenom","name"=>"prenom"];
			$this->col[] = ["label"=>"Telephone","name"=>"tel_parents"];
			$this->col[] = ["label"=>"Nom Mere","name"=>"nom_mere"];
			$this->col[] = ["label"=>"Nom Pere","name"=>"nom_pere"];
			$this->col[] = ["label"=>"Annee scolaire","name"=>"(select libelle from annees_scolaires where id=(select max(id_annees_scolaire) from inscriptions,annees_scolaires where inscriptions.id_eleves=eleves.id and annees_scolaires.id=inscriptions.id_annees_scolaire)) as libelle"];
			//$this->col[] = ["label"=>"FRais","name"=>"(select frais_inscription from inscriptions where inscriptions.id_eleves=eleves.id and inscriptions.id_annees_scolaire=3) as frais_inscription"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Num Ordre','name'=>'num_ordre','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nom','name'=>'nom','type'=>'text','validation'=>'required|string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Prenom','name'=>'prenom','type'=>'text','validation'=>'required|string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nom Mere','name'=>'nom_mere','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Profession Mere','name'=>'profession_mere','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Date Naissance','name'=>'date_naissance','type'=>'date','validation'=>'date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Lieu Naissance','name'=>'lieu_naissance','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nom Pere','name'=>'nom_pere','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Profession Pere','name'=>'profession_pere','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Cin Pere','name'=>'cin_pere','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tel Mere','name'=>'tel_mere','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tel Domicile','name'=>'tel_domicile','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Adresse Parents','name'=>'adresse_parents','type'=>'textarea','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Adresse Personnels','name'=>'adresse_personnels','type'=>'textarea','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Ecole Precedente','name'=>'ecole_precedente','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tel Parents','name'=>'tel_parents','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Cin Mere','name'=>'cin_mere','type'=>'text','validation'=>'string|max:5000','width'=>'col-sm-10'];
			$columns = [];
//			$columns[] = ['label'=>'Date inscription','name'=>'date_inscription','type'=>'date','validation'=>'date','width'=>'col-sm-10'];
			$columns[] = ['label'=>"Numero d'inscription",'name'=>'num_inscription','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$columns[] = ['label'=>'Anné scolaire','name'=>'id_annees_scolaire','type'=>'datamodal','datamodal_table'=>'annees_scolaires','datamodal_columns'=>'libelle','datamodal_select_to'=>'libelle:id_annees_scolaire'];
			$columns[] = ['label'=>'Classes','name'=>'id_classes','type'=>'datamodal','datamodal_table'=>'classes','datamodal_columns'=>'libelle','datamodal_select_to'=>'libelle:id_classes'];
			$columns[] = ['label'=>"Frais d'inscription",'name'=>'frais_inscription','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$columns[] = ['label'=>"Frais mensuelle",'name'=>'frais_mensuelle','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Inscriptions','name'=>'inscriptions', 'type'=>'child','columns'=>$columns,'table'=>'inscriptions','foreign_key'=>'id_eleves'];

			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Num Ordre','name'=>'num_ordre','type'=>'number','validation'=>'integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nom','name'=>'nom','type'=>'text','validation'=>'required|string|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Prenom','name'=>'prenom','type'=>'text','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nom Mere','name'=>'nom_mere','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Profession Mere','name'=>'profession_mere','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Date Naissance','name'=>'date_naissance','type'=>'date','validation'=>'date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Lieu Naissance','name'=>'lieu_naissance','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nom Pere','name'=>'nom_pere','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Profession Pere','name'=>'profession_pere','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Cin Pere','name'=>'cin_pere','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tel Mere','name'=>'tel_mere','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tel Domicile','name'=>'tel_domicile','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Adresse Parents','name'=>'adresse_parents','type'=>'textarea','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Adresse Personnels','name'=>'adresse_personnels','type'=>'textarea','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Ecole Precedente','name'=>'ecole_precedente','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tel Parents','name'=>'tel_parents','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Cin Mere','name'=>'cin_mere','type'=>'text','validation'=>'string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Photo','name'=>'photo','type'=>'upload','validation'=>'image|max:3000','width'=>'col-sm-10','help'=>'File types support : JPG, JPEG, PNG, GIF, BMP'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = "
	        	$(function(){
	        		setInterval(function(){
			        	var tot=0;
			        	$('#table_paiements tbody .montant').each(function(){
			        		tot += parseInt($(this).text());
			        	})
						$('#table_paiements tfoot #total').val(tot);
	        		},500);
	        	})
	        ";


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }

	    public function getDetail($id){
	    	$anne = DB::table('inscriptions')->where('id_eleves',$id)->max('id_annees_scolaire');
	    	$data['page_title'] = "Fiche technique de l'eleves ";
	    	$data['row'] = DB::table('eleves')->where('id',$id)->first();
	    	$data['inscriptions'] = DB::table('inscriptions')->where('id_eleves',$id)->get();
	    	$data['paiements'] = DB::table('paiements_eleves')->where('id_eleves',$id)->where('id_annees_scolaire',$anne)->orderBy('date_paiements', 'asc')->get();
	    	$this->cbView('detail_eleves',$data);
	    }

	    public static function getValeurChamp($table,$select,$champ,$valeur){
	    	$result = DB::table($table)->where($champ,$valeur)->first();
	    	return $result->$select;
	    }

	    public static function getSumAbsences($idEleves,$idAnne){
	    	return DB::table('absences_eleves')->where('id_eleves',$idEleves)->where('id_classes',$idAnne)->sum('nbr_heurs')/8;
	    }
	    public static function getSumReatrds($idEleves,$idAnne){
	    	return DB::table('retards_eleves')->where('id_eleves',$idEleves)->where('id_classes',$idAnne)->sum('nbr_heurs');
	    }

	    function pdf($id)
	    {
		    $pdf = \App::make('dompdf.wrapper');
	    	$pdf->loadHTML($this->convert_student_data_to_html($id));
	    	return $pdf->stream();
	    }

        function convert_student_data_to_html($id)
	    {
	        $data = $this->getStudentData($id);
		    $output = "";
		    $headerPart="<div><div style='width:70%;float:left;background-color:yellow'><img src='../../../storage/app/".$data['impression']->logo."'/></div>";
		    $headerPart.="<div style='width:30%;float:left;background-color:yellow'>".$data['impression']->header."</div>";
		    $headerPart.="<div style='clear:both'></div></div><h3 align='center'>Fiche techinque de l'eleve</h3>";
		    $elevePart ="<h3 style='margin-top:30px'>L'éleve</h3>
		    <table width='100%'' style='border-collapse: collapse; border: 1px solid;''>
	<tr><th style='padding: 5px'>Nom :  				</th><td style='padding: 5px'>{$data['row']->nom}</td>
		<th style='padding: 5px'>Prenom : 			</th><td style='padding: 5px'>{$data['row']->prenom}</td></tr>
	<tr><th style='padding: 5px'>Date de naissances: </th><td style='padding: 5px'>{$data['row']->date_naissance}</td>
		<th style='padding: 5px'>Lieux de naissances:</th><td style='padding: 5px'>{$data['row']->lieu_naissance}</td></tr>
	<tr><th style='padding: 5px'>Tel domiciles: 		</th><td style='padding: 5px'>{$data['row']->tel_domicile}</td>
		<th style='padding: 5px'>Ecole precedente: 	</th><td style='padding: 5px'>{$data['row']->ecole_precedente}</td></tr>
		    </table>";
		    $parentPart ="<h3 style='margin-top:30px'>Les parents</h3>
		    <table width='100%'' style='margin-top:15px;border-collapse: collapse; border: 1px solid;''>
	<tr><th style='padding: 5px'>Nom du pére :  				</th><td style='padding: 5px'>{$data['row']->nom} {$data['row']->nom_pere}</td>
		<th style='padding: 5px'>Nom de la mere: 			</th><td style='padding: 5px'>{$data['row']->nom_mere}</td></tr>
	<tr><th style='padding: 5px'>C.I.N du pére: 				</th><td style='padding: 5px'>{$data['row']->cin_pere}</td>
		<th style='padding: 5px'>C.I.N de la mere: 			</th><td style='padding: 5px'>{$data['row']->cin_mere}</td></tr>
	<tr><th style='padding: 5px'>Profesion du pére : 		</th><td style='padding: 5px'>{$data['row']->profession_pere}</td>
		<th style='padding: 5px'>Profession du mere:		 	</th><td style='padding: 5px'>{$data['row']->profession_mere}</td></tr>
	<tr><th style='padding: 5px'>Tél. du pére:				</th><td style='padding: 5px'>{$data['row']->tel_parents}</td>
		<th style='padding: 5px'>Tel de la mere: 			</th><td style='padding: 5px'>{$data['row']->tel_mere}</td></tr>
	<tr><th style='padding: 5px'>Adresse personnels: 		</th><td style='padding: 5px' colspan='3'>{$data['row']->adresse_personnels}</td></tr>
		</table>
		    ";
	
	$inscriptionsPart="<h3 style='margin-top:30px'>Les etapes des études dans l'etablissement</h3>
	<table width='100%' style='margin-top:15px; border: 1px solid;'>
        <thead>
        	<tr>
                <th style='padding: 5px'>Numero inscription</th>
                <th style='padding: 5px'>Date inscription</th>
                <th style='padding: 5px'>Annees scolaires</th>
                <th style='padding: 5px'>Classe</th>
                <th style='padding: 5px'>Absences</th>
                <th style='padding: 5px'>Retards</th>
            </tr>
        </thead>
        <tbody>";
        	foreach($data['inscriptions'] as $ins){
		        $inscriptionsPart.="<tr>
	        		<td style='padding: 5px'>".$ins->num_inscription."</td>
	        		<td style='padding: 5px'>".$ins->date_inscription."</td>
	        		<td style='padding: 5px'>".$this->getValeurChamp('annees_scolaires','libelle','id',$ins->id_annees_scolaire)."</td>
	        		<td style='padding: 5px'>".$this->getValeurChamp('classes','libelle','id',$ins->id_classes)."</td>
	        		<td style='padding: 5px'>".$this->getSumAbsences($ins->id_eleves,$ins->id_classes)." jour(s)</td>
	        		<td style='padding: 5px'>".$this->getSumReatrds($ins->id_eleves,$ins->id_classes)." heur(s)</td>
        		</tr>";
        	}
        $inscriptionsPart.="</tbody></table>";

		    $paiementsPart="<h3 style='margin-top:30px'>Les etapes des études dans l'etablissement</h3>
	<table width='100%' style='margin-top:15px; border: 1px solid;'>
        <thead>
        	<tr>
        	    <th style='padding: 5px'>Date paiements</th>
                <th style='padding: 5px'>Mois </th>
                <th style='padding: 5px'>Motifs</th>
                <th style='padding: 5px'>Mode de paiements</th>
                <th style='padding: 5px'>Montant</th>
                </tr>
        </thead>
        <tbody>";
        	foreach($data['paiements'] as $pai){
        		$mois = ($pai->mois==0)?"Frais d'inscription":$pai->mois;
		        $paiementsPart.="<tr>".
		        "<td style='padding: 5px'>".$pai->date_paiements."</td>".
	        		"<td style='padding: 5px'>".$mois."</td>".
	        		"<td style='padding: 5px'>".$pai->motif."</td>".
	        		"<td style='padding: 5px'>".$this->getValeurChamp('mode_paiements','libelle','id',$pai->id_mode_paiements)."</td>".
	        		"<td style='padding: 5px'>".$pai->montant."</td>".
        		"</tr>";
        	}
        $paiementsPart.="</tbody></table>";

		    $output .= $headerPart;
		    $output .= $elevePart;
		    $output .= $parentPart;
		    $output .= $inscriptionsPart;
		    $output .= $paiementsPart;
		    return $output;
	    }

	    function getStudentData($id){
	    	$data = [];
	    	$anne = DB::table('inscriptions')->where('id_eleves',$id)->max('id_annees_scolaire');
	    	$data['row'] = DB::table('eleves')->where('id',$id)->first();
	    	$data['impression'] = DB::table('impression')->first();
	    	$data['inscriptions'] = DB::table('inscriptions')->where('id_eleves',$id)->get();
	    	$data['paiements'] = DB::table('paiements_eleves')->where('id_eleves',$id)->where('id_annees_scolaire',$anne)->orderBy('date_paiements', 'asc')->get();
	    	return $data;
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 


	}