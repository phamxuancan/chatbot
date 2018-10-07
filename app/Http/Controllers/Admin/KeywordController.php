<?php

namespace App\Http\Controllers\Admin;

use App\Action;
use App\ActionValue;
use App\Constants;
use App\Keyword;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\FbPage;

class KeywordController extends BaseController
{


    /**
     * Open List Facebook page
     */
    public function get(Request $request)
    {
        $fanpage_id  =  session('page_id');

        $keywords  = DB::table('keywords')
        ->join('actions', 'keywords.action_id', '=', 'actions.id')
        ->select('actions.type as action_type','keywords.*')
        ->where('keywords.page_id', '=', $fanpage_id)
        ->get();
        return view(
            'keyword',
            array(
                'keywords' => $keywords
            )
        );
    }

    public function update(Request $request)
    {
        if ($request->isMethod('get')) {

            $id = $request->id;
            $actionList = Action::getActions(Constants::ACTION_TYPE_BUTTON);

            if (!$id || !Keyword::isExist($id)) {
                return view('keyword_create', array(
                    'actionList' => $actionList
                ));
            } else {
                $keyword = Keyword::find($id);

                return view('keyword_update', array(
                    'keyword' => $keyword,
                    'actionList' => $actionList
                ));
            }

        } else if ($request->isMethod('post')) {

            $name = $request->name;
            $value = $request->value;
            $desc = $request->desc;
            $type = $request->type;
            $message = $request->keyword_message;

            //TODO: remove hard code page id
            $pageId = session('page_id');

            $id = $request->id;
            $keyword = null;
            if ($id && Keyword::isExist($id)) {
                $keyword = Keyword::find($id);
            } else {
                $keyword = new Keyword();
            }

            $action_id = $request->action_id;

            if ($type == Constants::ACTION_TYPE_MESSAGE) {
                if ($action_id) {
                    $action = Action::find($action_id);

                    $actionValues = $action->getValues();
                    if ($actionValues && count($actionValues) > 0) {
                        $actionValue = $actionValues[0];
                        $actionValue->value = $message;
                        $actionValue->save();
                    }
                } else {
                    //TODO: create action
                    $action = new Action();
                    $action->page_id = $pageId;
                    $action->name = '';
                    $action->title = '';
                    $action->desc = '';
                    $action->type = Constants::ACTION_TYPE_MESSAGE;
                    $action->save();

                    $action_id = $action->id;

                    $actionValue = new ActionValue();
                    $actionValue->action_id = $action_id;
                    $actionValue->title = '';
                    $actionValue->type = Constants::VALUE_TYPE_MESSAGE;
                    $actionValue->value = $message;
                    $actionValue->desc = '';

                    $actionValue->save();
                }
            } else if ($type == Constants::ACTION_TYPE_BUTTON) {
                $action_id = $request->keyword_action;
            }

            $keyword->page_id = $pageId;
            $keyword->name = $name;
            $keyword->value = $value;
            $keyword->desc = $desc;
            $keyword->action_id = $action_id;
            $keyword->save();

            return redirect('keyword');
        }
        return null;
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $keyword = Keyword::find($id);
        if ($keyword) {
            //$keyword->delete();
        }

        return redirect('keyword');
    }

}
