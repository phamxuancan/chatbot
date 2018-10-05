<?php

namespace App\Http\Controllers\Bot;

use App\Constants;
use App\FbPage;
use App\Keyword;
use App\Action;
use App\ActionValue;
use App\Http\Controllers\Bot\BotResult;


class BotManHelper
{
    private $fbPageId;
    private $keyword;
    private $botResult = null;

    public function __construct($fbPageId, $keyword)
    {
        $this->fbPageId = $fbPageId;
        $this->keyword = $keyword;
    }

    public function startFinding()
    {
        $botKeyword = Keyword::findByKeyword($this->fbPageId, $this->keyword);

        if ($botKeyword) {
            $action = $botKeyword->getAction();

            if ($action) {
                $values = $action->getValues();
                if ($values) {
                    $this->botResult = new BotResult(null, $action, $values);
                }
            }
        }
    }

    public function hasAction()
    {
        return $this->botResult != null;
    }

    public function getResult()
    {
        return $this->botResult;
    }


}
