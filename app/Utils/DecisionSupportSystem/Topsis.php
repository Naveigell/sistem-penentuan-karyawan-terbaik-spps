<?php

namespace App\Utils\DecisionSupportSystem;

use App\Utils\DecisionSupportSystem\Base\DecisionSupportSystem;
use App\Utils\DecisionSupportSystem\Enums\CriteriaType;

class Topsis extends DecisionSupportSystem
{
    private array $averages;

    private array $weightedNormalizations;

    private array $idealSolutions = [
        "positive" => [],
        "negative" => [],
    ];

    private array $idealSolutionResults = [
        "positive" => 0,
        "negative" => 0,
    ];

    /**
     * Calculate the ranks of all alternatives.
     *
     * This method should be overridden in all subclasses. It should use the
     * criteria and alternatives given in the constructor to calculate the
     * ranks of all alternatives.
     */
    public function calculate(): void
    {
        $averages = array_fill(0, count($this->criteria), 0);

        // loop through each criterion and
        // each alternative to calculate the average
        foreach ($this->criteria as $index => $criterion) {
            foreach ($this->alternatives as $alternative) {
                // sum the Aᵢ² values for each criterion
                $averages[$index] += round(pow($alternative['values'][$index], 2), $this->precision);
            }

            // and then calculate the square root of the sum
            $averages[$index] = round(sqrt($averages[$index]), $this->precision);
        }

        // store the averages to easy access
        $this->averages = $averages;

        $normalizations = [];

        // calculate the normalizations by looping through each alternative and each criterion
        // than calculate with Aᵢⱼ / A̅ⱼ formula.
        foreach ($this->alternatives as $alternative) {
            foreach ($alternative['values'] as $index => $value) {
                $normalizations[$alternative['id']][$index] = round($value / $averages[$index], $this->precision);
            }
        }

        // store the normalizations to easy access
        $this->normalization = $normalizations;

        // create a new variable to store the weighted normalizations
        $normalizationsWeighted = [];

        // looping through each alternative and each criterion to calculate the weighted normalizations
        // the formula is Aᵢⱼ * wⱼ
        foreach ($normalizations as $normalizationIndex => $normalization) {
            foreach ($this->criteria as $criterionIndex => $criterion) {
                $normalizationsWeighted[$normalizationIndex][$criterionIndex] = round($normalization[$criterionIndex] * $criterion['weight'], $this->precision);
            }
        }

        // store the weighted normalizations to easy access
        $this->weightedNormalizations = $normalizationsWeighted;

        // create variable to store solutions
        $idealPositiveSolutions =
        $idealNegativeSolutions = [];

        // looping through each criterion to calculate the ideal solutions
        foreach ($this->criteria as $index => $criterion) {
            $type = CriteriaType::tryFrom($criterion['type']);

            // if the type is cost
            // then the ideal positive solution is the minimum value,
            // and the ideal negative solution is the maximum value
            // else
            // the ideal positive solution is the maximum value,
            // and the ideal negative solution is the minimum value
            if ($type->isCost()) {
                $idealPositiveSolutions[] = min(array_column($normalizationsWeighted, $index));
                $idealNegativeSolutions[] = max(array_column($normalizationsWeighted, $index));
            } else {
                $idealPositiveSolutions[] = max(array_column($normalizationsWeighted, $index));
                $idealNegativeSolutions[] = min(array_column($normalizationsWeighted, $index));
            }
        }

        $this->idealSolutions['positive'] = $idealPositiveSolutions;
        $this->idealSolutions['negative'] = $idealNegativeSolutions;

        // create variable to store the positive and negative ideals
        $alternativePositiveIdeals =
        $alternativeNegativeIdeals = array_fill(0, count($this->criteria), 0);

        // remove array keys from $normalizationsWeighted
        // and loop through each alternative and each criterion to calculate the positive and negative ideals
        foreach (array_values($normalizationsWeighted) as $normalizationIndex => $normalization) {
            foreach ($normalization as $valueIndex => $value) {
                // find the distance between the value and the ideal solutions
                // then square the distance, the formula is (Aᵢⱼ - A̅⁺ⱼ)²
                $alternativePositiveIdeals[$normalizationIndex] += pow($value - $idealPositiveSolutions[$valueIndex], 2);
                $alternativeNegativeIdeals[$normalizationIndex] += pow($value - $idealNegativeSolutions[$valueIndex], 2);
            }

            // calculate the square root of the sum of the squared distances
            // the formula is sqrt((Aᵢⱼ - A̅⁺ⱼ)²)
            $alternativePositiveIdeals[$normalizationIndex] = round(sqrt($alternativePositiveIdeals[$normalizationIndex]), $this->precision);
            $alternativeNegativeIdeals[$normalizationIndex] = round(sqrt($alternativeNegativeIdeals[$normalizationIndex]), $this->precision);
        }

        $this->idealSolutionResults['positive'] = $alternativePositiveIdeals;
        $this->idealSolutionResults['negative'] = $alternativeNegativeIdeals;

        // looping the alternatives to give results into it,
        // the formula is
        foreach ($this->alternatives as $index => &$alternative) {
            $alternative["result"] = round($alternativeNegativeIdeals[$index] / ($alternativePositiveIdeals[$index] + $alternativeNegativeIdeals[$index]), $this->precision);
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
            return $b["result"] <=> $a["result"]; // sorting the result
        });

        return $results;
    }

    /**
     * Returns the ideal solutions calculated by the TOPSIS method.
     *
     * The ideal solutions are the positive and negative ideal solutions.
     * The positive ideal solution is the best possible alternative
     * and the negative ideal solution is the worst possible alternative.
     *
     * @return array The ideal solutions.
     */
    public function getIdealSolutions(): array
    {
        return $this->idealSolutions;
    }

    /**
     * Returns the results of the ideal solutions calculated by the TOPSIS method.
     *
     * The results of the ideal solutions are the positive and negative ideal solutions
     * that are calculated by the TOPSIS method.
     *
     * @return array The results of the ideal solutions.
     */
    public function getIdealSolutionResults(): array
    {
        return $this->idealSolutionResults;
    }

    /**
     * Returns the weighted normalizations calculated by the TOPSIS method.
     *
     * The weighted normalizations are the normalizations multiplied by the weights of the criteria.
     * The weighted normalizations are the values that are used to calculate the ideal solutions.
     *
     * @return array The weighted normalizations.
     */
    public function getWeightedNormalizations(): array
    {
        return $this->weightedNormalizations;
    }

    /**
     * Returns the averages calculated by the TOPSIS method.
     *
     * The averages are the averages of the squared values of the alternatives.
     * The averages are the values that are used to calculate the weighted normalizations.
     *
     * @return array The averages.
     */
    public function getAverages(): array
    {
        return $this->averages;
    }
}
