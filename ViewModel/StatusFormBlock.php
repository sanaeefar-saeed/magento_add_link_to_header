<?php

declare(strict_types=1);
namespace Sana\CustomerAccount\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class StatusFormBlock
 * @package Sana\CustomerAccount\ViewModel
 */
class StatusFormBlock implements ArgumentInterface
{
    /**
     * @return string
     */
    public function getFormAction(): string
    {
        return '/status/index/save';
    }
}
