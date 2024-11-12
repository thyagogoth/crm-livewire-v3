<?php

namespace Database\Seeders;

use App\Models\Opportunity;
use Illuminate\Database\Seeder;

class OpportunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $opps = [];
        $i    = 1;
        while ($i <= 300) {
            $opps[] = Opportunity::factory()
                ->make([
                    'customer_id' => rand(1, 70),
                ])
            ->toArray();

            $i++;
        }

        Opportunity::query()->insert($opps);

        //        Opportunity::factory(300)
        //            ->create([
        //                                'customer_id' => rand(1,70)
        ////                'customer_id' => \App\Models\Customer::query()->inRandomOrder()->first()->id,
        //            ]);

    }
}
