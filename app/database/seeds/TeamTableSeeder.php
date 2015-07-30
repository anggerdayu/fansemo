<?php

class TeamTableSeeder extends Seeder {

    public function run()
    {
        DB::table('teams')->truncate();

        Team::create(array('name'=>'Real Madrid','type' =>'club','logo_image'=>'realmadrid.png','jersey_image'=>'madrid.png'));
        Team::create(array('name'=>'Barcelona','type' =>'club','logo_image'=>'barcelona.png','jersey_image'=>'barca.png'));
    }

}