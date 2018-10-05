<?php

namespace App\Http\Controllers\Admin;

use App\Constants;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\FbPage;

class FacebookActionController extends BaseController
{
    /**
     * Open List Facebook page
     */
    public function get()
    {
        $facebookPages = FbPage::all();

        return view('fbpage', array(
            'facebookPages' => $facebookPages
        ));
    }
    
}
