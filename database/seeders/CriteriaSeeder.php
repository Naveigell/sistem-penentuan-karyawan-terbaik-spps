<?php

namespace Database\Seeders;

use App\Enums\CriteriaType;
use App\Models\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterias = [
            'review', 'absence', 'performance', 'communication', 'teamwork',
        ];

        foreach ($criterias as $name) {
            $type   = CriteriaType::random();
            $weight = rand(1, 20);

            $criteria = Criteria::create(compact('name', 'type', 'weight'));

            if ($type->isOption()) {
                foreach (range(1, 5) as $item) {
                    $label = "Option $item for $name";
                    $value = $item;

                    $criteria->options()->create(array_merge([
                        'name' => Str::snake($label),
                    ], compact('label', 'value')));
                }
            }
        }
    }
}
