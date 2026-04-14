<?php

declare(strict_types=1);

namespace Togul\Laravel;

use Illuminate\Support\ServiceProvider;
use Togul\Config;
use Togul\FallbackMode;
use Togul\TogulClient;
use Togul\TogulStreamClient;

class TogulStreamService
{
    private ?TogulStreamClient $streamClient = null;
    private ?\Illuminate\Contracts\Queue\ShouldQueue $worker = null;

    public function __construct(
        private readonly TogulClient $client,
    ) {}

    public function start(): void
    {
        if ($this->streamClient !== null) {
            return;
        }

        $this->streamClient = $this->client->stream();

        $this->streamClient->onCacheInvalidated(function (string $flagKey) {
            if ($this->worker !== null) {
                dispatch($this->worker)->onConnection('sync')->onQueue('default');
            }
        });

        $this->streamClient->connect();
    }

    public function stop(): void
    {
        $this->streamClient = null;
    }

    public function setWorker(\Illuminate\Contracts\Queue\ShouldQueue $worker): self
    {
        $this->worker = $worker;
        return $this;
    }
}