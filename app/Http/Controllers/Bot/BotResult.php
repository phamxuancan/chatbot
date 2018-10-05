<?php

namespace App\Http\Controllers\Bot;

use App\Constants;


class BotResult
{
    public $page;
    public $action;
    public $values;

    public function __construct($page, $action, $values)
    {
        $this->page = $page;
        $this->action = $action;
        $this->values = $values;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function isActionMessage()
    {
        return $this->action && $this->action->type == Constants::ACTION_TYPE_MESSAGE;
    }

    public function getActionTitle()
    {
        return $this->action ? $this->action->title : 'No title';
    }

    public function getMessage()
    {
        if ($this->action && $this->action->type == Constants::ACTION_TYPE_MESSAGE) {
            if ($this->values && count($this->values) > 0) {
                $actionValue = $this->values[0];

                return $actionValue->value;
            }
        }

        return null;
    }

    public function isActionButton()
    {
        return $this->action && $this->action->type == Constants::ACTION_TYPE_BUTTON;
    }

    public function getValues()
    {
        return $this->values;
    }


}
