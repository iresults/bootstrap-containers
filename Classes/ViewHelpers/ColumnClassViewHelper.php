<?php

namespace Iresults\BootstrapContainers\ViewHelpers;

use Closure;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ColumnClassViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('column', 'integer', 'Column number', true);
        $this->registerArgument('configuration', 'array', 'Configuration of column classes per screen');
        $this->registerArgument('default', 'string', 'Default class if the configuration is empty');
    }

    public static function renderStatic(
        array $arguments,
        Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext,
    ): string {
        $column = (int) $arguments['column'];
        $configuration = $arguments['configuration'] ?? $renderChildrenClosure();

        // If the configuration is NULL (e.g. the EXT:container content element
        // was created without opening the content record) the default class
        // will be used
        if (empty($configuration)) {
            return $arguments['default'] ?? '';
        }

        return htmlspecialchars(implode(' ', array_filter([
            $configuration["mdCol{$column}"] ?? '',
            $configuration["smCol{$column}"] ?? '',
            $configuration["xsCol{$column}"] ?? '',
            $configuration["lgCol{$column}"] ?? '',
            $configuration["xlCol{$column}"] ?? '', // Not available in the backend yet
            $configuration["xxlCol{$column}"] ?? '', // Not available in the backend yet
            $configuration["col2{$column}class"] ?? '',
            $configuration["col3{$column}class"] ?? '',
            $configuration["col4{$column}class"] ?? '',
        ])));
    }
}
