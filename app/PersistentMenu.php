<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\ActionValue;

class PersistentMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'persistent_menu';

    public static function find($id)
    {
        return PersistentMenu::where('id', $id)->fisrt();
    }

    public static function findByPage($page_id)
    {
        return PersistentMenu::where('page_id', $page_id)->first();
    }


}
