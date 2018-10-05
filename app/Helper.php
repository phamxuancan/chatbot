<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;


class Helper extends Model
{
    public static function getKeywordAction($type)
    {
        $name = '';
        switch ($type) {
            case Constants::ACTION_TYPE_MESSAGE:
                $name = 'Tin nhắn';
                break;
            case Constants::ACTION_TYPE_BUTTON:
                $name = 'Các lựa chọn';
                break;
        }
        return $name;
    }

    public static function getValueType($type)
    {
        $name = '';
        switch ($type) {
            case Constants::VALUE_TYPE_MESSAGE:
                $name = 'Phản hồi';
                break;
            case Constants::ACTION_TYPE_BUTTON:
                $name = 'URL';
                break;
        }

        return $name;
    }

    public static function getChecked($value1, $value2)
    {
        return $value1 == $value2 ? 'checked' : '';
    }


    public static function makeURL($path)
    {
        return url($path);
    }

}
