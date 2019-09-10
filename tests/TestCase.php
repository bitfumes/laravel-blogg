<?php

namespace Bitfumes\Blogg\Tests;

use Bitfumes\Blogg\Models\Tag;
use Bitfumes\Blogg\Models\Blog;
use Bitfumes\Blogg\Models\Category;
use Illuminate\Support\Facades\Storage;
use Bitfumes\Blogg\BloggServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setup() :void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->artisan('migrate', ['--database' => 'testing']);
        $this->loadMigrations();
        $this->loadFactories();
        app()['config']->set('blogg.models.user', User::class);
    }

    protected function loadFactories()
    {
        $this->withFactories(__DIR__ . '/../src/database/factories'); // package factories
        $this->withFactories(__DIR__ . '/database/factories'); // Test factories
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../src/database/migrations');
        $this->loadLaravelMigrations(['--database' => 'testing']); // package migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations'); // test migrations
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $app['config']->set('database.redis.client', 'predis');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [BloggServiceProvider::class];
    }

    /**
     * @param array $args
     * @return mixed
     */
    public function createUser($args = [])
    {
        return factory(User::class)->create($args);
    }

    /**
     * @param int $num
     * @param array $args
     * @return mixed
     */
    public function createBlog($num = null, $args = [])
    {
        return factory(Blog::class, $num)->create($args);
    }

    /**
     * @param int $num
     * @param array $args
     * @return mixed
     */
    public function createCategory($num = null, $args = [])
    {
        return factory(Category::class, $num)->create($args);
    }

    /**
     * @param int $num
     * @param array $args
     * @return mixed
     */
    public function createTag($num = null, $args = [])
    {
        return factory(Tag::class, $num)->create($args);
    }

    /**
     * @param int $num
     * @return mixed
     */
    public function createPublishedBlog($num = null)
    {
        return factory(Blog::class, $num)->create(['published' => true]);
    }

    /**
     * @param int $num
     * @return mixed
     */
    public function makeBlog($num = null)
    {
        return factory(Blog::class, $num)->make();
    }

    public function loggedInUser()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');
        return $user;
    }

    public function removeImage($path)
    {
        Storage::disk('public')->delete($path . '.jpg');
        Storage::disk('public')->delete($path . '_thumb.jpg');
    }
}
