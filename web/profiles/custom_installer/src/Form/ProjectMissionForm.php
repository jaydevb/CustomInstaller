<?php

declare(strict_types=1);

namespace Drupal\custom_installer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\RecipeKit\Installer\FormInterface as InstallerFormInterface;

/**
 * Provides a form for describing the project mission.
 */
class ProjectMissionForm extends FormBase implements InstallerFormInterface {

  /**
   * {@inheritdoc}
   */
  public static function toInstallTask(array $install_state): array {
    return [
      'display_name' => t('Project mission'),
      'type' => 'form',
      'run' => (($install_state['parameters']['custom_installer_project_mission_form'] ?? '') === 'completed') ? INSTALL_TASK_SKIP : INSTALL_TASK_RUN_IF_REACHED,
      'function' => static::class,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'custom_installer_project_mission_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    global $install_state;

    // Set the form title (required by Drupal installer)
    $form['#title'] = $this->t('Project mission');

    $form['#attributes']['class'][] = 'blueprint-form';

    // Question label - "Question 3/6"
    $form['question_label'] = [
      '#type' => 'markup',
      '#markup' => '<div class="blueprint-question-label">' . $this->t('Question 3/6') . '</div>',
      '#weight' => -100,
    ];

    // Main question text
    $form['question'] = [
      '#type' => 'markup',
      '#markup' => '<h2 class="blueprint-question">' . $this->t("That's a powerful space to be in! Tell me a bit more about the 'Why' behind this project.") . '</h2>',
      '#weight' => -90,
    ];

    // Subheading
    $form['subheading'] = [
      '#type' => 'markup',
      '#markup' => '<p class="blueprint-helper-text">' . $this->t("What is the main problem you're solving, or the mission you're on?") . '</p>',
      '#weight' => -85,
    ];

    // Textarea field
    $form['project_mission'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Project mission'),
      '#title_display' => 'invisible',
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => $this->t('Explain in detail'),
        'class' => ['blueprint-input'],
      ],
      '#weight' => -80,
    ];

    // Actions wrapper
    $form['actions'] = [
      '#type' => 'actions',
      '#attributes' => ['class' => ['blueprint-actions']],
      '#weight' => 100,
    ];
    // Back button (visual only, no functionality)
    $form['actions']['back'] = [
      '#type' => 'submit',
      '#value' => $this->t('Back'),
      '#attributes' => ['class' => ['blueprint-button--back']],
      '#button_type' => 'primary',
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
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    global $install_state;
    $install_state['parameters']['custom_installer_project_mission_form'] = 'completed';
  }

}
