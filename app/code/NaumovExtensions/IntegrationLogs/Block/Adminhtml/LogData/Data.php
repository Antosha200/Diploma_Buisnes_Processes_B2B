<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Block\Adminhtml\LogData;

use Magento\Backend\Block\Template;

/**
 * Class View
 * @package NaumovExtensions\IntegrationLogs\Block\Adminhtml\Log
 */
class Data extends Template
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
        $this->setTemplate('NaumovExtensions_IntegrationLogs::log/view.phtml');
    }
}
