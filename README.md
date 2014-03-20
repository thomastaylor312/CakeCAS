CakeCAS
=======

This is a simple Plugin for making phpCAS work with CakePHP. Just put this file in the Controller/Component/Auth/ folder and anywhere you are using the Auth component you can use ```$this->Auth->authenticate = array('CakeCAS.Cas');```

If you want to contribute or have ideas to make this better, let me know and/or submit a pull request.

### Installation

##### Prerequisites
Make sure to have [phpCAS](https://wiki.jasig.org/display/CASC/phpCAS) installed in the app/Vendor folder.  
Use ```Configure::write()``` to write these variables in core.php: CAS.hostname, CAS.port, CAS.uri, CAS.debug\_log\_enabled, and CAS.cert_path.

##### Git Clone
Run the following command in the app/Plugin folder:  
`git clone git@github.com:thomastaylor312/CakeCAS.git`

### Usage

In `app/Config/bootstrap.php` add: `CakePlugin::load('CakeCAS');`

### Contributors
This plugin was originally written by [@snelg](https://github.com/snelg) and modified by me.
