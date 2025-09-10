<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users    = User::whereEmployee()->get();
        $criteria = Criteria::with('options', 'range')->get();

        foreach ($users as $user) {
            foreach ($criteria as $criterion) {
                try {
                    if ($criterion->value_type->isOption()) {
                        $option = $criterion->options->random();

                        $user->criteriaOptions()->syncWithoutDetaching([
                            $criterion->id => [
                                'criteria_option_id' => $option->id,
                                'employee_id' => $user->userable->id,
                            ]
                        ]);
                    } else if ($criterion->value_type->isRange()) {
                        $range = $criterion->range;

                        $user->criteriaValues()->syncWithoutDetaching([
                            $criterion->id => [
                                'value' => rand($range->min, $range->max),
                                'employee_id' => $user->userable->id,
                            ]
                        ]);
                    } else {
                        $user->criteriaValues()->syncWithoutDetaching([
                            $criterion->id => [
                                'value' => rand(10, 10000),
                                'employee_id' => $user->userable->id,
                            ]
                        ]);
                    }
                } catch (\Exception $exception) {
                    dd($exception->getMessage());
                }
            }
        }
    }
}
