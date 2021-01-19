<?php
if ( empty($ctrl->post['limit']) ){
  $ctrl->combo(_("Full List"), true);
}
else{
  $ctrl->action();
}
