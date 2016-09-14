<?php
/**
 * Provides the DSS Readspeaker Block
 *
 * @Block(
 *   id = "dss_readspeaker_block",
 *   admin_label = @Translation("DSS ReadSpeaker Block (Module)"),
 *   category = @Translation("Custom DSS Blocks"),
 * )
 */

namespace Drupal\dss_readspeaker\Plugin\Block;
use Drupal\Core\Block\BlockBase;
class ReadspeakerBlock extends BlockBase {
  /**
  * {@inheritdoc}
  */
  public function build() {
	
    $build = array();
    //Get Config vals
    $config = \Drupal::config('dss_readspeaker.credentials');

    $customerid = $config->get('customerid');
    $readid = $config->get('readid');
    $rslang = $config->get('rslang');
    $region = $config->get('region').'.';
    $rsstyles = $config->get('rsstyles');
    $rscompact = $config->get('rscompact');
    $rshttps = $config->get('rshttps');

	$proto = 'http';
    if ($rshttps == true) {
      $proto = 'https';
      $region = ''; // region-code is removed for https requests
    }
	
	$build['#attached']['library'][] = 'dss_readspeaker/dss-readspeaker';

    // Custom styles
    if ($rsstyles == true) {
      $build['#attached']['library'][] = 'dss_readspeaker/dss-readspeaker.custom';
      $output = '<div id="readspeaker_button" class="rs_skip rsbtn_colorskin rs_preserve">';
      $output .= '<a class="rsbtn_play" href="'.$proto.'://app.'.$region.'readspeaker.com/cgi-bin/rsent?customerid='.$customerid.'&amp;lang='.$rslang.'&amp;readid='.$readid.'&amp;url='.$proto.'://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].'">';
      $output .= '<span class="rsbtn_left rspart rsimg"><span class="rsbtn_text"><span>Listen</span></span></span><span class="rsgrad"><span class="rsbtn_right rsplay rspart"></span></span></a></div>';
    }
    // Else, Default Readspeaker code
    else {
      $output = '<div id="readspeaker_button" class="rs_skip rsbtn rs_preserve">';
      $output .= '<a class="rsbtn_play" href="'.$proto.'://app.'.$region.'readspeaker.com/cgi-bin/rsent?customerid='.$customerid.'&amp;lang='.$rslang.'&amp;readid='.$readid.'&amp;url='.$proto.'://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].'">';
      $output .= '<span class="rsbtn_left rspart rsimg"><span class="rsbtn_text"><span>Listen</span></span></span><span class="rsbtn_right rsimg rsplay rspart"></span></a></div>';
    }
    $build['#markup'] = $output;
	return $build;
  }
}