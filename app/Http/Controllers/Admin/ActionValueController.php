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

class ActionValueController extends BaseController
{

    /**
     * Open List Facebook page
     */
    public function get(Request $request)
    {
        $actionId = $request->action;
        if ($actionId && Action::isExist($actionId)) {

            $action = Action::find($actionId);
            $values = $action->getValues();

            return view('action_value',
                array(
                    'action' => $action,
                    'values' => $values
                )
            );
        } else {
            return redirect('action');
        }


    }

    public function update(Request $request)
    {
        if ($request->isMethod('get')) {
            $id = $request->id;

            $action_id = $request->action;
            $action = Action::find($action_id);

            if (!$id) {
                return view('action_value_create', array(
                    'action' => $action
                ));

            } else {
                $value = ActionValue::find($id);

                return view('action_value_update', array(
                    'action' => $action,
                    'objValue' => $value
                ));
            }
        } else if ($request->isMethod('post')) {
            $id = $request->id;
            $action_id = $request->action_id;
            $title = $request->title;
            $type = $request->type;
            $content = $request->value;
            $desc = $request->desc;

            $value = null;

            if ($id) {
                $value = ActionValue::find($id);
            } else {
                $value = new ActionValue();
            }
            $value->action_id = $action_id;
            $value->title = $title;
            $value->type = $type;
            $value->value = $content;
            $value->desc = $desc ? $desc : '';

            $value->save();

            return redirect('actionvalue?action=' . $action_id);
        }
        return null;
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $action_id = $request->action;
        $action = ActionValue::find($id);
        if ($action) {
            $action->delete();
        }
        return redirect('/actionvalue?action=' . $action_id);
    }


}
