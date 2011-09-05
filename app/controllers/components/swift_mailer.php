<?php

App::import('Vendor', 'Swift', array('file' => 'SwiftMailer' . DS . 'swift_required.php'));

class SwiftMailerComponent extends Object {

    var $controller = false;
    var $layout = 'email';
    var $viewPath = 'email';
    var $from = null;
    var $fromName = null;
    var $to = null;
    var $toName = null;

    function startup(&$controller) {
        $this->controller = & $controller;
    }

    function _getBodyText($view) {

        // Temporarily store vital variables used by the controller.
        $tmpLayout = $this->controller->layout;
        $tmpAction = $this->controller->action;
        $tmpOutput = $this->controller->output;
        $tmpRender = $this->controller->autoRender;

        // Render the plaintext email body.
        ob_start();
        $this->controller->output = null;
        $body = $this->controller->render($this->viewPath . DS . $view . '_text', $this->layout . '_text');
        ob_end_clean();

        // Restore the layout, view, output, and autoRender values to the controller.
        $this->controller->layout = $tmpLayout;
        $this->controller->action = $tmpAction;
        $this->controller->output = $tmpOutput;
        $this->controller->autoRender = $tmpRender;

        return $body;
    }

    function _getBodyHTML($view) {
        //pr($this->controller);
        // Temporarily store vital variables used by the controller.
        $tmpLayout = $this->controller->layout;
        $tmpAction = $this->controller->action;
        $tmpOutput = $this->controller->output;
        $tmpRender = $this->controller->autoRender;

        // Render the HTML email body.
        ob_start();
        $this->controller->output = null;
        $body = $this->controller->render($this->viewPath . DS . $view . '_html', $this->layout . '_html');
        ob_end_clean();

        // Restore the layout, view, output, and autoRender values to the controller.
        $this->controller->layout = $tmpLayout;
        $this->controller->action = $tmpAction;
        $this->controller->output = $tmpOutput;
        $this->controller->autoRender = $tmpRender;

        return $body;
    }

    function send($view = 'default', $subject = '') {

        // Create the message, and set the message subject.
        $message = & Swift_Message::newInstance();

        $message->setSubject($subject);

        // Append the HTML and plain text bodies.
        $bodyHTML = $this->_getBodyHTML($view);
        $bodyText = $this->_getBodyText($view);

        $message->setBody($bodyText, "text/plain");
        $message->addPart($bodyHTML, "text/html");

        // Set the from address/name.
        $message->setFrom(array($this->from => $this->fromName));
        $message->setReplyTo(array($this->from => $this->fromName));
        // Create the recipient list.
        //$recipients =& new Swift_RecipientList();
        $setarray = "";

        if (is_array($this->to)) {
            $recsize = sizeof($this->to);
            for ($i = 0; $i < $recsize; $i++) {
                $setarray[$this->to[$i]] = $this->toName[$i];
            }
        } else {
            $setarray = array($this->to => $this->toName);
        }

        $message->setTo($setarray);

        $transport = Swift_SmtpTransport::newInstance();
        $transport->setHost('smtp.sendgrid.net');
        $transport->setPort(587);

        $transport->setUsername('karanvir.shekhawat@gmail.com');
        $transport->setPassword('crushAIDER2011');
        $mailer = Swift_Mailer::newInstance($transport);

        // Attempt to send the email.
        $result = $mailer->send($message);

        return $result;
    }

}

?>