<?php

namespace App\Utils\DecisionSupportSystem\Base;

use App\Utils\DecisionSupportSystem\Enums\CriteriaType;

abstract class DecisionSupportSystem
{
    protected array $criteria;

    protected array $alternatives;

    protected int $precision = 5;

    protected array $normalization;

    /**
     * Constructs a DecisionSupportSystem object.
     *
     * @param array $alternatives List of all the alternatives.
     * @param array $criteria List of all the criteria.
     * @throws \Exception
     */
    public function __construct(array $alternatives, array $criteria)
    {
        $this->criteria     = $criteria;
        $this->alternatives = $alternatives;

        $this->validateData();
    }

    /**
     * Validates the data given for the DecisionSupportSystem.
     *
     * This method checks that all the criteria given have a weight.
     *
     * @throws \Exception
     */
    private function validateData()
    {
        // criteria must have
        // 1. id
        // 2. name
        // 3. weight
        // 4. type (must be cost or benefit)
        foreach ($this->criteria as $criterion) {
            if (!array_key_exists('id', $criterion)) {
                throw new \Exception('Criteria must have an id');
            }

            if (!array_key_exists('name', $criterion)) {
                throw new \Exception('Criteria must have a name');
            }

            if (!array_key_exists('weight', $criterion)) {
                throw new \Exception('Criteria must have a weight');
            }

            if (!array_key_exists('type', $criterion)) {
                throw new \Exception('Criteria must have a type such like cost or benefit');
            }

            if (!in_array($criterion['type'], [CriteriaType::COST->value, CriteriaType::BENEFIT->value])) {
                throw new \Exception('Criteria type must be cost or benefit');
            }
        }

        $criteriaLength = count($this->criteria);

        // alternatives must have
        // 1. id
        // 2. name
        // 3. values (must have the same length as criteria)
        foreach ($this->alternatives as $alternative) {
            if (!array_key_exists('id', $alternative)) {
                throw new \Exception('Alternative must have an id');
            }

            if (!array_key_exists('name', $alternative)) {
                throw new \Exception('Alternative must have a name');
            }

            if (!array_key_exists('values', $alternative)) {
                throw new \Exception('Alternative must have values');
            }

            if (count($alternative['values']) != $criteriaLength) {
                throw new \Exception('Alternative must have values for all criteria');
            }
        }
    }

    /**
     * Set the precision for this DSS.
     *
     * This method can be used to set the precision for all calculations in
     * this DSS. The default precision is 4.
     *
     * @param int $precision The precision to use.
     * @return void
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }

    /**
     * Returns the normalization of the DSS.
     *
     * @return array The normalization of the DSS.
     */
    public function getNormalization(): array
    {
        return $this->normalization;
    }

    /**
     * Calculate the ranks of all alternatives.
     *
     * This method should be overridden in all subclasses. It should use the
     * criteria and alternatives given in the constructor to calculate the
     * ranks of all alternatives.
     */
    abstract public function calculate(): void;

    /**
     * Returns the results of the decision support system, which is an associative array
     * with the alternative as key and the rank as value.
     *
     * @return array Associative array with the alternative as key and the rank as value.
     */
    abstract public function results(): array;
}
