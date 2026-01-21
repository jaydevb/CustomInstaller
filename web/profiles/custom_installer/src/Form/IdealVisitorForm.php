<?php

declare(strict_types=1);

namespace Drupal\custom_installer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\RecipeKit\Installer\FormInterface as InstallerFormInterface;

/**
 * Provides a form for defining the ideal visitor.
 */
class IdealVisitorForm extends FormBase implements InstallerFormInterface {

  /**
   * {@inheritdoc}
   */
  public static function toInstallTask(array $install_state): array {
    return [
      'display_name' => t('Ideal visitor'),
      'type' => 'form',
      'run' => (($install_state['parameters']['custom_installer_ideal_visitor_form'] ?? '') === 'completed') ? INSTALL_TASK_SKIP : INSTALL_TASK_RUN_IF_REACHED,
      'function' => static::class,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'custom_installer_ideal_visitor_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    global $install_state;

    // Set the form title (required by Drupal installer)
    $form['#title'] = $this->t('Ideal visitor');

    $form['#attributes']['class'][] = 'blueprint-form';

    // Question label - "Question 5/6"
    $form['question_label'] = [
      '#type' => 'markup',
      '#markup' => '<div class="blueprint-question-label">' . $this->t('Question 5/6') . '</div>',
      '#weight' => -100,
    ];

    // Main question text
    $form['question'] = [
      '#type' => 'markup',
      '#markup' => '<h2 class="blueprint-question">' . $this->t("Who are we talking to?") . '</h2>',
      '#weight' => -90,
    ];

    // Subheading
    $form['subheading'] = [
      '#type' => 'markup',
      '#markup' => '<p class="blueprint-helper-text">' . $this->t("If your ideal visitor walked into a room, how would you describe them in one sentence?") . '</p>',
      '#weight' => -85,
    ];

    // Options as checkboxes
    $form['add_ons'] = [
      '#type' => 'checkboxes',
      '#options' => [
        'capture_leads' => $this->t('Capture Leads'),
        'make_sale' => $this->t('Make a Sale'),
        'build_awareness' => $this->t('Build Awareness'),
        'join_community' => $this->t('Join a Community'),
      ],
      '#prefix' => '<div class="cms-installer__form-group">',
      '#suffix' => '</div>',
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
      '#value' => $this->t('Continue to next stage'),
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
    $install_state['parameters']['custom_installer_ideal_visitor_form'] = 'completed';
  }

}
