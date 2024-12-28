<?php

namespace AthleteWorkouts\Tests;

use WP_Mock\Tools\TestCase as WP_Mock_TestCase;

abstract class TestCase extends WP_Mock_TestCase {
    protected function setUp(): void {
        parent::setUp();
        \WP_Mock::setUp();
    }

    protected function tearDown(): void {
        \WP_Mock::tearDown();
        parent::tearDown();
    }

    protected function assertActionsCalled(): void {
        $this->assertConditionsMet();
    }

    protected function assertFiltersCalled(): void {
        $this->assertConditionsMet();
    }

    protected function mockFunction(string $function, $return = null, int $times = 1): void {
        \WP_Mock::userFunction($function, [
            'times' => $times,
            'return' => $return,
        ]);
    }

    protected function mockAction(string $action, array $args = [], int $times = 1): void {
        \WP_Mock::expectAction($action, ...$args);
    }

    protected function mockFilter(string $filter, $value, array $args = [], int $times = 1): void {
        \WP_Mock::onFilter($filter)
            ->with(...$args)
            ->reply($value);
    }
} 