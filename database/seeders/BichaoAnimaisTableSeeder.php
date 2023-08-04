<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BichaoAnimaisTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('bichao_animais')->delete();

        \DB::table('bichao_animais')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Avestruz',
                'value_1' => '01',
                'value_2' => '02',
                'value_3' => '03',
                'value_4' => '04',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Águia',
                'value_1' => '05',
                'value_2' => '06',
                'value_3' => '07',
                'value_4' => '08',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Burro',
                'value_1' => '09',
                'value_2' => '10',
                'value_3' => '11',
                'value_4' => '12',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Borboleta',
                'value_1' => '13',
                'value_2' => '14',
                'value_3' => '15',
                'value_4' => '16',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Cachorro',
                'value_1' => '17',
                'value_2' => '18',
                'value_3' => '19',
                'value_4' => '20',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Cabra',
                'value_1' => '21',
                'value_2' => '22',
                'value_3' => '23',
                'value_4' => '24',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Carneiro',
                'value_1' => '25',
                'value_2' => '26',
                'value_3' => '27',
                'value_4' => '28',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Camelo',
                'value_1' => '29',
                'value_2' => '30',
                'value_3' => '31',
                'value_4' => '32',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Cobra',
                'value_1' => '33',
                'value_2' => '34',
                'value_3' => '35',
                'value_4' => '36',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'Coelho',
                'value_1' => '37',
                'value_2' => '38',
                'value_3' => '39',
                'value_4' => '40',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'Cavalo',
                'value_1' => '41',
                'value_2' => '42',
                'value_3' => '43',
                'value_4' => '44',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'Elefante',
                'value_1' => '45',
                'value_2' => '46',
                'value_3' => '47',
                'value_4' => '48',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            12 =>
            array (
                'id' => 13,
                'name' => 'Galo',
                'value_1' => '49',
                'value_2' => '50',
                'value_3' => '51',
                'value_4' => '52',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            13 =>
            array (
                'id' => 14,
                'name' => 'Gato',
                'value_1' => '53',
                'value_2' => '54',
                'value_3' => '55',
                'value_4' => '56',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            14 =>
            array (
                'id' => 15,
                'name' => 'Jacaré',
                'value_1' => '57',
                'value_2' => '58',
                'value_3' => '59',
                'value_4' => '60',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            15 =>
            array (
                'id' => 16,
                'name' => 'Leão',
                'value_1' => '61',
                'value_2' => '62',
                'value_3' => '63',
                'value_4' => '64',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            16 =>
            array (
                'id' => 17,
                'name' => 'Macaco',
                'value_1' => '65',
                'value_2' => '66',
                'value_3' => '67',
                'value_4' => '68',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            17 =>
            array (
                'id' => 18,
                'name' => 'Porco',
                'value_1' => '69',
                'value_2' => '70',
                'value_3' => '71',
                'value_4' => '72',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            18 =>
            array (
                'id' => 19,
                'name' => 'Pavão',
                'value_1' => '73',
                'value_2' => '74',
                'value_3' => '75',
                'value_4' => '76',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            19 =>
            array (
                'id' => 20,
                'name' => 'Peru',
                'value_1' => '77',
                'value_2' => '78',
                'value_3' => '79',
                'value_4' => '80',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            20 =>
            array (
                'id' => 21,
                'name' => 'Touro',
                'value_1' => '81',
                'value_2' => '82',
                'value_3' => '83',
                'value_4' => '84',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            21 =>
            array (
                'id' => 22,
                'name' => 'Tigre',
                'value_1' => '85',
                'value_2' => '86',
                'value_3' => '87',
                'value_4' => '88',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            22 =>
            array (
                'id' => 23,
                'name' => 'Urso',
                'value_1' => '89',
                'value_2' => '90',
                'value_3' => '91',
                'value_4' => '92',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            23 =>
            array (
                'id' => 24,
                'name' => 'Veado',
                'value_1' => '93',
                'value_2' => '94',
                'value_3' => '95',
                'value_4' => '96',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
            24 =>
            array (
                'id' => 25,
                'name' => 'Vaca',
                'value_1' => '97',
                'value_2' => '98',
                'value_3' => '99',
                'value_4' => '00',
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
        ));


    }
}
