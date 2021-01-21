<?php
/* @var \bbn\mvc\controller $ctrl */
if ( !empty($ctrl->arguments) && \bbn\str::is_uid($ctrl->arguments[0]) ){
  $ctrl->data['id'] = $ctrl->arguments[0];
}
$ctrl->set_url(APPUI_OPTION_ROOT . 'tree/option/' . $ctrl->data['id'])->combo('', true);