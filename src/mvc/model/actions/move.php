<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 19/12/17
 * Time: 15.43
 */
$res['success'] = false;


if ( isset($model->inc->options) &&
  !empty($model->data) &&
  $model->inc->options->move($model->data['idNode'], $model->data['idParentNode'])
){
  $res['success'] = true;
}
return $res;