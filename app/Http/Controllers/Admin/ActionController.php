<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Action;
use App\ActionValue;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


use App\FbPage;
use Illuminate\Support\Facades\Redirect;

class ActionController extends BaseController
{

    /**
     * Open List Facebook page
     */
    public function get(Request $request)
    {
        $page = $request->page;
        if (!$page) {
            $page = 1;
        }

        $skip = $page - 1 * Constants::PAGE_SIZE;

        $actions = Action::where('type', Constants::ACTION_TYPE_BUTTON)
            ->paginate(Constants::PAGE_SIZE);

        return view('action',
            array(
                'actions' => $actions,
                'page' => $page
            )
        );
    }

    public function update(Request $request)
    {
        if ($request->isMethod('get')) {
            $id = $request->id;
            if (!$id || !Action::isExist($id)) {
                return view('action_create', array());
            } else {
                $action = Action::find($id);

                return view('action_update', array(
                    'action' => $action
                ));
            }
        } else if ($request->isMethod('post')) {

            $name = $request->name;
            $title = $request->title;
            $desc = $request->desc;
            $type = Constants::ACTION_TYPE_BUTTON;
            //TODO: remove hard code page id
            $pageId = session('facebookPage');

            $id = $request->id;
            $action = null;
            if ($id && Action::isExist($id)) {
                $action = Action::find($id);
            } else {
                $action = new Action();
            }
            
            $action->page_id = $pageId;
            $action->name = $name;
            $action->title = $title;
            $action->desc = $desc;
            $action->type = $type;
            $action->save();

            return redirect('action');
        }
        return null;
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $action = Action::find($id);
        if ($action) {
            //$action->delete();
        }

        return redirect('action');
    }


}
