<?php

declare(strict_types=1);

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Event;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use XBot\Guidelines\GuidelinesServiceProvider;

beforeEach(function () {
    $this->originalBasePath = base_path();
    $this->input = Mockery::mock(InputInterface::class);
    $this->output = Mockery::mock(OutputInterface::class);
});

test('service provider registers an event listener for CommandStarting', function () {
    $provider = new GuidelinesServiceProvider($this->app);
    $provider->register();

    expect(Event::hasListeners(CommandStarting::class))->toBeTrue();
});

test('boost commands trigger base path override to package root', function () {
    $packageRoot = realpath(__DIR__.'/../../src/..');
    $provider = new GuidelinesServiceProvider($this->app);
    $provider->register();

    event(new CommandStarting(
        command: 'boost:list-skills',
        input: $this->input,
        output: $this->output,
    ));

    expect(base_path())->toBe($packageRoot);
});

test('non-boost commands do not change base path', function () {
    $original = $this->originalBasePath;
    $provider = new GuidelinesServiceProvider($this->app);
    $provider->register();

    event(new CommandStarting(
        command: 'migrate',
        input: $this->input,
        output: $this->output,
    ));

    expect(base_path())->toBe($original);
});
