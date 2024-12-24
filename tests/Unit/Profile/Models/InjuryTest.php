<?php

namespace Tests\Unit\Profile\Models;

use PHPUnit\Framework\TestCase;
use AthleteDashboard\Features\Profile\Models\Injury;

class InjuryTest extends TestCase
{
    protected $injury;

    protected function setUp(): void
    {
        parent::setUp();
        $this->injury = new Injury();
    }

    public function testCreateFromArraySetsProperties()
    {
        $data = [
            'id' => 1,
            'label' => 'Knee Pain',
            'type' => 'Chronic',
            'description' => 'Recurring knee pain during squats',
            'updated_at' => '2024-01-20'
        ];

        $injury = Injury::createFromArray($data);

        $this->assertEquals(1, $injury->getId());
        $this->assertEquals('Knee Pain', $injury->getLabel());
        $this->assertEquals('Chronic', $injury->getType());
        $this->assertEquals('Recurring knee pain during squats', $injury->getDescription());
        $this->assertEquals('2024-01-20', $injury->getUpdatedAt());
    }

    public function testToArrayReturnsExpectedArray()
    {
        $this->injury->setId(1);
        $this->injury->setLabel('Knee Pain');
        $this->injury->setType('Chronic');
        $this->injury->setDescription('Recurring knee pain during squats');
        $this->injury->setUpdatedAt('2024-01-20');

        $expected = [
            'id' => 1,
            'label' => 'Knee Pain',
            'type' => 'Chronic',
            'description' => 'Recurring knee pain during squats',
            'updated_at' => '2024-01-20'
        ];

        $this->assertEquals($expected, $this->injury->toArray());
    }

    public function testSettersAndGettersWorkCorrectly()
    {
        $this->injury->setId(1);
        $this->injury->setLabel('Knee Pain');
        $this->injury->setType('Chronic');
        $this->injury->setDescription('Recurring knee pain during squats');
        $this->injury->setUpdatedAt('2024-01-20');

        $this->assertEquals(1, $this->injury->getId());
        $this->assertEquals('Knee Pain', $this->injury->getLabel());
        $this->assertEquals('Chronic', $this->injury->getType());
        $this->assertEquals('Recurring knee pain during squats', $this->injury->getDescription());
        $this->assertEquals('2024-01-20', $this->injury->getUpdatedAt());
    }

    public function testCreateFromArrayHandlesInvalidData()
    {
        $data = [
            'invalid_field' => 'value'
        ];

        $injury = Injury::createFromArray($data);

        $this->assertNull($injury->getId());
        $this->assertNull($injury->getLabel());
        $this->assertNull($injury->getType());
        $this->assertNull($injury->getDescription());
        $this->assertNull($injury->getUpdatedAt());
    }

    public function testToArrayHandlesNullValues()
    {
        $expected = [
            'id' => null,
            'label' => null,
            'type' => null,
            'description' => null,
            'updated_at' => null
        ];

        $this->assertEquals($expected, $this->injury->toArray());
    }
} 