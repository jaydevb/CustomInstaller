<?php

declare(strict_types=1);

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Site\Settings;
use Drupal\RecipeKit\Installer\Hooks;
use Drupal\RecipeKit\Installer\Messenger;

/**
 * Implements hook_install_tasks().
 */
function custom_installer_install_tasks(array &$install_state): array {
  // Use RecipeKit's task infrastructure
  $tasks = Hooks::installTasks($install_state);

  if (getenv('IS_DDEV_PROJECT')) {
    Messenger::reject(
      'All necessary changes to %dir and %file have been made, so you should remove write permissions to them now in order to avoid security risks. If you are unsure how to do so, consult the <a href=":handbook_url">online handbook</a>.',
    );
  }
  
  return $tasks;
}

/**
 * Implements hook_install_tasks_alter().
 */
function custom_installer_install_tasks_alter(array &$tasks, array $install_state): void {
  // Use RecipeKit's task alteration
  Hooks::installTasksAlter($tasks, $install_state);
  
  // Customize the batch job title for recipe installation
  $langcode = $GLOBALS['install_state']['parameters']['langcode'];
  $settings = Settings::getAll();
  $settings["locale_custom_strings_$langcode"]['']['Installing @drupal'] = 'Building your masterpiece';
  new Settings($settings);
}

/**
 * Implements hook_form_alter().
 */
function custom_installer_form_alter(array &$form, FormStateInterface $form_state, string $form_id): void {
  // Delegate to RecipeKit's form alter
  Hooks::formAlter($form, $form_state, $form_id);
}

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form.
 */
function custom_installer_form_install_configure_form_alter(array &$form): void {
  // Hide update notifications since we'll handle updates differently
  if (isset($form['update_notifications'])) {
    $form['update_notifications']['#access'] = FALSE;
  }
}
