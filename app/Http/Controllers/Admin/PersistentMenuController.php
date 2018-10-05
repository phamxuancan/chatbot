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


use App\FbPage;

class PersistentMenuController extends BaseController
{

    /**
     * Open List Facebook page
     */
    public function get(Request $request)
    {
        $action = $request->action;
        $page_id = 1;
        $getStartedButton = null;
        $menuList = null;

        $persistentMenu = PersistentMenu::findByPage($page_id);
        if ($persistentMenu) {
            $content = $persistentMenu->content;

            if ($content) {
                $objContent = json_decode($content);
                $getStartedButton = $objContent->getStartedButton;
                $menuList = $objContent->menuList;
            }
        }

        if ($action == 'get_started') {
            $keywordList = Keyword::all();

            return view(
                'persistent_get_started',
                array(
                    'getStartedButton' => $getStartedButton,
                    'keywordList' => $keywordList
                )
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
                'persistent',
                array(
                    'getStartedButton' => $getStartedButton,
                    'menuButtonList' => $menuList,
                )
            );
        }
    }

    public function update(Request $request)
    {
        $action = $request->action;
        $page_id = 1;

        if ($action == 'get_started') {
            $payload = $request->payload;

            $getStaredButton = null;
            $version = 0;
            $updatedAt = Carbon::now()->timestamp;

            $persistentMenu = $this->getCurrentPersistentMenu();

            $persistentMenuContainer = $this->convertToContainer($persistentMenu);

            $getStaredButton = $persistentMenuContainer->getStartedButton;
            if (!$getStaredButton) {
                $getStaredButton = new PersistentMenuGetStartedButton();
            } else {
                $version = $getStaredButton->version;
                $version++;
            }

            $getStaredButton->payload = $payload;
            $getStaredButton->version = $version;
            $getStaredButton->updatedAt = $updatedAt;

            $persistentMenuContainer->getStartedButton = $getStaredButton;

            $content = $this->convertToContent($persistentMenuContainer);

            if (!$persistentMenu) {
                $persistentMenu = new PersistentMenu();
            }
            $persistentMenu->page_id = $page_id;
            $persistentMenu->content = $content;
            $persistentMenu->save();
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
