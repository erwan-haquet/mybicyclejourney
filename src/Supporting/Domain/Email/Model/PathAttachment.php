<?php

namespace App\Supporting\Domain\Email\Model;

class PathAttachment
{
    private string $path;
    private string $name;
    private string $contentType;

    public function __construct(string $path, string $name, string $contentType)
    {
        $this->path = $path;
        $this->name = $name;
        $this->contentType = $contentType;
    }

    /**
     * Name of the file, including extension.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Path of the file on the filesystem.
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Content type.
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }
}
