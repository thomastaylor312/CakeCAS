<?php

App::import('Vendor', 'CAS/CAS');
App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class CasAuthenticate extends BaseAuthenticate {
    //This has to be protected to work
    protected $_Collection = NULL;

    function __construct($collection, $settings) {
        $this->_Collection = $collection;
        if(Configure::read('CAS.debug_log_enabled')){
            phpCAS::setDebug(TMP . 'phpCas.log.txt');
        }

        phpCAS::client(CAS_VERSION_2_0,
                       Configure::read('CAS.hostname'),
                       Configure::read('CAS.port'),
                       Configure::read('CAS.uri'));

        $certServer = Configure::read('CAS.cert_path');
        if (empty($certServer)) {
            phpCAS::setNoCasServerValidation();
        } else {
            phpCAS::setCasServerCACert($certServer);
        }
    }

    public function authenticate(CakeRequest $request, CakeResponse $response) {
        phpCAS::handleLogoutRequests(false);
        phpCAS::forceAuthentication();
        return array_merge(array('username' => phpCAS::getUser()), phpCAS::getAttributes());
    }

    public function unauthenticated(CakeRequest $request, CakeResponse $response) {
        //Call Auth->login() to set default auth session variables
        if (!empty($this->_Collection)) {
            $controller = $this->_Collection->getController();
            if (!empty($controller->Auth)) {
                $login = $controller->Auth->login(); //This will eventually call back in to $this->authenticate above, thus triggering CAS as needed
                if (!empty($login)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function logout($user) {
        if(phpCAS::isAuthenticated()){
            //Step 1. When the client clicks logout, this will run.
            //        phpCAS::logout will redirect the client to the CAS server.
            //        The CAS server will, in turn, redirect the client back to
            //        this same logout URL.
            //
            //        phpCAS will stop script execution after it sends the redirect
            //        header, which is a problem because CakePHP still thinks the
            //        user is logged in. See Step 2.
            $current_url = Router::url(null, true);
            phpCAS::logout(array('url' => $current_url));
        } else {
            //Step 2. This will run when the CAS server has redirected the client
            //        back to us. Do nothing in this block, then after this method
            //        returns CakePHP will do whatever is necessary to log the user
            //        out from its end (destroying the session or whatever).
        }
    }
}
