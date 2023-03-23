<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

namespace NaumovExtensions\IntegrationLogs\Usage;

use NaumovExtensions\IntegrationLogs\Helper\LoggerFactory;

/**
 * Class Grid
 * @package NaumovExtensions/IntegrationLogs/Usage
 */
class UsageExample
{
    /**
     * @var LoggerFactory
     */
    protected LoggerFactory $loggerFactory;

    /**
     * @param LoggerFactory $loggerFactory
     */
    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->loggerFactory = $loggerFactory;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        //$this->usageExample->execute(); - How to use this example and trigger this method

        $logger = $this->loggerFactory->create(); //creating logger instance

        $logger->addMessage('Any message.');
        $logger->setStatus(0);
        $logger->setObject('default Object');
        $logger->setEvent('default Event');
        $logger->setLogData('Some data, that have maximum length - 16,777,215 (224−1) bytes = 16 MiB');
        $logger->addMessage('Can be several using addMessage() method in one object.');

        $logger->save();
    }
}
