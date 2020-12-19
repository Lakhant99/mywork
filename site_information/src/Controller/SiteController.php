<?php

namespace Drupal\site_information\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for export json.
 */
class SiteController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function data($id) {
    $json_array = array(
      'data' => array()
    );
    // print_r($id);
    // die();
    $nids = \Drupal::entityQuery('node')
    ->condition('type','document')//content type name
    ->execute();
    $nodes =  Node::loadMultiple($nids);
    foreach ($nodes as $node) {
      if($node->get('nid')->value == $id){
         $json_array['data'][] = array(
        'type' => $node->get('type')->target_id,
        'id' => $node->get('nid')->value,
        'attributes' => array(
          'title' =>  $node->get('title')->value,
          'content' => $node->get('body')->value,
        ),
      );
    }
     
    }
    return new JsonResponse($json_array);
  }
}