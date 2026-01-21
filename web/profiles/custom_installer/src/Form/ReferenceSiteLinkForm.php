<?php

declare(strict_types=1);

namespace Drupal\custom_installer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\RecipeKit\Installer\FormInterface as InstallerFormInterface;

/**
 * Provides a form for reference site link and API key.
 */
class ReferenceSiteLinkForm extends FormBase implements InstallerFormInterface {

  /**
   * {@inheritdoc}
   */
  public static function toInstallTask(array $install_state): array {
    return [
      'display_name' => t('Reference site link'),
      'type' => 'form',
      'run' => (($install_state['parameters']['custom_installer_reference_site_link_form'] ?? '') === 'completed') ? INSTALL_TASK_SKIP : INSTALL_TASK_RUN_IF_REACHED,
      'function' => static::class,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'custom_installer_reference_site_link_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    global $install_state;

    // Set the form title (required by Drupal installer)
    $form['#title'] = $this->t('Reference site link');

    $form['#attributes']['class'][] = 'blueprint-form';

    // Question label - "Question 2/6"
    $form['question_label'] = [
      '#type' => 'markup',
      '#markup' => '<div class="blueprint-question-label">' . $this->t('Question 2/6') . '</div>',
      '#weight' => -100,
    ];

    // Reference site URL input field
    $form['reference_site_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Reference site's URL"),
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => $this->t('Enter reference site URL'),
        'class' => ['blueprint-input'],
        'autocomplete' => 'off',
      ],
      '#weight' => -80,
    ];

    // OpenAI API key password field
    $form['openai_api_key'] = [
      '#type' => 'password',
      '#title' => $this->t('OpenAI api key'),
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => $this->t('Enter OpenAI API key'),
        'class' => ['blueprint-input'],
        'autocomplete' => 'off',
      ],
      '#weight' => -70,
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
    $install_state['parameters']['custom_installer_reference_site_link_form'] = 'completed';
    $install_state['parameters']['recipes'][] = 'drupal/clone_with_ai';
  }

}
