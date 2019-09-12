<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Contracts\Tests;

use Ciebit\Bidding\Contracts\Contract;
use Ciebit\Bidding\Year;
use DateTime;
use PHPUnit\Framework\TestCase;

class ContractTest extends TestCase
{
    /** @var string */
    private $biddingId = '22';

    /** @var DateTime */
    private $date;

    /** @var string */
    private $filesId = ['111','222','333'];

    /** @var DateTime */
    private $finalDate;

    /** @var float */
    private $globalPrice = 52682.42;

    /** @var string */
    private $id = '4444';

    /** @var string */
    private $number = '5';

    /** @var string */
    private $objectDescription = 'Object Description';

    /** @var string */
    private $organId = '55555';

    /** @var string */
    private $personId = '29';

    /** @var DateTime */
    private $startDate;

    /** @var Year */
    private $yearOfExercise;

    public function __construct()
    {
        parent::__construct();

        $this->date = new DateTime('2019-09-05');
        $this->startDate = new DateTime('2019-09-06');
        $this->finalDate = new DateTime('2019-09-07');
        $this->yearOfExercise = new Year(2019);
    }

    public function testCreate(): void
    {
        $contract = new Contract(
            $this->biddingId,
            $this->yearOfExercise,
            $this->number,
            $this->date,
            $this->startDate,
            $this->finalDate,
            $this->globalPrice,
            $this->objectDescription,
            $this->organId,
            $this->personId,
            $this->id
        );
        $contract->addFileId(...$this->filesId);

        $this->assertEquals($this->biddingId, $contract->getBiddingId());
        $this->assertEquals($this->date, $contract->getDate());
        $this->assertEquals($this->objectDescription, $contract->getObjectDescription());
        $this->assertEquals($this->filesId, $contract->getFilesId());
        $this->assertEquals($this->id, $contract->getId());
        $this->assertEquals($this->finalDate, $contract->getFinalDate());
        $this->assertEquals($this->globalPrice, $contract->getGlobalPrice());
        $this->assertEquals($this->number, $contract->getNumber());
        $this->assertEquals($this->organId, $contract->getOrganId());
        $this->assertEquals($this->personId, $contract->getPersonId());
        $this->assertEquals($this->startDate, $contract->getStartDate());
        $this->assertEquals($this->yearOfExercise, $contract->getYearOfExercise());
    }
}
