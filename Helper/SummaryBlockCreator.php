<?php

namespace MageSuite\SuccessPageOrderDetails\Helper;

class SummaryBlockCreator extends \Magento\Framework\App\Helper\AbstractHelper
{

    public function create(
        \MageSuite\SuccessPageOrderDetails\ViewModel\Checkout\Success\Order $viewModel,
        \Magento\Framework\View\Element\Template $block
    ): \Magento\Sales\Block\Order\Totals {
        return $block->getLayout()->createBlock(\Magento\Sales\Block\Order\Totals::class)
            ->setChild('tax', $block->getLayout()->createBlock(\Magento\Tax\Block\Sales\Order\Tax::class))
            ->setChild('weee_ord_totals', $block->getLayout()->createBlock(\Magento\Weee\Block\Sales\Order\Totals::class))
            ->setOrder($viewModel->getOrder())
            ->setTemplate('Magento_Sales::order/totals.phtml');
    }
}
