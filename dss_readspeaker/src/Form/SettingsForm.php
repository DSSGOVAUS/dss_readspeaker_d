<?php

/**
	Template for DSS Readspeaker Configuration form
*/

namespace Drupal\dss_readspeaker\Form;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SettingsForm extends ConfigFormBase {
	
	//Return Form ID
	public function getFormId() {
    	return 'dss_readspeaker_settings_form';
  	}
	
	//Not really sure what this does but without it it breaks 
	protected function getEditableConfigNames() {
    	return array('dss_readspeaker.credentials');
  	}
	
	//Build the form
   	public function buildForm(array $form, FormStateInterface $form_state) {
    	//Get the defaults from the config file
		$config = $this->config('dss_readspeaker.credentials');
		
		//General Options Fieldset
		$form['general'] = array(
			'#type' => 'fieldset',
			'#title' => t('General Options'),
			'#tree' => TRUE,
		);	
		$form['general']['customerid'] = array(
			'#type' => 'textfield',
			'#title' => t('Customer ID'),		
			'#default_value' => $config->get('customerid'),
			'#description' => t("Your ReadSpeaker Cutomer ID"),
			'#size' => 4,
			'#maxlength' => 4,		
		);
		$form['general']['readid'] = array(
			'#type' => 'textfield',
			'#title' => t('Read ID'),		
			'#default_value' => $config->get('readid'),
			'#description' => t("The ID of the page element to be read"),
			'#size' => 32,
			'#maxlength' => 32,	
		);
		$form['general']['rslang'] = array(
			'#type' => 'textfield',
			'#title' => t('Language'),		
			'#default_value' => $config->get('rslang'),
			'#description' => t("Document language"),
			'#size' => 5,
			'#maxlength' => 5,	
		);	
		$form['general']['region'] =  array(
			'#type' => 'textfield',
			'#title' => t('Region'),		
			'#default_value' => $config->get('region'),
			'#description' => t("ReadSpeaker Region"),
			'#size' => 2,
			'#maxlength' => 2,	
		);
		//Other Options Fieldset	
		$form['style'] = array(
			'#type' => 'fieldset',
			'#title' => t('Other Options'),
			'#tree' => TRUE,
		);	
		$form['style']['rsstyles'] = array(
			'#type' => 'checkbox',
			'#title' => t('Use custom styles'),		
			'#default_value' => $config->get('rsstyles'),
			'#description' => t("Uncheck to use ReadSpeaker's default styles"),
		);
		$form['style']['rscompact'] = array(
			'#type' => 'checkbox',
			'#title' => t('Use compact player'),		
			'#default_value' => $config->get('rscompact'),
			'#description' => t("Reduced width, if space is at a premium"),
		); 
		$form['style']['rshttps'] = array(
			'#type' => 'checkbox',
			'#title' => t('Use https://'),		
			'#default_value' =>$config->get('rshttps'),
			'#description' => t("Connects to Readspeaker's CDN with the https protocol"),
		); 
    	return parent::buildForm($form, $form_state);
	}



  //Save new values on Form Submit
  public function submitForm(array &$form, FormStateInterface $form_state) {
	
	//Save Updated values to dss_readspeaker.credentials
    $this->config('dss_readspeaker.credentials')
		->set('customerid', $form_state->getValue(array('general', 'customerid')))
		->set('readid', $form_state->getValue(array('general', 'readid')))
		->set('rslang', $form_state->getValue(array('general', 'rslang')))
		->set('region', $form_state->getValue(array('general', 'region')))
		->set('rsstyles', $form_state->getValue(array('style', 'rsstyles')))
		->set('rscompact', $form_state->getValue(array('style', 'rscompact')))
		->set('rshttps', $form_state->getValue(array('style', 'rshttps')))
	    ->save();
		
    parent::submitForm($form, $form_state);
  }

}
