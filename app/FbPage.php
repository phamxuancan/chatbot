<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FbPage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fanpages';


    public static function find($id)
    {
        return FbPage::where('page_id', $id)->first();
    }

}
