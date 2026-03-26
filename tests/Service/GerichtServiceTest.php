<?php

namespace App\Tests\Service;

use App\Entity\Gericht;
use App\Service\GerichtService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GerichtServiceTest extends TestCase
{
    /** @var EntityManagerInterface&MockObject */
    private $entityManager;
    private GerichtService $service;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->service = new GerichtService($this->entityManager, sys_get_temp_dir());
    }

    public function testSaveWithoutImagePersistsEntity(): void
    {
        $gericht = (new Gericht())
            ->setName('Pasta')
            ->setBeschreibung('Fresh pasta')
            ->setPreis(9.9)
            ->setBild('default.jpg');

        $this->entityManager->expects($this->once())->method('persist')->with($gericht);
        $this->entityManager->expects($this->once())->method('flush');

        $saved = $this->service->saveWithImage($gericht, null);

        $this->assertSame($gericht, $saved);
        $this->assertSame('default.jpg', $saved->getBild());
    }
}
