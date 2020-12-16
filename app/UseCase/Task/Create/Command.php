<?php

declare(strict_types=1);

namespace App\UseCase\Task\Create;

class Command
{
    /**
     * @var int
     */
    public int $userId;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $description;
}
