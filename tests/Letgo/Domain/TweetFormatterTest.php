<?php

namespace App\Tests\Letgo\Domain;

use PHPUnit\Framework\TestCase;
use App\Letgo\Domain\TweetFormatter;

class TweetFormatterTest extends TestCase
{
    public function testFormat()
    {
        $formatter = new TweetFormatter();

        $this->assertSame('', $formatter->format(''));
        $this->assertSame('', $formatter->format('.'));
        $this->assertSame('', $formatter->format('!'));
        $this->assertSame('A WITTY SAYING PROVES NOTHING!', $formatter->format('A witty saying proves nothing.'));
        $this->assertSame('SCIENCE FOR ME IS VERY CLOSE TO ART. SCIENTIFIC DISCOVERY IS AN IRRATIONAL ACT!', $formatter->format('Science for me is very close to art. Scientific discovery is an irrational act.'));
        $this->assertSame('BIG ANNOUNCEMENT WITH MY FRIEND AMBASSADOR NIKKI HALEY IN THE OVAL OFFICE AT 10:30AM!', $formatter->format('Big announcement with my friend Ambassador Nikki Haley in the Oval Office at 10:30am'));
        $this->assertSame('WILL BE GOING TO IOWA TONIGHT FOR RALLY, AND MORE! THE FARMERS (AND ALL) ARE VERY HAPPY WITH USMCA!', $formatter->format('Will be going to Iowa tonight for Rally, and more! The Farmers (and all) are very happy with USMCA!'));
        $this->assertSame('IT WOULD SEEM TO ME… AN OFFENSE AGAINST NATURE, FOR US TO COME ON THE SAME SCENE ENDOWED AS WE ARE WITH THE CURIOSITY, FILLED TO OVERBRIMMING AS WE ARE WITH QUESTIONS, AND NATURALLY TALENTED AS WE ARE FOR THE ASKING OF CLEAR QUESTIONS, AND THEN FOR US TO DO NOTHING ABOUT, OR WORSE, TO TRY TO SUPPRESS THE QUESTIONS…!', $formatter->format('It would seem to me… an offense against nature, for us to come on the same scene endowed as we are with the curiosity, filled to overbrimming as we are with questions, and naturally talented as we are for the asking of clear questions, and then for us to do nothing about, or worse, to try to suppress the questions…'));
        $this->assertSame('IF WE KNEW WHAT IT WAS WE WERE DOING, IT WOULD NOT BE CALLED RESEARCH, WOULD IT?!', $formatter->format('If we knew what it was we were doing, it would not be called research, would it?'));
    }
}
