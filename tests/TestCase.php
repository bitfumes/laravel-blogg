<?php

namespace Bitfumes\Blogg\Tests;

use Bitfumes\Blogg\BloggServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Bitfumes\Blogg\Models\Blog;
use Bitfumes\Blogg\Models\Category;
use Bitfumes\Blogg\Models\Tag;

class TestCase extends BaseTestCase
{
    public function setup()
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
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function mediaLibraryConfigs()
    {
        config()->set('medialibrary.max_file_size', 1024 * 1024 * 10);
        config()->set('medialibrary.disk_name', 'public');
        config()->set('medialibrary.media_model', \Spatie\MediaLibrary\Models\Media::class);
        config()->set('medialibrary.image_optimizers', [
            \Spatie\ImageOptimizer\Optimizers\Jpegoptim::class => [
                '--strip-all', // this strips out all text information such as comments and EXIF data
                '--all-progressive', // this will make sure the resulting image is a progressive one
            ],
            \Spatie\ImageOptimizer\Optimizers\Pngquant::class => [
                '--force', // required parameter for this package
            ],
            \Spatie\ImageOptimizer\Optimizers\Optipng::class => [
                '-i0', // this will result in a non-interlaced, progressive scanned image
                '-o2', // this set the optimization level to two (multiple IDAT compression trials)
                '-quiet', // required parameter for this package
            ],
            \Spatie\ImageOptimizer\Optimizers\Svgo::class => [
                '--disable=cleanupIDs', // disabling because it is known to cause troubles
            ],
            \Spatie\ImageOptimizer\Optimizers\Gifsicle::class => [
                '-b', // required parameter for this package
                '-O3', // this produces the slowest but best results
            ],
        ]);
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
}
