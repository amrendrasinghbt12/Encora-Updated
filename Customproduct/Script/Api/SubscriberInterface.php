<?php
/**
 * Customproduct Script Module
 *
 * @category  Customproduct
 * @package   Customproduct_Script
 */
namespace Customproduct\Script\Api;

use Customproduct\Script\Api\MessageInterface;

/**
 * Interface SubscriberInterface
 * @api
 */
interface SubscriberInterface
{
    /**
     * @return void
     */
    public function processMessage(MessageInterface $message);
}
