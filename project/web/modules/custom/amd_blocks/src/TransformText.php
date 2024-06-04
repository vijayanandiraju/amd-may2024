<?php

namespace Drupal\amd_blocks;

use Drupal\Core\Logger\LoggerChannelFactory;

/**
 * Class for TransformText service
 */

class TransformText{

  /**
   * Logger factory
   * 
   * @var Drupal\Core\Logger\LoggerChannelFactory
   */

   protected $logger;

  public function __construct(LoggerChannelFactory $loggerFactory)
  {
    $this->logger = $loggerFactory;
  }

  /**
   * @param $text string
   * 
   *  Return $text reversed.
   */
  public function reverse($text) {
     // Log the information in watchdog
    //\Drupal::service('logger.factory')->get('amd_blocks')->log(1, 'Reversing ' . $text);
    $this->logger->get('amd_blocks')->log(1, 'Reversing ' . $text);
    return strrev($text);
  }
  /**
   * @param $text string
   * 
   *  Return $text with all uppercase letters.
   */
  public function uppercase($text) {
    //\Drupal::service('logger.factory')->get('amd_blocks')->log(1, 'Uppercase - ing ' . $text);
    $this->logger->get('amd_blocks')->log(1, 'Uppercase - ing ' . $text);
    return strtoupper($text);
  }

  /**
   * @param $text string
   * 
   *  Return $text using title case format.
   */

  public function titleCase($text) {
    //\Drupal::service('logger.factory')->get('amd_blocks')->log(1, 'Title case - ing ' . $text);
    $this->logger->get('amd_blocks')->log(1, 'Title case - ing ' . $text);
    return ucfirst($text);
  }

  /**
   * @param $text string
   * 
   *  Return $text with all lowercase letters.
   */
  public function lowercase($text) {
    //\Drupal::service('logger.factory')->get('amd_blocks')->log(1, 'Lowercase  ing ' . $text);
    $this->logger->get('amd_blocks')->log(1, 'Lowercase  ing ' . $text);
    return mb_strtolower($text);
  }
   
}