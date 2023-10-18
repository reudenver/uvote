<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PartylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partylists = [
            [
                'code' => 'USP',
                'name' => 'United Students Party',
                'color' => '#823431',
                'photo' => "https://ui-avatars.com/api/?size=256&background=random&name=USP"
            ],
            [
                'code' => 'LaLiga',
                'name' => 'La Liga Party Y Lideres',
                'color' => '#ad0e0e',
                'photo' => "https://ui-avatars.com/api/?size=256&background=random&name=LaLiga"
            ],
            [
                'code' => 'MYL',
                'name' => 'Modern Youth Leaders',
                'color' => '#12b056',
                'photo' => "https://ui-avatars.com/api/?size=256&background=random&name=MYL"
            ],
            [
                'code' => 'Party P',
                'name' => 'Party P',
                'color' => '#4a28f2',
                'photo' => "https://ui-avatars.com/api/?size=256&background=random&name=PartyP"
            ],

        ];

        foreach ($partylists as $partylist) {
            DB::table('party_lists')->insert([
                'code' => $partylist['code'],
                'name' => $partylist['name'],
                'color' => $partylist['color'],
                'photo' => $partylist['photo']
            ]);
        }
    }
}
