<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->truncate();

        User::create(array('username'=>'admin','email' =>'vendera.hadi@gmail.com','password'=>Hash::make('123456'),'phone'=>'021234567890','status'=>'management'));
        User::create(array('username'=>'member','email' =>'vendera@printerous.com','password'=>Hash::make('123456'),'phone'=>'021234567890','status'=>'member'));
    }

}