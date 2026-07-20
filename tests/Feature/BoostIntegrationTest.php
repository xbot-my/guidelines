<?php

declare(strict_types=1);

use Laravel\Boost\Install\GuidelineAssist;
use Laravel\Boost\Install\GuidelineConfig;
use Laravel\Roster\Roster;

/**
 * Verify Boost infrastructure integration.
 *
 * Boost's shouldRun() returns false in unit test environments,
 * so we test the discovery layer directly via its classes.
 */

beforeEach(function () {
    $this->packageRoot = realpath(__DIR__.'/../../');
    $this->roster = Roster::scan($this->packageRoot);
    $this->config = new GuidelineConfig;
});

test('roster can scan the package root and discover packages', function () {
    $packages = $this->roster->packages();

    expect($packages)->not->toBeEmpty();
});

test('guideline assist can be instantiated with package root roster', function () {
    $assist = new GuidelineAssist($this->roster, $this->config);

    expect($assist)->toBeInstanceOf(GuidelineAssist::class);
});

test('skill resource directories exist for all three xbot skills', function () {
    $skills = [
        'xbot-laravel-php',
        'xbot-security',
        'xbot-version-control',
    ];

    foreach ($skills as $skill) {
        $path = $this->packageRoot.'/resources/boost/skills/'.$skill;

        expect(is_dir($path))
            ->toBeTrue("resources/boost/skills/{$skill} directory not found");
        expect(file_exists($path.'/SKILL.md'))
            ->toBeTrue("resources/boost/skills/{$skill}/SKILL.md not found");
    }
});

test('guideline core blade references all three xbot skills', function () {
    $corePath = $this->packageRoot.'/resources/boost/guidelines/core.blade.php';

    expect(file_exists($corePath))->toBeTrue();

    $content = file_get_contents($corePath);
    expect($content)->toContain('xbot-laravel-php');
    expect($content)->toContain('xbot-version-control');
    expect($content)->toContain('xbot-security');
});
