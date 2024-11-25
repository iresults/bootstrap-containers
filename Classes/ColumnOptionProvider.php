<?php

declare(strict_types=1);

namespace Iresults\BootstrapContainers;

use InvalidArgumentException;

/**
 * @phpstan-type ColumnOption array{0:string, 1:string}
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
        $defaultOption = ['50% (col-md-6)', 'col-md-6'];

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
        $defaultOption = ['33% (col-md-4)', 'col-md-4'];

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
        $defaultOption = ['25% (col-md-3)', 'col-md-3'];

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
                        [self::LOCALIZATION_FILE . 'grid.label.notset', ' '],
                    ];

                    return $this->removeDuplicateOptions(array_merge($optionListStart, $this->buildNameClassPairs('md')));
                }

                return $this->buildNameClassPairs('md');
            case 'smCol':
                return $this->buildNameClassPairs('sm');

            case 'xsCol':
                return $this->buildNameClassPairs('xs');

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
            [self::LOCALIZATION_FILE . 'grid.label.notset', ' '],
            ["25% (col-$screen-3)", "col-$screen-3"],
            ["33% (col-$screen-4)", "col-$screen-4"],
            ["50% (col-$screen-6)", "col-$screen-6"],
            ["66% (col-$screen-8)", "col-$screen-8"],
            ["75% (col-$screen-9)", "col-$screen-9"],
            [self::LOCALIZATION_FILE . 'grid.label.moreWidth', '--div--'],
            ["8.3% (col-$screen-1)", "col-$screen-1"],
            ["16.7%  (col-$screen-2)", "col-$screen-2"],
            ["41.7% (col-$screen-5)", "col-$screen-5"],
            ["58.3% (col-$screen-7)", "col-$screen-7"],
            ["83.3% (col-$screen-10)", "col-$screen-10"],
            ["91.7% (col-$screen-11)", "col-$screen-11"],
            ["100% (col-$screen-12)", "col-$screen-12"],
            [self::LOCALIZATION_FILE . 'grid.label.moreOptions', '--div--'],
            [self::LOCALIZATION_FILE . 'grid.label.hidden', "hidden-$screen"],
            [self::LOCALIZATION_FILE . 'grid.label.visible', "visible-$screen"],
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
            $filteredOptions[$option[1]] = $option;
        }

        return $filteredOptions;
    }
}
