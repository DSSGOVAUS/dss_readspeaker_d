<?php

/**
*	Template for DSS Readspeaker Configuration form
*/

namespace Drupal\dss_readspeaker\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SettingsForm extends ConfigFormBase {

  // Return Form ID
  public function getFormId() {
    return 'dss_readspeaker_settings_form';
  }

  protected function getEditableConfigNames() {
    return ['dss_readspeaker.credentials'];
  }

  // Build the form
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get the defaults from the config file
    $config = $this->config('dss_readspeaker.credentials');

	// General Options Fieldset
	$form['general'] = [
		'#type' => 'fieldset',
		'#title' => t('General Options'),
		'#tree' => TRUE,
	];
	$form['general']['customerid'] = [
		'#type' => 'textfield',
		'#title' => t('Customer ID'),
		'#default_value' => $config->get('customerid'),
		'#description' => t("Your ReadSpeaker Cutomer ID"),
		'#size' => 4,
		'#maxlength' => 4,
	];
	$form['general']['readid'] = [
		'#type' => 'textfield',
		'#title' => t('Read ID'),
		'#default_value' => $config->get('readid'),
		'#description' => t("The ID of the page element to be read"),
		'#size' => 32,
		'#maxlength' => 32,
	];
	$form['general']['postrender'] = [
		'#type' => 'checkbox',
		'#title' => t('Enable reading after the DOM render'),
		'#default_value' => $config->get('postrender'),
		'#description' => t("For if this website uses JavaScript to build/modify the UI client-side"),
	];
    $form['general']['popupplayer'] = [
      '#type' => 'checkbox',
      '#title' => t('Enable pop-up player'),
      '#default_value' => $config->get('popupplayer'),
      '#description' => t("Display the pop-up player on text highlight"),
	];
	return parent::buildForm($form, $form_state);
	}

  // Save new values on Form Submit
  public function submitForm(array &$form, FormStateInterface $form_state) {
	  // Save Updated values to dss_readspeaker.credentials
    $this->config('dss_readspeaker.credentials')
		->set('customerid', $form_state->getValue(array('general', 'customerid')))
		->set('readid', $form_state->getValue(array('general', 'readid')))
		->set('postrender', $form_state->getValue(array('general', 'postrender')))
    	->set('popupplayer', $form_state->getValue(array('general', 'popupplayer')))
    	->save();
    parent::submitForm($form, $form_state);
  }

}
