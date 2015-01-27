<?php

class PostalController extends Zend_Controller_Action
{

    /**
     * @var Zend_Controller_Action_Helper_Redirector
     */
    private $_postRedirectGet;
    private $_mandrillKey;

    public function init()
    {
      $this->_postRedirectGet = $this->_helper->getHelper('Redirector');
      $this->_postRedirectGet->setCode(303);

        error_log('options: '.var_export($this->getInvokeArg('bootstrap')->getOptions(), true));

      $this->_mandrillKey = $this->getInvokeArg('bootstrap')->getOptions()->mandrill->key;
      error_log('Mandrill key: '.$this->_mandrillKey);
    }

    public function indexAction()
    {
        // action body
    }

    public static function utf8($x)
    {
      return "=?UTF-8?B?".base64_encode($x)."?=";
    }

    public function sendAction()
    {
      $name = filter_var($this->_getParam('name'), FILTER_SANITIZE_STRING);
      $email = filter_var($this->_getParam('email'), FILTER_SANITIZE_EMAIL);
      $phone = filter_var($this->_getParam('phone'), FILTER_SANITIZE_EMAIL);

        if (!$name || !$email || !$phone)
        {
            $this->getResponse()->setHttpResponseCode(400);
            return;
        }

      $message =<<<EOF
Hej!

Softhouse employees and subcontractors are invited to join the Indian Tuesday at the Softhouse office.

If you want to participate today, please fill in the form at http://indiskt.blekinge.it/order/ prior to 10:15.

Payment methods, in order of preference:

1. Swish me at $phone - much preferred!
2. Join me and pay at the restaurant
3. Cash payments - only between 10:00 and 10:15

If you are prevented from all of the above, ask a friend! :-)

I leave from Softhouse at 11:25 to pick up the food.

A couple of things to remember:

o If some of you order pizza, I'd like one of you to join us to pick up the food
o Everyone must help to clean up the tables after lunch - use the Boy Scout Rule! ("Always leave the campground cleaner than you found it.")
o Please put your empty soda can in the recycle bin next to the ice cream fridge



Cheers,

$name
EOF;

        $mandrill = new Mandrill($this->_mandrillKey);
        $parameters = array(
            'text' => $message,
            'subject' => 'Indian Tuesday at Softhouse office!',
            'to' => array(
                array('email' => 'indiskt@lists.2good.nu')
            ),
            'from_name' => $name,
            'from_email' => $email,
            'headers' => array('Content-Type' => 'text/plain; charset=UTF-8"'),
            'auto_html' => true,
            'track_opens' => true,
            'track_clicks' => true,
        );
        try {
            $result = $mandrill->messages->send($parameters);
            error_log(json_encode($result));
        } catch (Mandrill_Error $e) {
            error_log('A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage());
        }


        $this->_postRedirectGet->gotoUrl('/order/');
    }


}



