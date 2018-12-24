<?php

namespace App\Letgo\Tests\Domain;

use PHPUnit\Framework\TestCase;
use App\Letgo\Domain\Tweet;

class TweetTest extends TestCase
{
    public function testFormat()
    {
        $this->assertSame('A witty saying proves nothing.', (new Tweet('A witty saying proves nothing.'))->getText());
        $this->assertSame('Science for me is very close to art. Scientific discovery is an irrational act.', (new Tweet('Science for me is very close to art. Scientific discovery is an irrational act.'))->getText());
        $this->assertSame('Will be going to Iowa tonight for Rally, and more! The Farmers (and all) are very happy with USMCA!', (new Tweet('Will be going to Iowa tonight for Rally, and more! The Farmers (and all) are very happy with USMCA!'))->getText());
    }
}
