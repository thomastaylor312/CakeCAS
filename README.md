CakeCAS
=======

This is a simple library for making phpCAS work with CakePHP. Just put this file in the Controller/Component/Auth/ folder and anywhere you are using the Auth component you can use ```$this->Auth->authenticate = array('Cas');```

Make sure to have [phpCAS](https://wiki.jasig.org/display/CASC/phpCAS) installed in the Vendor folder before trying to make this work.  

If you want to contribute or have ideas to make this better, let me know and/or submit a pull request.

Also, use ```Configure::write()``` to write these variables in core.php: CAS.hostname, CAS.port, CAS.uri, CAS.debug\_log\_enabled, and CAS.cert_path.
