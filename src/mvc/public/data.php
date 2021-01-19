<?php
/* @var $ctrl \bbn\mvc\controller */
if ( isset($ctrl->post['id']) ){
  $ctrl->obj->data = $ctrl->inc->options->text_value_options($ctrl->post['id']);
}
else if ( isset($ctrl->post['id_parent'], $ctrl->post['start'], $ctrl->post['limit']) ){
  $limit = $ctrl->post['limit'] ?: 50;
  $start = $ctrl->post['start'] ?: 0;
  $ctrl->obj->data = array_values($ctrl->inc->options->full_options($ctrl->post['id_parent'], false, [], [], $start, $limit));
  foreach ( $ctrl->obj->data as $i => $d ){
    unset($ctrl->obj->data[$i]['id_parent']);
  }
}