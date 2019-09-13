<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use Ciebit\Bidding\Bidding;
use Ciebit\Bidding\Modality;
use Ciebit\Bidding\Place;
use Ciebit\Bidding\Status;
use Ciebit\Bidding\Type;
use Ciebit\Bidding\Year;
use DateTime;
use PHPUnit\Framework\TestCase;

class BiddingTest extends TestCase
{
    /** @var string */
    public const COMITTEE_ID = '2';

    /** @var float */
    public const ESTIMATED_BUDGET_AMOUNT = 5985.50;

    /** @var array */
    public const FILES_ID = ['22', '33'];

    /** @var string */
    public const ID = '1';

    /** @var Modality */
    private $modality;

    /** @var DateTime */
    private $noticePublicationDate;

    /** @var string */
    public const NUMBER = '111';

    /** @var string */
    public const OBJECT_DESCRIPTION = 'Object Description';

    /** @var DateTime */
    private $openingDateTime;

    /** @var array */
    public const ORGAINS_ID = ['4444', '5555'];

    /** @var string */
    public const PERSON_ORDERED_ID = '111111';

    /** @var string */
    public const RESPONSIBLE_INFORMATION_ID = '222222';

    /** @var string */
    public const RESPONSIBLE_LEGAL_ADVICE_ID= '333333';

    /** @var string */
    public const RESPONSIBLE_AWARD_ID = '444444';

    /** @var string */
    public const RESPONSIBLE_APPROVAL_ID = '555555';

    /** @var Status */
    private $status;

    /** @var Type */
    private $type;

    /** @var float */
    public const UPPER_LIMIT_VALUE = 7500.50;

    /** @var Year */
    private $yearOfExercise;


    public function __construct()
    {
        parent::__construct();

        $this->modality = Modality::PUBLIC_COMPETITION();
        $this->noticePublicationDate = new DateTime('2019-08-20');
        $this->openingDateTime = new DateTime('2019-08-30');
        $this->openingPlace = new Place('Name', 'Address', '123', 'Neighborhood', 'Complement', 'City', 'Country', 12345000);
        $this->status = Status::OPEN();
        $this->type = Type::LOWEST_PRICE();
        $this->yearOfExercise = new Year(2019);
    }
    
    public function testCreate(): void
    {
        $bidding = new Bidding(
            $this->yearOfExercise,
            $this->modality,
            $this->type,
            self::NUMBER,
            self::COMITTEE_ID,
            self::ESTIMATED_BUDGET_AMOUNT,
            self::UPPER_LIMIT_VALUE,
            self::OBJECT_DESCRIPTION,
            self::ORGAINS_ID,
            $this->openingDateTime,
            $this->openingPlace,
            $this->noticePublicationDate,
            self::PERSON_ORDERED_ID,
            self::RESPONSIBLE_INFORMATION_ID,
            self::RESPONSIBLE_LEGAL_ADVICE_ID,
            self::RESPONSIBLE_AWARD_ID,
            self::RESPONSIBLE_APPROVAL_ID,
            $this->status,
            self::ID
        );

        $this->assertEquals(self::COMITTEE_ID, $bidding->getCommitteeId());
        $this->assertEquals(self::ESTIMATED_BUDGET_AMOUNT, $bidding->getEstimatedBudgetAmount());
        $this->assertEquals(self::ID, $bidding->getId());
        $this->assertEquals(self::OBJECT_DESCRIPTION, $bidding->getObjectDescription());
        $this->assertEquals($this->openingDateTime, $bidding->getOpeningDateTime());
        $this->assertEquals($this->openingPlace, $bidding->getOpeningPlace());
        $this->assertEquals(self::ORGAINS_ID, $bidding->getOrgainsId());
        $this->assertEquals($this->modality, $bidding->getModality());
        $this->assertEquals($this->noticePublicationDate, $bidding->getNoticePublicationDate());
        $this->assertEquals(self::NUMBER, $bidding->getNumber());
        $this->assertEquals(self::RESPONSIBLE_APPROVAL_ID, $bidding->getResponsibleApprovalId());
        $this->assertEquals(self::RESPONSIBLE_AWARD_ID, $bidding->getResponsibleAwardId());
        $this->assertEquals(self::RESPONSIBLE_INFORMATION_ID, $bidding->getResponsibleInformationId());
        $this->assertEquals(self::RESPONSIBLE_LEGAL_ADVICE_ID, $bidding->getResponsibleLegalAdviceId());
        $this->assertEquals(self::PERSON_ORDERED_ID, $bidding->getPersonOrderedId());
        $this->assertEquals($this->type, $bidding->getType());
        $this->assertEquals($this->status, $bidding->getStatus());
        $this->assertEquals(self::UPPER_LIMIT_VALUE, $bidding->getUpperLimitValue());
        $this->assertEquals($this->yearOfExercise, $bidding->getYearOfExercise());
    }
}
