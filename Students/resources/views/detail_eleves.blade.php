@extends('crudbooster::admin_template')

@section('content')
<div class="col-md-12" align="right">
    <a href="{{ url('/detail_eleves/pdf/'.$row->id) }}" class="btn btn-danger" target="_blank">Convert into PDF</a>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		L'eleves
	</div>
	<div class="panel-body">
		<div class="row clearfix">
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <div class="card">
		            <div class="body">
		                <div class="row clearfix">
		                    <div class="col-sm-4">
		                        <label for="email_address">Nom : </label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->nom}}
		                            </div>
		                        </div>
		                        
		                        <label for="nbr_place">Prenom : </label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->prenom}}
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-sm-4">
		                        <label for="nbr_place">Date de naissances: </label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->date_naissance}}
		                            </div>
		                        </div>
		                        <label for="nbr_place">Lieux de naissances: </label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->lieu_naissance}}
		                            </div>
		                        </div>
		                    </div>

		                    <div class="col-sm-4">
		                        <label for="nbr_place">Tel domiciles: </label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->tel_domicile}}
		                            </div>
		                        </div>

		                        <label for="nbr_place">Ecole precedente: </label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->ecole_precedente}}
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		Les parents
	</div>
	<div class="panel-body">
		<div class="row clearfix">
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <div class="card">
		            <div class="body">
		                <div class="row clearfix">
		                    <div class="col-sm-4">
		                        <label for="email_address">Nom du pere</label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->nom}} {{$row->nom_pere}}
		                            </div>
		                        </div>
		                        <label for="nbr_place">Profession du pere</label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->profession_pere}}
		                            </div>
		                        </div>

		                        <label for="nbr_place">CIN du pere</label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->cin_pere}}
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-sm-4">
		                        <label for="nbr_place">Nom de la mere</label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->nom_mere}}
		                            </div>
		                        </div>

		                         <label for="nbr_place">Profession du mere</label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->profession_mere}}
		                            </div>
		                        </div>

		                        <label for="nbr_place">CIN de la mere</label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->cin_mere}}
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-sm-4">
		                        <label for="nbr_place">Tel du pere</label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->tel_parents}}
		                            </div>
		                        </div>
		                       
		                        <label class="form-label">Tel de la mere</label>
		                        <div class="form-group">
		                            <div class="form-line">
		                                {{$row->tel_mere}}
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label >Adresse personnels</lbael>
		                            <div class="form-line">
		                                {{$row->adresse_personnels}}
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		Les etapes des études dans l'etablissement
	</div>
	<div class="panel-body">
		<div class="row clearfix">
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                <div class="card">
              <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>Numero inscription</th>
                                <th>Date inscription</th>
                                <th>Annees scolaires</th>
                                <th>Classe</th>
                                <th>Absences</th>
                                <th>Retards</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($inscriptions as $ins)
                        	<tr>
                        		<td>{{$ins->num_inscription}}</td>
                        		<td>{{$ins->date_inscription}}</td>
                        		<td>{{EleveCtrl::getValeurChamp('annees_scolaires','libelle','id',$ins->id_annees_scolaire)}}</td>
                        		<td>{{EleveCtrl::getValeurChamp('classes','libelle','id',$ins->id_classes)}}</td>
                        		<td>{{EleveCtrl::getSumAbsences($ins->id_eleves,$ins->id_classes)}} jour(s)</td>
                        		<td>{{EleveCtrl::getSumReatrds($ins->id_eleves,$ins->id_classes)}} heur(s)</td>
                        	</tr>
                        	@endforeach
                        </tbody>
                    </table>
                  
                </div>
            </div>
        </div>

		    </div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		Les paiement effectué
	</div>
	<div class="panel-body">
		<div class="row clearfix">
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	          <div class="card">
              <div class="body">
                <div class="table-responsive">
                    <table id="table_paiements" class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>Date paiements</th>
                                <th>Mois </th>
                                <th>Motifs</th>
                                <th>Mode de paiements</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($paiements as $pai)
                        	<tr>
                        		<td>{{$pai->date_paiements}}</td>
                        		<td>{{$pai->mois==0?"Frais d'inscription":$pai->mois}}</td>
                        		<td>{{$pai->motif}}</td>
                        		<td>{{EleveCtrl::getValeurChamp('mode_paiements','libelle','id',$pai->id_mode_paiements)}}</td>
                        		<td class="montant">{{$pai->montant}}</td>
                        	</tr>
                        	@endforeach
                        </tbody>
                         <tfoot>
                            <tr>
                                <th colspan="3"></th>
                                <th>Somme</th>
                                <th><input type="text" disabled id="total"></span></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

		    </div>
		</div>
	</div>
</div>
<button type='submit' name='submit' class='btn btn-success' value="Imprimer"><i class='fa fa-file-pdf-o'></i> Imprimer</button>

@endsection