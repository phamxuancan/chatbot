<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\FbPage;
use App\Action;

class PersistentMenuButton
{
    public $id;
    public $parentId;
    public $type;
    public $title;
    public $payload;

}
