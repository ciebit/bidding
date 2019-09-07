<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use Ciebit\Bidding\Publication;
use DateTime;
use PHPUnit\Framework\TestCase;

class PublicationTest extends TestCase
{
    /** @var string */
    private $biddingId = '22';

    /** @var DateTime */
    private $date;

    /** @var string */
    private $description = 'Description';

    /** @var string */
    private $fileId = '333';

    /** @var string */
    private $id = '4444';

    /** @var string */
    private $name = 'Name';

    public function __construct()
    {
        parent::__construct();

        $this->date = new DateTime('2019-09-05');
    }

    public function testCreate(): void
    {
        $publication = new Publication(
            $this->name,
            $this->description,
            $this->date,
            $this->biddingId,
            $this->fileId,
            $this->id
        );

        $this->assertEquals($this->biddingId, $publication->getBiddingId());
        $this->assertEquals($this->date, $publication->getDate());
        $this->assertEquals($this->description, $publication->getDescription());
        $this->assertEquals($this->fileId, $publication->getFileId());
        $this->assertEquals($this->id, $publication->getId());
        $this->assertEquals($this->name, $publication->getName());
    }
}
