<?php

declare(strict_types=1);

namespace Drupal\custom_installer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\RecipeKit\Installer\FormInterface as InstallerFormInterface;

/**
 * Provides a form for naming the project ("giving it a soul").
 */
class ProjectSoulForm extends FormBase implements InstallerFormInterface {

  /**
   * {@inheritdoc}
   */
  public static function toInstallTask(array $install_state): array {
    return [
      'display_name' => t('Name your project'),
      'type' => 'form',
      'run' => array_key_exists('project_soul_name', $install_state['parameters']) ? INSTALL_TASK_SKIP : INSTALL_TASK_RUN_IF_REACHED,
      'function' => static::class,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'custom_installer_project_soul_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    global $install_state;
    
    // Set the form title (required by Drupal installer)
    $form['#title'] = $this->t('Name your project');
    
    $form['#attributes']['class'][] = 'blueprint-form';
    
    // Question label - "Question 1/5"
    $form['question_label'] = [
      '#type' => 'markup',
      '#markup' => '<div class="blueprint-question-label">' . $this->t('Question 1/5') . '</div>',
      '#weight' => -100,
    ];
    
    // Main question text
    $form['question'] = [
      '#type' => 'markup',
      '#markup' => '<h2 class="blueprint-question">' . $this->t("To get started, let's give this project a soul. What should we call your masterpiece?") . '</h2>',
      '#weight' => -90,
    ];
    
    // Project name input field
    $form['project_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Project name'),
      '#title_display' => 'invisible',
      '#required' => TRUE,
      '#default_value' => $install_state['forms']['install_configure_form']['site_name'] ?? $this->t('My Masterpiece'),
      '#attributes' => [
        'placeholder' => $this->t('Enter project name'),
        'class' => ['blueprint-input'],
        'autocomplete' => 'off',
      ],
      '#weight' => -80,
    ];
    
    // Actions wrapper
    $form['actions'] = [
      '#type' => 'actions',
      '#attributes' => ['class' => ['blueprint-actions']],
      '#weight' => 100,
    ];
    
    // Submit button
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Next'),
      '#attributes' => ['class' => ['blueprint-button']],
      '#button_type' => 'primary',
    ];
    
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $project_name = trim($form_state->getValue('project_name'));
    
    // Validate minimum length
    if (strlen($project_name) < 2) {
      $form_state->setErrorByName('project_name', $this->t('Project name must be at least 2 characters long.'));
    }
    
    // Validate maximum length
    if (strlen($project_name) > 128) {
      $form_state->setErrorByName('project_name', $this->t('Project name must be less than 128 characters.'));
    }
    
    // Validate not just whitespace
    if (empty($project_name)) {
      $form_state->setErrorByName('project_name', $this->t('Project name cannot be empty.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    global $install_state;
    
    $project_name = trim($form_state->getValue('project_name'));
    
    // Store in install_state parameters for later use
    $install_state['parameters']['project_soul_name'] = $project_name;
    $install_state['forms']['install_configure_form']['site_name'] = $project_name;
  }

}
