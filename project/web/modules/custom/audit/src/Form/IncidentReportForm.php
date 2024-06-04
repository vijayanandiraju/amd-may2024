<?php

declare(strict_types=1);

namespace Drupal\audit\Form;

use Drupal\audit\Event\IncidentReport;
use Drupal\audit\Event\IncidentReportEvents;
//use Drupal\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\DependencyInjection\ContainerInterface;

//use Symfony\Component\DependencyInjection\ContainerInterface as DependencyInjectionContainerInterface;

/**
 * Provides a audit form.
 */
final class IncidentReportForm extends FormBase {

  /**
   * Instance of entityTypeManager Service
   * 
   * @var Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Instance of eventDispatcher Service
   * 
   * @var Drupal\Component\EventDispatcher\ContainerAwareEventDispatcher
   */
  protected $eventDispatcher;

  /**
   * Construct an IncidentReportForm
   */
  public function __construct(ContainerAwareEventDispatcher $eventDispatcher, EntityTypeManagerInterface $entityTypeManager)
  {
    $this->eventDispatcher = $eventDispatcher;
    $this->entityTypeManager = $entityTypeManager;

  }


  public static function create(ContainerInterface $container) {
    return new static (
      $container->get('event_dispatcher'),
      $container->get('entity_type.manager')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'audit_incident_report';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['reporter_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Reporter Name'),
      '#description' => $this->t('Please enter your name'),
      '#required' => TRUE,
    ];

    $form['reporter_email'] = [
      '#type' => 'email',
      '#title' => $this->t('Reporter Email'),
      '#description' => $this->t('Please enter your email here'),
      '#required' => TRUE,
    ];

    $form['entity'] = [
      '#type' => 'select',
      '#title' => $this->t('Select the entity that was deleted incorrectly'),
      '#required' => TRUE,
      '#options' => $this->getEntities(),
    ];

    $form['report'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Detailed report'),
      '#description' => $this->t('Describe why this was an error.'),
      '#required' => TRUE,
      ''
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ],
    ];

    return $form;
  }

  public function getEntities() {
    //$storage = \Drupal::entityTypeManager()->getStorage('deletion_record');
    //With DI
    $storage = $this->entityTypeManager->getStorage('deletion_record');
    $query = $storage->getQuery();
    //$query->sort('deleted','DESC');
    //$query->range(0,3)->accessCheck(TRUE);
   $query->accessCheck(TRUE);
    $ids = $query->execute();
    
    $records = $storage->loadMultiple($ids);
    $entities = [];
   
    foreach ($records as $key => $item) {
      $entities[$key] = $item->label->value;
    }

    return $entities;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
       if (mb_strlen($form_state->getValue('report')) < 15) {
         $form_state->setErrorByName(
           'report',
           $this->t('Report should be at least 15 characters.'),
         );
       }
    // @endcode
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $reporter_name = $form_state->getValue('reporter_name');
    $reporter_email = $form_state->getValue('reporter_email');
    $entity= $form_state->getValue('entity');
    $report = $form_state->getValue('report');

    //Trigger the event
    $event = new IncidentReport($reporter_name, $reporter_email,$entity, $report);
    //\Drupal::service('event_dispatcher')->dispatch($event, IncidentReportEvents::NEW_INCIDENT);
    // with DI
    $this->eventDispatcher->dispatch($event, IncidentReportEvents::NEW_INCIDENT);

    ksm($event);
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('<front>');
  }

}
