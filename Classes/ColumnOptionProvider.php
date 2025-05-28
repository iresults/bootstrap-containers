<?php

declare(strict_types=1);

namespace Iresults\BootstrapContainers;

use InvalidArgumentException;

/**
 * @phpstan-type ColumnOption array{label:string, value:string}
 * @phpstan-type Fields   "xsCol1"|"xsCol2"|"xsCol3"|"xsCol4"|"smCol1"|"smCol2"|"smCol3"|"smCol4"|"mdCol1"|"mdCol2"|"mdCol3"|"mdCol4"|"lgCol1"|"lgCol2"|"lgCol3"|"lgCol4"
 * @phpstan-type FlexParentDatabaseRow array{pi_flexform: array{data: string[]}}
 * @phpstan-type FlexFormConfig array{field: Fields, flexParentDatabaseRow: FlexParentDatabaseRow, items: ColumnOption[]}
 */
class ColumnOptionProvider
{
    private const LOCALIZATION_FILE = 'LLL:EXT:bootstrap_containers/Resources/Private/Language/locallang.xlf:';

    /**
     * @param FlexFormConfig $config
     *
     * @return FlexFormConfig
     */
    public function getTwoColumnOptions(array $config): array
    {
        // default for 2 columns
        $defaultOption = ['label' => '50% (col-md-6)', 'value' => 'col-md-6'];

        return $this->addColumnOptions($config, $defaultOption);
    }

    /**
     * @param FlexFormConfig $config
     *
     * @return FlexFormConfig
     */
    public function getThreeColumnOptions(array $config): array
    {
        // default for 3 columns
        $defaultOption = ['label' => '33% (col-md-4)', 'value' => 'col-md-4'];

        return $this->addColumnOptions($config, $defaultOption);
    }

    /**
     * @param FlexFormConfig $config
     *
     * @return FlexFormConfig
     */
    public function getFourColumnOptions(array $config): array
    {
        // default for 4 columns
        $defaultOption = ['label' => '25% (col-md-3)', 'value' => 'col-md-3'];

        return $this->addColumnOptions($config, $defaultOption);
    }

    /**
     * @param FlexFormConfig $config
     * @param ColumnOption   $defaultOption
     *
     * @return FlexFormConfig
     */
    public function addColumnOptions(array $config, array $defaultOption): array
    {
        $config['items'] = array_merge($config['items'], $this->buildColumnOptions($config, $defaultOption));

        return $config;
    }

    /**
     * @param FlexFormConfig $config
     * @param ColumnOption   $defaultOption
     *
     * @return ColumnOption[]
     */
    public function buildColumnOptions(array $config, array $defaultOption): array
    {
        $fieldName = $config['field'];
        $columnType = substr($fieldName, 0, -1);

        switch ($columnType) {
            case 'mdCol':
                // new grids: flexform not yet saved => add default setting as first option
                if (!$this->hasFlexFormData($config)) {
                    $optionListStart = [
                        $defaultOption,
                        ['label' => self::LOCALIZATION_FILE . 'grid.label.notset', 'value' => ' '],
                    ];

                    return $this->removeDuplicateOptions(array_merge($optionListStart, $this->buildNameClassPairs('md')));
                }

                return $this->buildNameClassPairs('md');

            case 'xsCol':
                return $this->buildNameClassPairs('xs');

            case 'smCol':
                return $this->buildNameClassPairs('sm');

            case 'lgCol':
                return $this->buildNameClassPairs('lg');

            default: throw new InvalidArgumentException('Invalid column type "' . $columnType . '"', 1417778126);
        }
    }

    /**
     * @return ColumnOption[]
     */
    private function buildNameClassPairs(string $screen): array
    {
        return [
            ['label' => self::LOCALIZATION_FILE . 'grid.label.notset', 'value' => ' '],
            ['label' => "25% (col-$screen-3)", 'value' => "col-$screen-3"],
            ['label' => "33% (col-$screen-4)", 'value' => "col-$screen-4"],
            ['label' => "50% (col-$screen-6)", 'value' => "col-$screen-6"],
            ['label' => "66% (col-$screen-8)", 'value' => "col-$screen-8"],
            ['label' => "75% (col-$screen-9)", 'value' => "col-$screen-9"],
            ['label' => self::LOCALIZATION_FILE . 'grid.label.moreWidth', 'value' => '--div--'],
            ['label' => "8.3% (col-$screen-1)", 'value' => "col-$screen-1"],
            ['label' => "16.7%  (col-$screen-2)", 'value' => "col-$screen-2"],
            ['label' => "41.7% (col-$screen-5)", 'value' => "col-$screen-5"],
            ['label' => "58.3% (col-$screen-7)", 'value' => "col-$screen-7"],
            ['label' => "83.3% (col-$screen-10)", 'value' => "col-$screen-10"],
            ['label' => "91.7% (col-$screen-11)", 'value' => "col-$screen-11"],
            ['label' => "100% (col-$screen-12)", 'value' => "col-$screen-12"],
            ['label' => self::LOCALIZATION_FILE . 'grid.label.moreOptions', 'value' => '--div--'],
            ['label' => self::LOCALIZATION_FILE . 'grid.label.hidden', 'value' => "hidden-$screen"],
            ['label' => self::LOCALIZATION_FILE . 'grid.label.visible', 'value' => "visible-$screen"],
        ];
    }

    /**
     * @param FlexFormConfig $config
     */
    private function hasFlexFormData(array $config): bool
    {
        return !(isset($config['flexParentDatabaseRow']['pi_flexform']['data'])
            && 0 === count($config['flexParentDatabaseRow']['pi_flexform']['data']));
    }

    /**
     * @param ColumnOption[] $optionList
     *
     * @return ColumnOption[]
     */
    private function removeDuplicateOptions(array $optionList): array
    {
        $filteredOptions = [];
        foreach ($optionList as $option) {
            $filteredOptions[$option['value']] = $option;
        }

        return $filteredOptions;
    }
}
