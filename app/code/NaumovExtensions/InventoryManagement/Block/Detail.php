<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_InventoryManagement
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\InventoryManagement\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use NaumovExtensions\InventoryManagement\Model\ResourceModel\InventoryCollectionFactory;

/**
 * class Detail
 * @package NaumovExtensions\InventoryManagement\Block
 */
class Detail extends Template
{
    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->setTemplate('NaumovExtensions_InventoryManagement::detail/detail.phtml');
    }
}
