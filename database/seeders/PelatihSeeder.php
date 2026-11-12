<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelatihSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelatih')->upsert([
            [
                'id' => 1,
                'id_user' => 1,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '2002-12-27',
                'no_rek' => '901969282649 - Seabank',
            ],
            [
                'id' => 2,
                'id_user' => 2,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '2003-11-09',
                'no_rek' => '901107578867 (Sea Bank)',
            ],
            [
                'id' => 3,
                'id_user' => 3,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '1994-08-10',
                'no_rek' => '442801051359537 BRI suwandini susilawati',
            ],
            [
                'id' => 4,
                'id_user' => 4,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '2003-12-02',
                'no_rek' => '2102838249 - BNI',
            ],
            [
                'id' => 5,
                'id_user' => 5,
                'tempat_lahir' => 'Jombang',
                'tanggal_lahir' => '2003-08-31',
                'no_rek' => '901033284570 - SEA BANK',
            ],
            [
                'id' => 6,
                'id_user' => 6,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '2004-04-11',
                'no_rek' => '1310024807093 - Mandiri',
            ],
            [
                'id' => 7,
                'id_user' => 21,
                'tempat_lahir' => 'Tanggerang',
                'tanggal_lahir' => '1994-12-30',
                'no_rek' => '009401094338502 - BRI',
            ],
            [
                'id' => 8,
                'id_user' => 18,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '1995-04-16',
                'no_rek' => '7741150917 - BCA',
            ],
            [
                'id' => 9,
                'id_user' => 19,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '2005-07-17',
                'no_rek' => '901600961674 - Seabank',
            ],
            [
                'id' => 10,
                'id_user' => 20,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '1991-04-04',
                'no_rek' => '009401016637530 - BRI',
            ],
            [
                'id' => 11,
                'id_user' => 16,
                'tempat_lahir' => 'Sumedang',
                'tanggal_lahir' => '1999-12-01',
                'no_rek' => '7741567389  - BCA',
            ],
            [
                'id' => 12,
                'id_user' => 15,
                'tempat_lahir' => 'Karawang',
                'tanggal_lahir' => '1995-04-17',
                'no_rek' => '7741506398  - BCA',
            ]
        ], ['id'], ['id_user', 'tempat_lahir', 'tanggal_lahir', 'no_rek']);
    }
}
