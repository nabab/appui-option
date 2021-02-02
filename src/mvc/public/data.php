<?php
/* @var $ctrl \bbn\Mvc\Controller */
if ( isset($ctrl->post['id']) ){
  $ctrl->obj->data = $ctrl->inc->options->textValueOptions($ctrl->post['id']);
}
else if ( isset($ctrl->post['id_parent'], $ctrl->post['start'], $ctrl->post['limit']) ){
  $limit = $ctrl->post['limit'] ?: 50;
  $start = $ctrl->post['start'] ?: 0;
  $ctrl->obj->data = array_values($ctrl->inc->options->fullOptions($ctrl->post['id_parent'], false, [], [], $start, $limit));
  foreach ( $ctrl->obj->data as $i => $d ){
    unset($ctrl->obj->data[$i]['id_parent']);
  }
}