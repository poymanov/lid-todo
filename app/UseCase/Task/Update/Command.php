<?php

declare(strict_types=1);

namespace App\UseCase\Task\Update;

class Command
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $description;
}
