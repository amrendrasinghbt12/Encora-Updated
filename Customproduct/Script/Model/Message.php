<?php
/**
 *  Customproduct Script Module
 *
 * @category  Customproduct
 * @package   Customproduct_Script
 */
namespace Customproduct\Script\Model;

use Customproduct\Script\Api\MessageInterface;

/**
 * Class Message
 * @package Customproduct\Script\Model
 */
class Message
{
      /**
     * @var string
     */
    protected $message;

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        return $this->message = $message;
    }
}