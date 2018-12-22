<?php

namespace App\Tests\Utils;

use App\Letgo\Utils\TextFormatter;
use PHPUnit\Framework\TestCase;

class TextFormatterTest extends TestCase
{
    public function testFormat()
    {
        $this->assertSame('', TextFormatter::format(''));
        $this->assertSame('', TextFormatter::format('.'));
        $this->assertSame('', TextFormatter::format('!'));
        $this->assertSame('A WITTY SAYING PROVES NOTHING!', TextFormatter::format('A witty saying proves nothing.'));
        $this->assertSame('SCIENCE FOR ME IS VERY CLOSE TO ART. SCIENTIFIC DISCOVERY IS AN IRRATIONAL ACT!', TextFormatter::format('Science for me is very close to art. Scientific discovery is an irrational act.'));
        $this->assertSame('BIG ANNOUNCEMENT WITH MY FRIEND AMBASSADOR NIKKI HALEY IN THE OVAL OFFICE AT 10:30AM!', TextFormatter::format('Big announcement with my friend Ambassador Nikki Haley in the Oval Office at 10:30am'));
        $this->assertSame('WILL BE GOING TO IOWA TONIGHT FOR RALLY, AND MORE! THE FARMERS (AND ALL) ARE VERY HAPPY WITH USMCA!', TextFormatter::format('Will be going to Iowa tonight for Rally, and more! The Farmers (and all) are very happy with USMCA!'));

    }
}
