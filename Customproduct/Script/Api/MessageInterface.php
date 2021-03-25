<?php
/**
 * Customproduct Script Module
 *
 * @category  Customproduct
 * @package   Customproduct_Script
 */
namespace Customproduct\Script\Api;

/**
 * Interface MessageInterface
 * @api
 */
interface MessageInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function setMessage($message);

    /**
     * @return string
     */
    public function getMessage();
}
