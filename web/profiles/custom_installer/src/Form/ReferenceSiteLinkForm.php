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

    // Main question text
    $form['question'] = [
      '#type' => 'markup',
      '#markup' => '<h2 class="blueprint-question">' . $this->t("Got a site that inspires you? Let's use it as your muse.") . '</h2>',
      '#weight' => -90,
    ];

    // Subheading
    $form['subheading'] = [
      '#type' => 'markup',
      '#markup' => '<p class="blueprint-helper-text">' . $this->t("Share a URL and your AI provider's API key, and we'll craft something beautifully similar.") . '</p>',
      '#weight' => -85,
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

    // AI Provider select field
    $form['ai_provider'] = [
      '#type' => 'select',
      '#title' => $this->t('Select a provider'),
      '#options' => [
        '' => $this->t('- Select a provider -'),
        'openai' => $this->t('OpenAI'),
        'anthropic' => $this->t('Anthropic'),
        'google' => $this->t('Google Gemini'),
        'cohere' => $this->t('Cohere'),
        'self_hosted' => $this->t('Self hosted'),
      ],
      '#required' => TRUE,
      '#attributes' => [
        'class' => ['blueprint-input', 'blueprint-select'],
      ],
      '#weight' => -75,
    ];

    // OpenAI API key field
    $form['openai_api_key'] = [
      '#type' => 'password',
      '#title' => $this->t('Your OpenAI API key'),
      '#attributes' => [
        'placeholder' => $this->t('Enter your OpenAI API key'),
        'class' => ['blueprint-input'],
        'autocomplete' => 'off',
      ],
      '#weight' => -70,
      '#states' => [
        'visible' => [
          ':input[name="ai_provider"]' => ['value' => 'openai'],
        ],
        'required' => [
          ':input[name="ai_provider"]' => ['value' => 'openai'],
        ],
      ],
    ];

    // Anthropic API key field
    $form['anthropic_api_key'] = [
      '#type' => 'password',
      '#title' => $this->t('Your Anthropic API key'),
      '#attributes' => [
        'placeholder' => $this->t('Enter your Anthropic API key'),
        'class' => ['blueprint-input'],
        'autocomplete' => 'off',
      ],
      '#weight' => -70,
      '#states' => [
        'visible' => [
          ':input[name="ai_provider"]' => ['value' => 'anthropic'],
        ],
        'required' => [
          ':input[name="ai_provider"]' => ['value' => 'anthropic'],
        ],
      ],
    ];

    // Google Gemini API key field
    $form['google_api_key'] = [
      '#type' => 'password',
      '#title' => $this->t('Your Google Gemini API key'),
      '#attributes' => [
        'placeholder' => $this->t('Enter your Google Gemini API key'),
        'class' => ['blueprint-input'],
        'autocomplete' => 'off',
      ],
      '#weight' => -70,
      '#states' => [
        'visible' => [
          ':input[name="ai_provider"]' => ['value' => 'google'],
        ],
        'required' => [
          ':input[name="ai_provider"]' => ['value' => 'google'],
        ],
      ],
    ];

    // Cohere API key field
    $form['cohere_api_key'] = [
      '#type' => 'password',
      '#title' => $this->t('Your Cohere API key'),
      '#attributes' => [
        'placeholder' => $this->t('Enter your Cohere API key'),
        'class' => ['blueprint-input'],
        'autocomplete' => 'off',
      ],
      '#weight' => -70,
      '#states' => [
        'visible' => [
          ':input[name="ai_provider"]' => ['value' => 'cohere'],
        ],
        'required' => [
          ':input[name="ai_provider"]' => ['value' => 'cohere'],
        ],
      ],
    ];

    // Self hosted base URL field
    $form['self_hosted_base_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Base URL'),
      '#attributes' => [
        'placeholder' => $this->t('https://your-server.com/v1'),
        'class' => ['blueprint-input'],
        'autocomplete' => 'off',
      ],
      '#weight' => -70,
      '#states' => [
        'visible' => [
          ':input[name="ai_provider"]' => ['value' => 'self_hosted'],
        ],
        'required' => [
          ':input[name="ai_provider"]' => ['value' => 'self_hosted'],
        ],
      ],
    ];

    // Self hosted API key field
    $form['self_hosted_api_key'] = [
      '#type' => 'password',
      '#title' => $this->t('API key'),
      '#attributes' => [
        'placeholder' => $this->t('Enter your API key'),
        'class' => ['blueprint-input'],
        'autocomplete' => 'off',
      ],
      '#weight' => -69,
      '#states' => [
        'visible' => [
          ':input[name="ai_provider"]' => ['value' => 'self_hosted'],
        ],
        'required' => [
          ':input[name="ai_provider"]' => ['value' => 'self_hosted'],
        ],
      ],
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
