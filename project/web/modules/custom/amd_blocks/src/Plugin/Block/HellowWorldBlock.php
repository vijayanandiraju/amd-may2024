<?php

declare(strict_types=1);

namespace Drupal\amd_blocks\Plugin\Block;

use Drupal\amd_blocks\TransformText;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an amdblockshelloworld block.
 *
 * @Block(
 *   id = "amd_blocks_hellow_world",
 *   admin_label = @Translation("AmdBlocksHelloWorld"),
 *   category = @Translation("Custom"),
 * )
 */
final class HellowWorldBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Instance of currentUser Service
   * 
   * @var Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;
  
  /**
   * Instance of textTransformer Service
   * 
   * @var Drupal\amd_blocks\TransformText
   */
  protected $textTransformer;

  /**
   * Instance of entityTypeManager Service
   * 
   * @var Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
     $configuration, 
     $plugin_id,
     $plugin_definition,
     $container->get('current_user'),
     $container->get('text_transformer'),
     $container->get('entity_type.manager')
    );
    
  }

  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxy $currentUser, TransformText $textTransformer, EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $currentUser;
    $this->textTransformer = $textTransformer;
    $this->entityTypeManager = $entityTypeManager;

  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
   //using current user
    //$user = \Drupal::currentUser()->getAccountName(); // Gives current user name
    // using current user with DI
    $user = $this->currentUser->getAccountName();

    //Not needed anymore because we already injected it
    // $textTransformer = \Drupal::service('text_transformer');

    ksm(User::load(8)->getAccountName());
    //using Drupal\user\Entity\User::load or ::loadMultiple
    $another = User::load(8)->getAccountName();
    
    //using entity type manager
    // Next line is no longer needed because we injected the dependency
    //$entityTypeManager = \Drupal::entityTypeManager();
    //$storage = $entityTypeManager->getStorage('user');
    $storage = $this->entityTypeManager->getStorage('user');
    $user_enity = $storage->load(2);
    $username = $user_enity->getAccountName();

    ksm("This User Now");
    ksm($username);
    //$username = \Drupal::entityTypeManager()->getStorage('user')->load(2)->getAccountName();
    // with DI
    $username = $this->entityTypeManager->getStorage('user')->load(2)->getAccountName();
    ksm($username);

    

    $build['content'] = [
      '#type' => 'item',
    // '#markup' => $this->t('Hello! @user_name! Say hi to @another' , ['@user_name' => $textTransformer->reverse($user), '@another' => $another]),
    '#markup' => $this->t('Hello! @user_name! Say hi to @another' , ['@user_name' => $this->textTransformer->reverse($user), '@another' => $another]),
    // '#markup' => $this->t('Hello!'),
    ];

    // Load a node.

$nodeStorage = $this->entityTypeManager->getStorage('node');
$node = $nodeStorage->load(1);
ksm($node);

    return $build;
  }

}
