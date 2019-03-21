<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Alert\Alert;
use Orchid\Tests\TestUnitCase;
use Orchid\Alert\SessionStoreInterface;

/**
 * Class AlertTest.
 */
class AlertTest extends TestUnitCase
{
    /**
     * @var SessionStoreInterface
     */
    protected $store;

    /**
     * @var Alert
     */
    protected $alert;

    protected function setUp(): void
    {
        $this->store = $this->createMock(SessionStoreInterface::class);
        $this->alert = new Alert($this->store);
    }

    /** @test */
    public function testShouldFlashAnInfoAlert()
    {
        $this->store->expects($this->exactly(2))->method('flash')->withConsecutive([
            $this->equalTo('flash_notification.message'),
            $this->equalTo('test'),
        ], [$this->equalTo('flash_notification.level'), $this->equalTo('info')]);

        $this->alert->info('test');
    }

    /** @test */
    public function testShouldFlashSuccessAlert()
    {
        $this->store->expects($this->exactly(2))->method('flash')->withConsecutive([
            $this->equalTo('flash_notification.message'),
            $this->equalTo('test'),
        ], [$this->equalTo('flash_notification.level'), $this->equalTo('success')]);

        $this->alert->success('test');
    }

    /** @test */
    public function testShouldFlashErrorAlert()
    {
        $this->store->expects($this->exactly(2))->method('flash')->withConsecutive([
            $this->equalTo('flash_notification.message'),
            $this->equalTo('test'),
        ], [$this->equalTo('flash_notification.level'), $this->equalTo('danger')]);

        $this->alert->error('test');
    }

    /** @test */
    public function testShouldFlashWarningAlert()
    {
        $this->store->expects($this->exactly(2))->method('flash')->withConsecutive([
            $this->equalTo('flash_notification.message'),
            $this->equalTo('test'),
        ], [$this->equalTo('flash_notification.level'), $this->equalTo('warning')]);

        $this->alert->warning('test');
    }
}
