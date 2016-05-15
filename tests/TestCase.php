<?php
namespace Rnr\Tests\YandexKassa;

use Faker\Generator;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Prophecy\Prophet;
use Rnr\Tests\YandexKassa\Mock\OrderService;
use Rnr\YandexKassa\Providers\YandexKassaProvider;
use Illuminate\Contracts\Config\Repository as Config;

class TestCase extends BaseTestCase
{
    /** @var  Generator */
    protected $faker;
    /** @var Prophet */
    protected $prophet;
    
    protected function getPackageProviders($app)
    {
        return [YandexKassaProvider::class];
    }
    
    public function getFixture($file) {
        $data = file_get_contents(dirname(__DIR__) . "/tests/fixtures/{$file}");

        return json_decode($data, true);
    }

    protected function getEnvironmentSetUp($app)
    {
        /** @var Config $config */
        $config = $app->make(Config::class);
        
        $config->set('yandex-kassa', [
            'shopId' => '12323',
            'password' => 'wjx7MRUx',
            'routes' => [
                'check' => '/payment/yandex/check',
                'aviso' => '/payment/yandex/aviso'
            ]
        ]);
    }

    public function setUp()
    {
        parent::setUp(); 
        
        $this->faker = new Generator();
        $this->prophet = new Prophet();
    }
}