<?php

declare(strict_types=1);

namespace Orchid\Attachment;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Attachment\Contracts\Engine;
use Orchid\Attachment\Engines\Generator;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Events\ReplicateFileEvent;
use Orchid\Platform\Events\UploadFileEvent;

/**
 * Class File.
 */
class File
{
    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var Filesystem
     */
    protected $storage;

    /**
     * @var string
     */
    protected $disk;

    /**
     * @var string|null
     */
    protected $group;

    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var bool
     */
    protected $duplicate = false;

    /**
     * File constructor.
     *
     * @param UploadedFile $file
     * @param string|null  $disk
     * @param string|null  $group
     */
    public function __construct(UploadedFile $file, string $disk = null, string $group = null)
    {
        abort_if($file->getSize() === false, 415, 'File failed to load.');

        $this->file = $file;
        $this->disk = $disk ?? config('platform.attachment.disk', 'public');
        $this->storage = Storage::disk($this->disk);

        /** @var string $generator */
        $generator = config('platform.attachment.generator', Generator::class);

        $this->engine = new $generator($file);
        $this->group = $group;
    }

    /**
     * @throws \League\Flysystem\FilesystemException
     *
     * @return Model|Attachment
     */
    public function load(): Model
    {
        $attachment = $this->getMatchesHash();

        if ($attachment === null) {
            return $this->save();
        }

        $attachment = $attachment->replicate()->fill([
            'original_name' => $this->file->getClientOriginalName(),
            'sort'          => 0,
            'user_id'       => Auth::id(),
            'group'         => $this->group,
        ]);

        $attachment->save();

        event(new ReplicateFileEvent($attachment, $this->engine->time()));

        return $attachment;
    }

    /**
     * @param bool $status
     *
     * @return File
     */
    public function allowDuplicates(bool $status = true): self
    {
        $this->duplicate = $status;

        return $this;
    }

    /**
     * @return Attachment|null
     */
    private function getMatchesHash()
    {
        if ($this->duplicate) {
            return null;
        }

        return Dashboard::model(Attachment::class)::where('hash', $this->engine->hash())
            ->where('disk', $this->disk)
            ->first();
    }

    /**
     * @return Model|Attachment
     */
    private function save(): Model
    {
        $this->storage->putFileAs($this->engine->path(), $this->file, $this->engine->fullName(), [
            'mime_type' => $this->engine->mime(),
        ]);

        $attachment = Dashboard::model(Attachment::class)::create([
            'name'          => $this->engine->name(),
            'mime'          => $this->engine->mime(),
            'hash'          => $this->engine->hash(),
            'extension'     => $this->engine->extension(),
            'original_name' => $this->file->getClientOriginalName(),
            'size'          => $this->file->getSize(),
            'path'          => Str::finish($this->engine->path(), '/'),
            'disk'          => $this->disk,
            'group'         => $this->group,
            'user_id'       => Auth::id(),
        ]);

        event(new UploadFileEvent($attachment, $this->engine->time()));

        return $attachment;
    }

    /**
     * set a custom Path
     *
     * @return File
     */
    public function path(?string $path = null)
    {
        $this->engine->setPath($path);

        return $this;
    }
}
