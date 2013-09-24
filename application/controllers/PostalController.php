<?php

class PostalController extends Zend_Controller_Action
{

    public function init()
    {
      $this->_postRedirectGet = $this->_helper->getHelper('Redirector');
      $this->_postRedirectGet->setCode(303);
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

      $message =<<<EOF
Hej!

Softhouse employees and subcontractors are invited to join the Indian Tuesday at the Softhouse office.

If you want to participate today, please fill in the form at http://indiskt.blekinge.it/order/ prior to 10:15.

I leave from Softhouse at 11:25 to pick up the food.

Some important details:

o If some of you order pizza, I'd like one of you to join us to pick up the food
o Everyone must help to clean up the tables after lunch - use the Boy Scout Rule! ("Always leave the campground cleaner than you found it.")
o Please put your empty soda can in the recycle bin next to the ice cream fridge

Payment via Swish preferred - see https://www.getswish.se/ for more information.


Cheers,

$name
EOF;

      $headers = 'From: '.self::utf8($name)
        ." <$email>\r\nContent-Type: text/plain;charset=UTF-8\r\nX-PHP-Originating-Script: Yes, Sir!\r\nX-Indiskt-Diet: HCHF";

      mail('indiskt@lists.2good.nu', 
        self::utf8('Indian Tuesday at Softhouse office!'),
        $message, 
        $headers);

      $this->_postRedirectGet->gotoUrl('/order/');
    }


}



