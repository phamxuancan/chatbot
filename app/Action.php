<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\ActionValue;

class Action extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'actions';


    public static function find($id)
    {
        return Action::where('id', $id)->first();
    }

    public function getValues()
    {
        return ActionValue::findValues($this->id);
    }

    public function getValuesCount()
    {
        return $this->getValues()->count();
    }

    public static function isExist($id)
    {
        return Action::where('id', $id)->count() > 0;
    }

    public static function getActions($type)
    {
        return Action::where('type', $type)->get();
    }



}
