<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Demande_category;
use App\Models\User;
use App\Models\UserHasJobCategory;
use App\Models\UserHasRole;
use App\Traits\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DemandeController extends Controller
{
    use Utils;
    /**
     * Creation de la demande
     */
    public function newQuery(Request $request)
    {
        try {
            $validateDemande = Validator::make($request->all(), 
            [
                'description_demande'=>"required",
                'link_to_cv'=>"required",
                'domains'=> "required"
            ]);
            if($validateDemande->fails()){
                return response()->json([
                    'errors'=>$validateDemande->errors()
                ]); 
            }
            DB::beginTransaction();
            if (count($request->user()->roles) < 2) {
                if(!$request->user()->demande){
                    $demande = new Demande();
                    $demande->user_id = $request->user()->id;
                    $demande->enabled = false;
                    $demande->description_demande = $request->description_demande;
                    $demande->link_to_cv= $request->link_to_cv;
                    $demande->save();
                    foreach($request->domains as $domain){
                        $user_demande_categorie = new Demande_category();
                        $user_demande_categorie->demande_id = $demande->id;
                        $user_demande_categorie->category_formation_id = $domain;
                        $user_demande_categorie->save();
                    }
                    $request->user()->state = 'pending';
                    $request->user()->save();
                    DB::commit();
                    return response()->json(['message' => 'Demande cree avec success', 'demande'=>$demande]);
                }
                else{
                    return response()->json([
                    'warning'=>'vous avez deja effectuee une demande'
                    ]);
                }
            }
            DB::rollBack();
            return response()->json([
                'message' => 'vous etes deja un mentor'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'errors'=>$th->getMessage()
            ]);
        }
    }
    /**
     * valider une demande de mentoring
     */

    public function validateQuery($user, $demande)
    {
        try {
            if (
                !$this->didRecordExist($user, 'App\Models\User') || !$this->didRecordExist($demande, 'App\Models\Demande') ||
                !(User::find($user)->id == Demande::find($demande)->user_id)
            )
                return response()->json([
                    'errros' => 'Donnees incoherentes'
                ]);
            $customer = User::find($user);
            $qry = Demande::find($demande);
            if ((count($customer->roles) == 2) && ($qry->enabled == true))
                return response()->json(['error' => 'demande déja traitee']);
            $customer->state = 'validated';
            $customer->save();
            $qry->enabled = true;
            $qry->save();
            UserHasRole::firstOrCreate([
                'user_id' => $user,
                'role_id' => 1
            ]);
            return response()->json([
                'message' => 'Felicitation vous etes mentor'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
    /**
     * Recuperer tous les demandes
     */
    public function getDemande()
    {
        return Demande::with('user')->paginate(3);
    }
}
