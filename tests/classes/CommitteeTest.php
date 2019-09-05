<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use Ciebit\Bidding\Committee;
use DateTime;
use PHPUnit\Framework\TestCase;

class CommitteeTest extends TestCase
{
    /** @var DateTime */
    private $dateCreation;
    
    /** @var string */
    private $externalId = '22';

    /** @var string */
    private $id = '4444';
    
    /** @var string */
    private $managerId = '333';
    
    /** @var array */
    private $membersId = [1,2,3,4];

    /** @var string */
    private $name = 'Name';

    public function __construct()
    {
        parent::__construct();

        $this->dateCreation = new DateTime('2019-09-05');
    }

    public function testCreate(): void
    {
        $comittee = new Committee(
            $this->name,
            $this->dateCreation,
            $this->externalId,
            $this->managerId,
            $this->membersId,
            $this->id
        );

        $this->assertEquals($this->dateCreation, $comittee->getDateCreation());
        $this->assertEquals($this->externalId, $comittee->getExternalId());
        $this->assertEquals($this->id, $comittee->getId());
        $this->assertEquals($this->managerId, $comittee->getManagerId());
        $this->assertEquals($this->membersId, $comittee->getMembersId());
        $this->assertEquals($this->name, $comittee->getName());
    }
}
