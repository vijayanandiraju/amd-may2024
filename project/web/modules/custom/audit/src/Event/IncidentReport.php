<?php

namespace Drupal\audit\Event;

use Symfony\Contracts\EventDispatcher\Event;

class IncidentReport extends Event{

  protected $reporterName;
  protected $reporterEmail;
  protected $entity;
  protected $report;

  /**
   * Constructs an incident report event object
   * 
   * @param string $reporterName
   *    Reporter name
   * @param string $reporterEmail
   *    Reporter email
   * @param int $entity
   *    Entity Deleted
   * @param string $report
   *    Detailed description of the issue
   */
  public function __construct($reporterName, $reporterEmail, $entity, $report)
  {
    $this->reporterName = $reporterName;
    $this->reporterEmail = $reporterEmail;
    $this->entity = $entity;
    $this->report = $report;
    
  }

  /**
   * Get the reporter name
   */
  public function getReporterName() {
    return $this->reporterName;
  }

  /**
   * Get the reporter email
   */
  public function getReporterEmail() {
    return $this->reporterEmail;
  }

  /**
   * Get the deleted entity
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * Get the report
   */
  public function getReport() {
    return $this->report;
  }

}