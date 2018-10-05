<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\FbPage;
use App\Action;

class Keyword extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'keywords';

    public static function find($id)
    {
        return Keyword::where('id', $id)->first();
    }

    public static function findByKeyword($fbPageId, $keyword)
    {
        $page = FbPage::find($fbPageId);
        if ($page) {
            return Keyword::where('page_id', $page->id)
                ->where('value', $keyword)->first();
        }
        return null;
    }

    public function getAction()
    {
        return Action::find($this->action_id);
    }

    public static function isExist($id)
    {
        return Keyword::where('id', $id)->count() > 0;
    }

    public function getType()
    {
        $action = $this->getAction();
        if ($action) {
            return $action->type;
        }
        return 0;
    }

}
