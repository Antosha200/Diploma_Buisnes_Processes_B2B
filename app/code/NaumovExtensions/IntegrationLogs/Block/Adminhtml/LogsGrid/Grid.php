<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Block\Adminhtml\LogsGrid;

use Exception;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use NaumovExtensions\IntegrationLogs\Model\ResourceModel\CollectionFactory;
use NaumovExtensions\IntegrationLogs\Model\FilterOptions;

/**
 * Class Grid
 * @package NaumovExtensions/IntegrationLogs/Block/Adminhtml/LogsGrid
 */
class Grid extends Extended
{
    /**
     * @var FilterOptions
     */
    private FilterOptions $filterOptions;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @param Context $context
     * @param Data $backendHelper
     * @param CollectionFactory $collectionFactory
     * @param FilterOptions $filterOptions
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $collectionFactory,
        FilterOptions $filterOptions,
        array $data = []
    ) {
        $this->filterOptions = $filterOptions;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     * @throws FileSystemException
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');

    }

    /**
     * @return $this
     */
    protected function _prepareCollection(): Grid
    {
        $collection = $this->collectionFactory->create();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    /**
     * @return $this
     * @throws LocalizedException
     * @throws Exception
     */
    protected function _prepareColumns(): Grid
    {
        $this->addColumn(
            'id',
            [
                'header' => __('Id'),
                'index' => 'id',
            ]
        );
        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
            ]
        );
        $this->addColumn(
            'object',
            [
                'header' => __('Object'),
                'index' => 'object',
                'type' => 'options',
                'options' => array_combine($this->filterOptions->getObjectOptions(),
                    $this->filterOptions->getObjectOptions())
            ]
        );
        $this->addColumn(
            'event',
            [
                'header' => __(' Event'),
                'index' => 'event',
                'type' => 'options',
                'options' => array_combine($this->filterOptions->getEventOptions(),
                    $this->filterOptions->getEventOptions())
            ]
        );
        $this->addColumn(
            'message',
            [
                'header' => __('Message'),
                'index' => 'message',
            ]
        );
        $this->addColumn(
            'created_at',
            [
                'header' => __('Created at'),
                'index' => 'created_at',
            ]
        );
        $this->addColumn(
            'view_action',
            [
                'header' => __('View'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('View'),
                        'url' => ['base' => 'naumovextensions_integrationlogs/log/view'],
                        'field' => 'id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'view_action',
                'is_system' => true,
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl(): string
    {
        return $this->getUrl('naumovextensions_integrationlogs/index/index', ['_current' => true]);
    }
}
