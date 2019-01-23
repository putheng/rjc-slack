<?php

use App\Approver;
use Illuminate\Database\Seeder;

class ApproverTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = [
        	[
        		'name' => 'Hirose Daichi',
        		'slackid' => 'UCCBRCTCZ',
        	],[
        		'name' => 'Shizuka Aoki',
        		'slackid' => 'UCFNQ3XRU',
        	],[
        		'name' => 'Choup Rotha',
        		'slackid' => 'UCCSTDGE6',
        	],[
        		'name' => 'Niioka Naoki',
        		'slackid' => 'UCF3N7R5G',
        	],[
        		'name' => 'Tivdararith',
        		'slackid' => 'UDFCN3Q2D',
        	],[
        		'name' => 'Masamichi Nasuno',
        		'slackid' => 'UDYFN8QMV',
        	],[
        		'name' => 'Phal Kun Kanha',
        		'slackid' => 'UCEADU7E2',
        	],[
        		'name' => 'But Kakada',
        		'slackid' => 'UCCNW35C3',
        	],[
        		'name' => 'Chhoeng Sreyleak',
        		'slackid' => 'UCD2VSGLQ',
        	]
        ];

        Approver::insert($value);
    }
}
