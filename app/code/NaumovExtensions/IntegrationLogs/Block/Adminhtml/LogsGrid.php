<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Block\Adminhtml;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\Block\Widget\Container;

/**
 * Class LogsGrid
 * @package NaumovExtensions/IntegrationLogs/Block/Adminhtml
 */
class LogsGrid extends Container
{
    /**
     * @var string
     */
    protected $_template = 'grid.phtml';

    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Prepare button and grid
     *
     * @return LogsGrid
     * @throws LocalizedException
     */
    protected function _prepareLayout(): LogsGrid
    {
        $this->setChild(
            'grid',
            $this->getLayout()->createBlock('NaumovExtensions\IntegrationLogs\Block\Adminhtml\LogsGrid\Grid',
                'admin.logsgrid.grid')
        );

        return parent::_prepareLayout();
    }

    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml(): string
    {
        return $this->getChildHtml('grid');
    }
}
