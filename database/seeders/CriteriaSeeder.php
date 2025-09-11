<?php

namespace Database\Seeders;

use App\Enums\CriteriaValueType;
use App\Models\Criteria;
use App\Utils\DecisionSupportSystem\Enums\CriteriaType;
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
            'Review' => [
                'type'       => CriteriaType::BENEFIT,
                'weight'     => 20,
                'value_type' => CriteriaValueType::NOMINAL,
            ],
            'Sick Absence' => [
                'type'       => CriteriaType::COST,
                'weight'     => 10,
                'value_type' => CriteriaValueType::NOMINAL,
            ],
            'Leave Absence' => [
                'type'       => CriteriaType::COST,
                'weight'     => 10,
                'value_type' => CriteriaValueType::NOMINAL,
            ],
            'Work Hour' => [
                'type'       => CriteriaType::BENEFIT,
                'weight'     => 40,
                'value_type' => CriteriaValueType::NOMINAL,
            ],
            'Late' => [
                'type'       => CriteriaType::COST,
                'weight'     => 10,
                'value_type' => CriteriaValueType::NOMINAL,
            ],
            'Sales Target' => [
                'type'       => CriteriaType::BENEFIT,
                'weight'     => 10,
                'value_type' => CriteriaValueType::NOMINAL,
            ]
        ];

        foreach ($criterias as $name => $value) {
            $valueType    = $value['value_type'];
            $type         = $value['type']->value;
            $weight       = $value['weight'];

            $criteria = Criteria::create(array_merge(compact('name', 'type', 'weight'), [
                'value_type' => $valueType->value,
            ]));

            if ($valueType->isOption()) {
                foreach (range(1, 5) as $item) {
                    $label = "Option $item for $name";
                    $value = $item;

                    $criteria->options()->create(array_merge([
                        'name' => Str::snake($label),
                    ], compact('label', 'value')));
                }
            } elseif ($valueType->isRange()) {
                $min = rand(1, 100);
                $max = rand($min + 1, $min + 1 + rand(1, 100));

                $criteria->range()->create(compact('min', 'max'));
            }
        }
    }
}
