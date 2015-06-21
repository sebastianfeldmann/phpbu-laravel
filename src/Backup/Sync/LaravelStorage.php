<?php
namespace phpbu\Laravel\Backup\Sync;

use Illuminate\Support\Facades\Storage;
use phpbu\App\Backup\Sync as SyncInterface;
use phpbu\App\Backup\Target;
use phpbu\App\Exception;
use phpbu\App\Result;

/**
 * Class LaravelStorage
 *
 * Syncs a backup with the Laravel filesystem classes.
 *
 * @package    phpbu\Laravel
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 */
class LaravelStorage implements SyncInterface
{
    /**
     * Laravel filesystem to sync to.
     *
     * @var string
     */
    private $filesystem;

    /**
     * Path to copy the backup.
     *
     * @var string
     */
    private $path;

    /**
     * Setup the source.
     *
     * @param  array $conf
     * @throws \phpbu\App\Exception
     */
    public function setup(array $conf = array())
    {
        if (empty($conf['filesystem'])) {
            throw new Exception('no filesystem configured');
        }
        $this->filesystem = $conf['filesystem'];
        $this->path       = empty($conf['path']) ? $conf['path'] : '';
    }

    /**
     * Execute the Sync
     * Copy your backup to another location
     *
     * @param \phpbu\App\Backup\Target $target
     * @param \phpbu\App\Result $result
     */
    public function sync(Target $target, Result $result)
    {
        $result->debug('syncing backup');
        $storage = Storage::disk($this->filesystem);

        // if a path is specified make sure the directory exists
        if (!empty($this->path)) {
            $storage->makeDirectory($this->path);
        }
        $storage->getDriver()->writeStream(
            $this->path . '/' . $target->getFilename(),
            fopen($target->getPathname(), 'r+')
        );
    }
}
