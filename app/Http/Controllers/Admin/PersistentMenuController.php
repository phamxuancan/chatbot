<?php

namespace App\Http\Controllers\Admin;

use App\Action;
use App\ActionValue;
use App\Constants;
use App\Keyword;

use App\PersistentMenu;
use App\PersistentMenuContainer;
use App\PersistentMenuGetStartedButton;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use App\FbPage;

class PersistentMenuController extends BaseController
{

    /**
     * Open List Facebook page
     */
    public function get(Request $request)
    {
        $action = $request->action;
        $page_id = session('page_id');
        $check_exit = DB::table('persistent_menus')
        ->where('page_id', '=', $page_id)
        ->where('type', '=', 1)
        ->first();

        if ($action == 'get_started') {


            return view(
                'persistent_get_started',['start_menu'=>$check_exit]
            );
        } else if ($action == 'menu') {
            return view(
                'persistent_menu',
                array(
                    'menuList' => $menuList,
                )
            );
        } else {
            return view(
                'persistent'
            );
        }
    }

    public function update(Request $request)
    {
        $action = $request->action;
        $page_id = session('page_id');
        $input = Input::all();
        if ($action == 'get_started') {
            $check_exit = DB::table('persistent_menus')
            ->where('page_id', '=', $page_id)
            ->where('type', '=', 1)
            ->first();
            $content = $input['content'];
            if(empty($check_exit)){
                $last_id = DB::table('persistent_menus')->insert(
                    [
                        'title' => 'button_start',
                        'page_id' => $page_id,
                        'content' => $input['content'],
                        'type' => 1
                    ]
                );
            }else{
                dd($check_exit);
            }
            
            return redirect('persistent');
        } else if ($action == 'menu') {


        } else {


        }
        return $action . ' hello world';
    }


    protected function getCurrentPersistentMenu()
    {
        $page_id = 1;

        $persistentMenu = PersistentMenu::findByPage($page_id);

        return $persistentMenu;
    }

    protected function savePersistentMenu($persistentMenu, $getStartedButton)
    {

    }

    protected function convertToContainer($persistentMenu)
    {
        $persistentMenuContainer = new PersistentMenuContainer();

        if ($persistentMenu) {
            $content = $persistentMenu->content;

            if ($content) {
                $objContent = json_decode($content);
                $getStartedButton = $objContent->getStartedButton;
                $menuButtonList = $objContent->menuList;

                $persistentMenuContainer->getStartedButton = $getStartedButton;
                $persistentMenuContainer->menuList = $menuButtonList;
            }
        }

        return $persistentMenuContainer;
    }

    protected function convertToContent($persistentMenuContainer)
    {
        $result = '{}';
        if ($persistentMenuContainer) {
            $result = json_encode($persistentMenuContainer);
        }
        return $result;
    }

    public function updateMenu(Request $request)
    {
        if ($request->isMethod('get')) {

            return view('persistent_menu_create', array(

            ));

        } else if ($request->isMethod('post')) {

        } else {

        }
    }


}
