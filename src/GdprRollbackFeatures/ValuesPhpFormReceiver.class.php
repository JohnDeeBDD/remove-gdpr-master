<?php

namespace GdprRollbackFeatures;

class ValuesPhpFormReceiver{
    
    public function bool_isFormBeingSubmitted(){
        
    }

    public function setWordPressDbOption(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (isset($_POST['allow-comments-privacy'])){
                update_option('deactivateGdprCommentFieldFeature', FALSE);
            }else{
                update_option('deactivateGdprCommentFieldFeature', TRUE);
            }
        }
    }
}