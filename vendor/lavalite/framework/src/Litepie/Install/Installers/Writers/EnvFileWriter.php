<?php

namespace Litepie\Install\Installers\Writers;

use Illuminate\Filesystem\Filesystem;

class EnvFileWriter
{
    /**
     * @var Filesystem
     */
    private $finder;

    /**
     * @var array
     */
    protected $search = [
        'DB_HOST=127.0.0.1',
        'DB_DATABASE=laravel',
        'DB_USERNAME=root',
        'DB_PASSWORD=',
    ];

    /**
     * @var string
     */
    protected $template = '.env.example';

    /**
     * @var string
     */
    protected $file = '.env';

    /**
     * @param Filesystem $finder
     */
    public function __construct(Filesystem $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @param $name
     * @param $username
     * @param $password
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function write($name, $username, $password, $host)
    {
        $environmentFile = $this->finder->get($this->template);

        $replace = [
            "DB_HOST=$host",
            "DB_DATABASE=$name",
            "DB_USERNAME=$username",
            "DB_PASSWORD=$password",
        ];

        $newEnvironmentFile = str_replace($this->search, $replace, $environmentFile);

        $this->finder->put($this->file, $newEnvironmentFile);
    }
}
