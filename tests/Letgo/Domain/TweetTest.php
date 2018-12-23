<?php

namespace App\Letgo\Tests\Domain;

use PHPUnit\Framework\TestCase;
use App\Letgo\Domain\Tweet;

class TweetTest extends TestCase
{
    public function testFormat()
    {
        $this->assertSame('A WITTY SAYING PROVES NOTHING!', (new Tweet('A witty saying proves nothing.'))->getText());
        $this->assertSame('SCIENCE FOR ME IS VERY CLOSE TO ART. SCIENTIFIC DISCOVERY IS AN IRRATIONAL ACT!', (new Tweet('Science for me is very close to art. Scientific discovery is an irrational act.'))->getText());
        $this->assertSame('WILL BE GOING TO IOWA TONIGHT FOR RALLY, AND MORE! THE FARMERS (AND ALL) ARE VERY HAPPY WITH USMCA!', (new Tweet('Will be going to Iowa tonight for Rally, and more! The Farmers (and all) are very happy with USMCA!'))->getText());
    }
}
