<?php
declare(strict_types=1);

namespace MageSuite\SuccessPageOrderDetails\ViewModel\Checkout\Success;

class Order implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Directory\Model\CountryFactory
     */
    protected $countryFactory;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\Catalog\Helper\Image $imageHelper
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->countryFactory = $countryFactory;
        $this->imageHelper = $imageHelper;
    }

    public function getOrder(): \Magento\Sales\Model\Order
    {
        return $this->checkoutSession->getLastRealOrder();
    }

    public function getItems(): array
    {
        return $this->getOrder()->getAllVisibleItems();
    }

    public function getShippingAddress(): ?\Magento\Sales\Model\Order\Address
    {
        return $this->getOrder()->getShippingAddress();
    }

    public function getBillingAddress(): ?\Magento\Sales\Model\Order\Address
    {
        return $this->getOrder()->getBillingAddress();
    }

    public function getShippingMethod(): ?string
    {
        return $this->getOrder()->getShippingDescription();
    }

    public function getPaymentMethod(): ?string
    {
        $payment = $this->getOrder()->getPayment();

        if (!$payment) {
            return null;
        }

        return $payment->getMethodInstance()->getTitle();
    }

    public function getCountryByCode(string $countryCode): string
    {
        $country = $this->countryFactory->create();
        return $country->loadByCode($countryCode)->getName();
    }

    public function getStreetFull($street): string
    {
        return is_array($street) ? implode(' ', $street) : $street;
    }

    public function getCustomerEmail()
    {
        return $this->getOrder()->getCustomerEmail();
    }

    /**
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return string|null
     */
    public function getImageUrl(\Magento\Catalog\Api\Data\ProductInterface $product): ?string
    {
        if (!$product->getImage()) {
            return null;
        }

        return $productImage = $this->imageHelper->init($product, 'thumbnail')->getUrl();
    }
}
