<?php

namespace SamedayCourier\Shipping\Block\Adminhtml\Order;

use \Magento\Backend\Block\Template\Context;
use \Magento\Backend\Block\Template;
use SamedayCourier\Shipping\Exception\NotAnOrderMatchedException;
use SamedayCourier\Shipping\Helper\StoredDataHelper;

class SamedayModal extends Template
{
    private $storedDataHelper;

    /**
     * @param Context $context
     * @param StoredDataHelper $storedDataHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        StoredDataHelper $storedDataHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->storedDataHelper = $storedDataHelper;
    }

    public function getPickupPoints()
    {
        return $this->storedDataHelper->getPickupPoints()->getItems();
    }

    public function getServices()
    {
        return $this->storedDataHelper->getServices()->getItems();
    }

    public function getOrderDetails()
    {
        if (!$this->hasData('order')) {
            throw new NotAnOrderMatchedException();
        }

        $order = $this->getOrder();

        return [
            'weight' => $order->getWight(),
            'repayment' => $order->getGrandTotal()
        ];
    }

    public function getRouteAddAwb()
    {
        if(!$this->hasData('order')){
            throw new NotAnOrderMatchedException();
        }

        $orderId = $this->getOrder()->getId();

        return $this->getUrl('samedaycourier_shipping/order/addawb', [
            'order_id' => $orderId
        ]);
    }

    public function getRouteAddParcel()
    {
        if(!$this->hasData('order')){
            throw new NotAnOrderMatchedException();
        }

        $orderId = $this->getOrder()->getId();
        return $this->getUrl('samedaycourier_shipping/order/addparcel', [
            'order_id' => $orderId
        ]);
    }
}
