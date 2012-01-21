<?php


/**
 * 
 * This controller displays any failure in the application. 
 * It should also detect, and display missing 3rd party libraries. 
 * 
 *  
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * 
 *
 */

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
            /**this section deals with other errors thrown by the controller*/
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
          break;
        }
        /**
         * Message: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost' (using password: NO)
         */
       $this->view->exception = $errors->exception;
       $this->view->request   = $errors->request;
    }


}

