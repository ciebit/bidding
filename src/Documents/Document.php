<?php
namespace Ciebit\Bidding\Documents;

interface Document
{
    public function getFormat(): string;

    public function getValue(): string;
}
