<?php

declare(strict_types=1);

namespace Iresults\BootstrapContainers\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class AppearanceClassViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('data', 'array', 'Content elements `data` array', true);
    }

    public function render(): string
    {
        $data = $this->arguments['data'];

        $classes = ['frame'];
        $value = trim($data['frame_class'] ?? '');
        if ('' !== $value) {
            $classes[] = 'frame-' . $value;
        }
        $value = trim((string) ($data['layout'] ?? ''));
        if ('' !== $value) {
            $classes[] = 'frame-layout-' . $value;
        }
        $value = trim($data['space_before_class'] ?? '');
        if ('' !== $value) {
            $classes[] = 'frame-space-before-' . $value;
        }
        $value = trim($data['space_after_class'] ?? '');
        if ('' !== $value) {
            $classes[] = 'frame-space-after-' . $value;
        }

        return htmlspecialchars(implode(' ', $classes));
    }
}
