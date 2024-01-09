<?php

namespace App\Contracts;

interface AffiliateLinkGeneratorInterface
{
    /**
     * Generate a unique affiliate code.
     *
     * @param int $length Amount of characters in code
     * @return string
     */
    public function generate(int $length = 10): string;
}
