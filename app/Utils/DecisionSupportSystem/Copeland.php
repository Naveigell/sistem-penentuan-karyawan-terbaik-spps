<?php

namespace App\Utils\DecisionSupportSystem;

use App\Utils\DecisionSupportSystem\Base\DecisionSupportSystem;

class Copeland extends DecisionSupportSystem
{
    /**
     * Indicates the value when alternative weight is win
     *
     * @var int
     */
    private int $winnerValue = 1;

    /**
     * Indicates the value when alternative weight is lost
     *
     * @var int
     */
    private int $loserValue = -1;

    /**
     * Calculate the ranks of all alternatives.
     *
     * This method should be overridden in all subclasses. It should use the
     * criteria and alternatives given in the constructor to calculate the
     * ranks of all alternatives.
     */
    public function calculate(): void
    {
        $scores      = [];
        $criteriaIds = array_column($this->criteria, 'id'); // take all the criteria ids

        // looping criteria id
        foreach ($criteriaIds as $index => $criteriaId) {
            // separate the alternative values by its criteria
            // the first value join all the first value by criteria id
            foreach ($this->alternatives as $alternative) {
                $scores[$criteriaId][$alternative['id']] = $alternative['values'][$index];
            }

            // and then we sort by the value, why do this?
            // because we want to compare every key for easy comparison
            // example
            // [
            //      4 => 122
            //      1 => 100
            //      3 => 80
            //      2 => 50
            // ]
            // now we can compare the position only with its key
            arsort($scores[$criteriaId]);
        }

        // fill the default ranks with 0
        $ranks = array_combine(array_column($this->alternatives, 'id'), array_fill(0, count($this->alternatives), 0));

        $alternatives = $this->alternatives;

        foreach ($alternatives as $firstAlternative) {

            // slice the second alternatives, if we have 4 alternative
            // we're looping to compare by its key, example :
            // we compare 1 vs 2
            // and then 1 vs 3
            // last with 1 vs 4
            // and next 2 vs 3
            // last with 2 vs 4, and so on
            $alternatives = array_slice($alternatives, 1);

            foreach ($alternatives as $secondAlternative) {

                // initiate first alternative total weight and second alternative total weight
                $firstAlternativeTotalWeight =
                $secondAlternativeTotalWeight = 0;

                foreach ($scores as $criteriaId => $score) {
                    $criteria = array_search($criteriaId, array_column($this->criteria, 'id'));
                    $criteria = $this->criteria[$criteria];

                    // search where the index of first alternative id and second alternative id, and we compare with
                    // its position like the explanation before
                    $firstAlternativeIndex  = array_search($firstAlternative['id'], array_keys($score));
                    $secondAlternativeIndex = array_search($secondAlternative['id'], array_keys($score));

                    // if the position of first alternative is above of second alternative
                    // add the weight into total weight
                    if ($firstAlternativeIndex < $secondAlternativeIndex) {
                        $firstAlternativeTotalWeight += $criteria['weight'];
                    } else { // same with explanation above but for the second alternative
                        $secondAlternativeTotalWeight += $criteria['weight'];
                    }
                }

                // now we compare the first alternative total weight with second alternative total weight
                // who won the total weight will be added +1 to the ranks value
                // and who lost the total weight will be added -1 to the ranks value
                if ($firstAlternativeTotalWeight > $secondAlternativeTotalWeight) {
                    $this->updateRankValue($ranks, $firstAlternative['id'], $secondAlternative['id']);
                } elseif ($firstAlternativeTotalWeight < $secondAlternativeTotalWeight) {
                    $this->updateRankValue($ranks, $secondAlternative['id'], $firstAlternative['id']);
                }
            }
        }

        // now we sort the ranks by its value again
        arsort($ranks);

        // looping ranks by its key
        foreach (array_keys($ranks) as $rank => $alternativeId) {

            // search where the alternative id index in the alternatives array
            $firstAlternativeIndex = array_search($alternativeId, array_column($this->alternatives, 'id'));

            // just make sure if the index not found, we continue looping
            // this almost impossible the alternative index not found since the data not changed
            // outside this method
            if ($firstAlternativeIndex < 0) {
                continue;
            }

            // put the total value into the alternative
            // and put the rank into the alternative
            $this->alternatives[$firstAlternativeIndex]['total'] = $ranks[$alternativeId];
            $this->alternatives[$firstAlternativeIndex]['rank']  = $rank + 1;
        }
    }

    /**
     * Returns the results of the decision support system, which is an associative array
     * with the alternative as key and the rank as value.
     *
     * @return array Associative array with the alternative as key and the rank as value.
     */
    public function results(): array
    {
        $results = $this->alternatives;

        usort($results, function ($a, $b) {
            return $a["rank"] <=> $b["rank"]; // sorting the result by its rank
        });

        return $results;
    }

    /**
     * Updates the rank value for the winner and loser alternatives.
     *
     * This function updates the rank value for the winner and loser alternatives
     * by adding the winner value to the winner alternative rank and the loser
     * value to the loser alternative rank.
     *
     * @param array $ranks The associative array with the alternative as key and
     *                    the rank as value.
     * @param int $winnerAlternativeId The id of the winner alternative.
     * @param int $loserAlternativeId The id of the loser alternative.
     */
    private function updateRankValue(array &$ranks, int $winnerAlternativeId, int $loserAlternativeId)
    {
        $ranks[$winnerAlternativeId] += $this->winnerValue;
        $ranks[$loserAlternativeId]  += $this->loserValue;
    }

    /**
     * Sets the winner and loser values for the ranking calculation.
     *
     * This method sets the winner and loser values that are used in the ranking
     * calculation. The winner value is added to the winner alternative rank and
     * the loser value is added to the loser alternative rank.
     *
     * @param int $winner The winner value.
     * @param int $losser The loser value.
     */
    public function setWinnerLosserValue(int $winner, int $losser)
    {
        $this->winnerValue = $winner;
        $this->loserValue  = $losser;
    }
}
