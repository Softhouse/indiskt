<?php

class PostalController extends Zend_Controller_Action
{

    /**
     * @var Zend_Controller_Action_Helper_Redirector
     */
    private $_postRedirectGet;
    private $_sendGridApiKey;

    public function init()
    {
        $this->_postRedirectGet = $this->_helper->getHelper('Redirector');
        $this->_postRedirectGet->setCode(303);

        $options = $this->getInvokeArg('bootstrap')->getOptions();
        $this->_sendGridApiKey = $options['sendGrid']['apiKey'];
        error_log('SendGrid API key: ' . $this->_sendGridApiKey);
    }

    public function indexAction()
    {
        // action body
    }

    public static function utf8($x)
    {
        return "=?UTF-8?B?" . base64_encode($x) . "?=";
    }

    public function sendAction()
    {
        $name = filter_var($this->_getParam('name'), FILTER_SANITIZE_STRING);
        $emailAddress = filter_var($this->_getParam('email'), FILTER_SANITIZE_EMAIL);
        $phone = filter_var($this->_getParam('phone'), FILTER_SANITIZE_EMAIL);

        if (!$name || !$emailAddress || !$phone) {
            $this->getResponse()->setHttpResponseCode(400);
            return;
        }

        $message = <<<EOF
<p><strong>Hej!</strong></p>
<p>Softhouse employees and subcontractors are invited to join the Indian Tuesday at the Softhouse office.</p>
<p>If you want to participate today, please fill in the <a href="http://indiskt.blekinge.it/order/">order form</a> prior to 10:15.</p>
<p>Payment methods, in order of preference:</p>
<ol>
<li>Swish me at $phone - much preferred!</li>
<li>Join me and pay at the restaurant</li>
<li>Cash payments - only between 10:00 and 10:15</li>
</ol>
<p>If you are prevented from all of the above, ask a friend! :-)</p>
<p>I leave from Softhouse at 11:20 to pick up the food.</p>
<p>A couple of things to remember:</p>
<ul>
<li>If some of you order pizza, I'd like one of you to join us to pick up the food</li>
<li>Everyone must help to clean up the tables after lunch - use the Boy Scout Rule! ("Always leave the campground cleaner than you found it.")</li>
<li>Please put your empty soda can in the recycle bin next to the ice cream fridge</li>
</ul>
<p>Cheers,</p>
<p><em>$name</em></p>
EOF;

        $sendGrid = new SendGrid($this->_sendGridApiKey);
        $email = new SendGrid\Email();
        $email
            ->setFrom($emailAddress)
            ->setFromName($name)
            ->setSubject('Indian Tuesday at Softhouse office!')
            ->addTo('indiskt@lists.2good.nu')
            ->addCategory('indiskt')
            ->setHtml($message);

        try {
            $result = $sendGrid->send($email);
            error_log(json_encode($result));
        } catch (\Exception $e) {
            error_log('A SendGrid error occurred: ' . get_class($e) . ' - ' . $e->getMessage());
        }

        $this->_postRedirectGet->gotoUrl('/order/');
    }


}



