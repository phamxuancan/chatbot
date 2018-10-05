<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fanpage extends Model
{
    public function messages()
        {
            return [
                'name.required' => 'Name is not blank',
                'fanpage_id.required'  => 'Fanpage Id is not Blank',
            ];
        }
}
