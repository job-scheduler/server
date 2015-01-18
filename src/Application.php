<?php

namespace JobScheduler\Server;

use Silex\Application as SilexApplication;
use Symfony\Component\HttpFoundation\Request;

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use LinkORB\Component\DatabaseManager\DatabaseManager;
use Doctrine\ORM\Tools\Setup as DoctrineSetup;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Parser as YamlParser;

use RuntimeException;

class Application extends SilexApplication
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->configureParameters();
        $this->configureApplication();
        $this->configureRoutes();
        $this->configureProviders();
        $this->configureServices();
        $this->configureSecurity();
        $this->configureListeners();
    }
    
    private function configureParameters()
    {
        $this['debug'] = true;
    }
    
    private function configureApplication()
    {
        $parser = new YamlParser();
        $this['jobscheduler.baseurl'] = 'http://localhost:8080'; // TODO: Use config file
        //$config = $parser->parse(file_get_contents($this['jobscheduler.basepath'] . '/jobscheduler.yml'));
        //print_r($config);
    }
    
    
    private function configureRoutes()
    {
        $locator = new FileLocator(array($this['jobscheduler.basepath'] . '/app'));
        $loader = new YamlFileLoader($locator);
        $this['routes'] = $loader->load('routes.yml');
    }
    
    private function configureProviders()
    {
        // *** Setup Form ***
        //$this->register(new \Silex\Provider\FormServiceProvider());
        
        // *** Setup Twig ***
        $this->register(new \Silex\Provider\TwigServiceProvider());
        
        $options = array();
        $loader = null; // TODO
        $twig = new \Twig_Environment($loader, $options);
                
        $this['twig.loader.filesystem']->addPath($this['jobscheduler.basepath'] . '/src/Resources/views', 'Dashboard');
        //$this['twig.loader.filesystem']->addPath(__DIR__ . '/../app/Resources/views', 'App');

        // *** Setup Sessions ***
        $this->register(new \Silex\Provider\SessionServiceProvider(), array(
            'session.storage.save_path' => '/tmp/jobscheduler_sessions'
        ));

        // *** Setup Routing ***
        $this->register(new \Silex\Provider\RoutingServiceProvider());

        // *** Setup Doctrine DBAL ***

        $databasemanager = new DatabaseManager();
        $dbconfig = $databasemanager->getDatabaseConfigByDatabaseName('jobscheduler');
        $connectionconfig = $dbconfig->getConnectionConfig('default');
        
        $this['db.config.name'] = $dbconfig->getName();
        $this['db.config.server'] = $connectionconfig->getHost();
        $this['db.config.username'] = $connectionconfig->getUsername();
        $this['db.config.password'] = $connectionconfig->getPassword();
        
        $this->register(new \Silex\Provider\DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver'   => 'pdo_mysql',
                    'host'      => $this['db.config.server'],
                    'dbname'    => $this['db.config.name'],
                    'user'      => $this['db.config.username'],
                    'password'  => $this['db.config.password'],
                    'charset'   => 'utf8',
            ),
        ));
        // *** Setup Doctrine ORM ***
        
        $this->register(new DoctrineOrmServiceProvider, array(
            "orm.proxies_dir" => __DIR__ . "../tmp",
            "orm.em.options" => array(
                "mappings" => array(
                    array(
                        "type" => "annotation",
                        "namespace" => "JobScheduler\Server\Entity",
                        "path" => __DIR__."/Entity",
                    )
                ),
            ),
        ));

    }
    
    private function configureServices()
    {
        $service = new Service($this['orm.em'], 'http://localhost:8080');
        $this['jobscheduler.service'] = $service;
    }
    
    private function configureSecurity()
    {
        return; // TODO
        $this->register(new \Silex\Provider\SecurityServiceProvider(), array());

        $manager = new DatabaseManager();

        //$accountdbal = $manager->getDbalConnection($accountdbname, 'default');
        //$this['security.encoder.digest'] = new PlaintextPasswordEncoder(true);
        //$this['security.encoder.digest'] = new CustomPasswordEncoder();
        //$userprovider = new JobSchedulerUserProvider($accountdbal);
        //$userprovider = new \JobScheduler\Security\JsonFileUserProvider('/share/config/user/');

        $this['security.firewalls'] = array(
            /*
            'api' => array(
                'anonymous' => false,
                'http' => true,
                'pattern' => '^/api',
                'users' => new JobSchedulerApiKeyUserProvider($this['db'], null)
            ),
            */
            /*
            'dashboard' => array(
                'anonymous' => true,
                'pattern' => '^/',
                'form' => array('login_path' => '/login', 'check_path' => '/dashboard/login_check'),
                'logout' => array('logout_path' => '/logout'),
                'users' => $userprovider,
            )
            */
        );
    }
    
    private function configureListeners()
    {
        // TODO
    }
}
