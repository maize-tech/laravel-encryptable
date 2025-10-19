<?php

namespace Maize\Encryptable\Tests;

use Illuminate\Database\Schema\Blueprint;
use Maize\Encryptable\EncryptableServiceProvider;
use Maize\Encryptable\Tests\Models\User;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            EncryptableServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('encryptable.key', 'RANDOM_ENCRYPTION_KEY');
        $app['config']->set('encryptable.cipher', 'aes-128-ecb');
    }

    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function createUser(array $attrs = [])
    {
        $user = new User();

        $user->forceFill(array_merge([
            'first_name' => 'Name',
            'last_name' => 'Surname',
            'email' => 'name.surname@example.com',
        ], $attrs))->save();

        return $user->fresh();
    }
}
