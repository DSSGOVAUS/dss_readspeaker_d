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

    // Is it http or https?
    $proto = 'http';
    if (isset($_SERVER['HTTPS'])) {
      if ($_SERVER['HTTPS'] != '') $proto = 'https';
    }

    // Build Readspeaker code
    $readurl = htmlspecialchars(strip_tags($proto . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
    $output = '<div id="readspeaker_button" class="rs_skip rsbtn rs_preserve">';
    $output .= '<a rel="nofollow" class="rsbtn_play" href="//app-oc.readspeaker.com/cgi-bin/rsent?customerid='.$customerid.'&amp;lang=en-au&amp;readid='.$readid.'&amp;url='.$readurl.'">';
    $output .= '<span class="rsbtn_left rspart rsimg"><span class="rsbtn_text"><span>Listen</span></span></span><span class="rsbtn_right rsimg rsplay rspart"></span></a></div>';
    $build['#markup'] = $output;

    // Add the library
    $build['#attached']['library'][] = 'dss_readspeaker/dss-readspeaker';

    // Cache the block to the 'Per URL path' context
    $build['#cache'] = array(
      'contexts' => array('url.path', 'url.query_args'),
    );

    // Return it
	  return $build;
  }
}
