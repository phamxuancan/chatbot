<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fbpages')->delete();

        DB::table('fbpages')->insert(
            [
                'id' => 1,
                'page_id' => '2123892054317667',
                'name' => 'My demo page',
                'url' => 'https://www.facebook.com/Demo-Page-2123892054317667/'
            ]
        );


        DB::table('actions')->delete();
        DB::table('actions')->insert(
            [
                'id' => 1,
                'page_id' => '1',
                'type' => '1',
                'name' => 'Response Text',
                'title' => 'This is a title',
                'desc' => 'Response text message'
            ]
        );

        DB::table('actions')->insert(
            [
                'id' => 2,
                'page_id' => '1',
                'type' => '2',
                'name' => 'Open Buttons',
                'title' => 'Do you want to press button?',
                'desc' => 'Open buttons'
            ]
        );

        DB::table('action_values')->delete();
        DB::table('action_values')->insert(
            [
                'id' => 1,
                'action_id' => 1,
                'type' => 1,
                'value' => 'Hello 1234',
                'title' => 'no need button',
                'desc' => ''
            ]
        );

        DB::table('action_values')->insert(
            [
                'id' => 2,
                'action_id' => 2,
                'type' => 2,
                'title' => 'Open Google Now',
                'value' => 'http://google.com',
                'desc' => ''
            ]
        );

        DB::table('action_values')->insert(
            [
                'id' => 3,
                'action_id' => 2,
                'type' => 1,
                'value' => 'show me',
                'title' => 'This is a post back',
                'desc' => ''
            ]
        );

        DB::table('keywords')->insert(
            [
                'id' => 1,
                'page_id' => 1,
                'action_id' => 1,
                'name' => 'hello',
                'value' => 'hello',
                'desc' => 'hello world'
            ]
        );

        DB::table('keywords')->insert(
            [
                'id' => 2,
                'page_id' => 1,
                'action_id' => 2,
                'name' => 'hello',
                'value' => 'hello button',
                'desc' => 'open button'
            ]
        );

    }
}
