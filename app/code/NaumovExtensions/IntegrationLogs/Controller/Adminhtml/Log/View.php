<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Controller\Adminhtml\Log;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use NaumovExtensions\IntegrationLogs\Model\ResourceModel\CollectionFactory;

/**
 * Class View
 * @package NaumovExtensions\IntegrationLogs\Controller\Adminhtml\Log
 */
class View extends Action
{
    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * View constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CollectionFactory $collectionFactory,
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        {
            $logId = $this->getRequest()->getParam('id');

            try {
                $log = $this->collectionFactory->create()->addFieldToFilter('id', $logId)->getFirstItem();

                if ( ! $log->getId()) {
                    throw new NoSuchEntityException(__('Log item does not exist.'));
                }
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $this->_redirect('*/*/');
            }

            $resultPage = $this->resultPageFactory->create();
            $resultPage->setActiveMenu('NaumovExtensions_IntegrationLogs::logsgrid');
            $resultPage->getConfig()->getTitle()->prepend(__('Integration Log Item'));

            $resultPage->getLayout()
                ->getBlock('naumovextensions.integrationlogs.log.view')
                ->setData('log', $log);

            return $resultPage;
        }
    }
}
