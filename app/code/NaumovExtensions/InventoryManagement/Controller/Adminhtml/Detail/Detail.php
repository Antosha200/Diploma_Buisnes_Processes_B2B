<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_InventoryManagement
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\InventoryManagement\Controller\Adminhtml\Detail;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use NaumovExtensions\InventoryManagement\Model\ResourceModel\InventoryCollectionFactory;

/**
 * class Detail
 * @package NaumovExtensions\InventoryManagement\Controller\Adminhtml\Detail
 */
class Detail extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var InventoryCollectionFactory
     */
    protected InventoryCollectionFactory $InventoryCollectionFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param InventoryCollectionFactory $InventoryCollectionFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        InventoryCollectionFactory $InventoryCollectionFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->InventoryCollectionFactory = $InventoryCollectionFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $details = $this->InventoryCollectionFactory->create()->addFieldToFilter('id',
            $id)->getFirstItem();

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('NaumovExtensions_InventoryManagement::detail');
        $resultPage->getConfig()->getTitle()->prepend(__('Detailed report'));

        $resultPage->getLayout()
            ->getBlock('naumovextensions.inventorymanagement.detail.detail')
            ->setData('details', $details);

        return $resultPage;
    }
}
