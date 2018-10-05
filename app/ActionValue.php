<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionValue extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'action_values';

    public static function find($id){
        return ActionValue::where('id', $id)->first();
    }

    public static function findValues($actionId)
    {
        return ActionValue::where('action_id', $actionId)->get();
    }

    public static function isExist($id)
    {
        return Action::where('id', $id)->count() > 0;
    }
}
