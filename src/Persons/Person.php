<?php
namespace Ciebit\Bidding\Persons;

use Ciebit\Bidding\Documents\Document;

interface Person
{
    public function getDocument(): Document;

    public function getId(): string;

    public function getName(): string;
}