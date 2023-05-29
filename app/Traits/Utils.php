<?php

namespace App\Traits;

use App\Models\User;

trait Utils
{

    public function didRecordExist($id, $model)
    {
        if ($model::find($id))
            return true;
        return false;
    }
}
