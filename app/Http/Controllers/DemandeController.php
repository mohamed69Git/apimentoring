<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\User;
use App\Models\UserHasRole;
use App\Traits\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemandeController extends Controller
{
    use Utils;
    /**
     * Creation de la demande
     */
    public function newQuery(Request $request)
    {
        if (count($request->user()->roles) < 2) {
            $demande = new Demande();
            $demande->user_id = $request->user()->id;
            $demande->enabled = false;
            $demande->save();
            $request->user()->state = 'pending';
            $request->user()->save();
            return response()->json(['message' => 'Demande cree avec success']);
        }
        return response()->json([
            'message' => 'vous etes deja un mentor'
        ]);
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
}
