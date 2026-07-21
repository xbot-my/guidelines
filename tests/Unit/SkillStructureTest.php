<?php

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;

beforeEach(function () {
    $this->packageRoot = realpath(__DIR__.'/../../');
});

test('all skill directories have a SKILL.md file', function () {
    $skillDirs = glob($this->packageRoot.'/resources/boost/skills/*', GLOB_ONLYDIR);

    expect($skillDirs)->not->toBeEmpty();

    foreach ($skillDirs as $dir) {
        $skillFile = $dir.'/SKILL.md';
        expect(file_exists($skillFile))
            ->toBeTrue('Missing SKILL.md in '.basename($dir));
    }
});

test('all SKILL.md files have valid frontmatter with name and description', function () {
    $skillDirs = glob($this->packageRoot.'/resources/boost/skills/*', GLOB_ONLYDIR);

    foreach ($skillDirs as $dir) {
        $skillName = basename($dir);
        $content = file_get_contents($dir.'/SKILL.md');
        expect($content)->not->toBeFalse();

        // Strip leading HTML comments
        $stripped = preg_replace('/^(\s*<!--.*?-->\s*)+/s', '', $content);

        // Parse frontmatter between --- markers
        $matched = preg_match('/^---\s*\n(.*?)\n---\s*\n/s', (string) $stripped, $matches);
        expect($matched)
            ->toBe(1, "{$skillName}/SKILL.md has invalid frontmatter (matched: {$matched})");

        $frontmatter = Yaml::parse($matches[1]);
        expect($frontmatter)->toBeArray("{$skillName}/SKILL.md frontmatter is not an array");
        expect($frontmatter)->toHaveKey('name');
        expect($frontmatter)->toHaveKey('description');
        expect($frontmatter['name'])->toBeString()->not->toBeEmpty();
        expect($frontmatter['description'])->toBeString()->not->toBeEmpty();
    }
});

test('guideline core blade file exists', function () {
    expect(file_exists($this->packageRoot.'/resources/boost/guidelines/core.blade.php'))
        ->toBeTrue();
});
