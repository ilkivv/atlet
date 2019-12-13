<?php
namespace morphos\test\Russian;

require __DIR__.'/../../vendor/autoload.php';

use morphos\NumeralGenerator;
use morphos\Russian\Cases;
use morphos\Russian\OrdinalNumeralGenerator;

class OrdinalNumeralTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider numbersProvider
     */
    public function testGetCases($number, $gender, $case, $case2, $case3, $case4, $case5, $case6)
    {
        $this->assertEquals(array(
            Cases::IMENIT => $case,
            Cases::RODIT => $case2,
            Cases::DAT => $case3,
            Cases::VINIT => $case4,
            Cases::TVORIT => $case5,
            Cases::PREDLOJ => $case6,
        ), OrdinalNumeralGenerator::getCases($number, $gender));
    }

    public function numbersProvider()
    {
        return array(
            array(1, NumeralGenerator::MALE, 'первый', 'первого', 'первому', 'первый', 'первым', 'первом'),
            array(1, NumeralGenerator::FEMALE, 'первая', 'первой', 'первой', 'первую', 'первой', 'первой'),
            array(3, NumeralGenerator::MALE, 'третий', 'третьего', 'третьему', 'третьего', 'третьим', 'третьем'),
            array(13, NumeralGenerator::MALE, 'тринадцатый', 'тринадцатого', 'тринадцатому', 'тринадцатый', 'тринадцатым', 'тринадцатом'),
            array(20, NumeralGenerator::NEUTER, 'двадцатое', 'двадцатого', 'двадцатому', 'двадцатое', 'двадцатым', 'двадцатом'),
            array(113, NumeralGenerator::MALE, 'сто тринадцатый', 'сто тринадцатого', 'сто тринадцатому', 'сто тринадцатый', 'сто тринадцатым', 'сто тринадцатом'),
            array(201, NumeralGenerator::MALE, 'двести первый', 'двести первого', 'двести первому', 'двести первый', 'двести первым', 'двести первом'),
            array(344, NumeralGenerator::MALE, 'триста сорок четвертый', 'триста сорок четвертого', 'триста сорок четвертому', 'триста сорок четвертый', 'триста сорок четвертым', 'триста сорок четвертом'),
            array(1007, NumeralGenerator::MALE, 'тысяча седьмой', 'тысяча седьмого', 'тысяча седьмому', 'тысяча седьмой', 'тысяча седьмым', 'тысяча седьмом'),
            array(1013, NumeralGenerator::MALE, 'тысяча тринадцатый', 'тысяча тринадцатого', 'тысяча тринадцатому', 'тысяча тринадцатый', 'тысяча тринадцатым', 'тысяча тринадцатом'),
            array(3651, NumeralGenerator::MALE, 'три тысячи шестьсот пятьдесят первый', 'три тысячи шестьсот пятьдесят первого', 'три тысячи шестьсот пятьдесят первому', 'три тысячи шестьсот пятьдесят первый', 'три тысячи шестьсот пятьдесят первым', 'три тысячи шестьсот пятьдесят первом'),
            array(9999, NumeralGenerator::MALE, 'девять тысяч девятьсот девяносто девятый', 'девять тысяч девятьсот девяносто девятого', 'девять тысяч девятьсот девяносто девятому', 'девять тысяч девятьсот девяносто девятый', 'девять тысяч девятьсот девяносто девятым', 'девять тысяч девятьсот девяносто девятом'),
            array(27013, NumeralGenerator::MALE, 'двадцать семь тысяч тринадцатый', 'двадцать семь тысяч тринадцатого', 'двадцать семь тысяч тринадцатому', 'двадцать семь тысяч тринадцатый', 'двадцать семь тысяч тринадцатым', 'двадцать семь тысяч тринадцатом'),
            array(1234567890, NumeralGenerator::MALE,
                'один миллиард двести тридцать четыре миллиона пятьсот шестьдесят семь тысяч восемьсот девяностый',
                'один миллиард двести тридцать четыре миллиона пятьсот шестьдесят семь тысяч восемьсот девяностого',
                'один миллиард двести тридцать четыре миллиона пятьсот шестьдесят семь тысяч восемьсот девяностому',
                'один миллиард двести тридцать четыре миллиона пятьсот шестьдесят семь тысяч восемьсот девяностый',
                'один миллиард двести тридцать четыре миллиона пятьсот шестьдесят семь тысяч восемьсот девяностым',
                'один миллиард двести тридцать четыре миллиона пятьсот шестьдесят семь тысяч восемьсот девяностом',
            ),
            array(1000, NumeralGenerator::MALE, 'тысячный', 'тысячного', 'тысячному', 'тысячный', 'тысячным', 'тысячном'),
            array(1000000000, NumeralGenerator::MALE, 'миллиардный', 'миллиардного', 'миллиардному', 'миллиардный', 'миллиардным', 'миллиардном'),
            array(1000000090, NumeralGenerator::MALE, 'миллиард девяностый', 'миллиард девяностого', 'миллиард девяностому', 'миллиард девяностый', 'миллиард девяностым', 'миллиард девяностом'),
        );
    }

    /**
     * @dataProvider numbersProvider()
     */
    public function testGetCase($number, $gender, $case, $case2)
    {
        $this->assertEquals($case2, OrdinalNumeralGenerator::getCase($number, Cases::RODIT, $gender));
    }
}