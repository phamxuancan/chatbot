<?php

namespace App\Http\Controllers\Admin;

use App\Constants;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\FbPage;

class FacebookPageController extends BaseController
{
    /**
     * Open List Facebook page
     */
    public function get(Request $request)
    {
        $action = $request->action;
        if ($action == 'select') {
            $id = $request->id;
            session(['facebookPage' => $id]);
            session(['page_id' => $request->fanpage_id]);
            return redirect('keyword');
        } else {

            $facebookPages = FbPage::all();

            return view('fbpage', array(
                'facebookPages' => $facebookPages
            ));
        }
    }


}
