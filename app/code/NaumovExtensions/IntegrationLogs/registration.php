<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'NaumovExtensions_IntegrationLogs',
    __DIR__
);
