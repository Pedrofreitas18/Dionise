<?php
namespace Test\Model\Entity\Establishment;

use \Exception;
use PHPUnit\Framework\TestCase;
use App\Model\Entity\Establishment\Establishment;
use App\Model\DBConnection\Database;

use PHPUnit\Framework\MockObject\MockBuilder;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery;
use PDOStatement;

use \App\Utils\DataValidator;

class EstablishmentTest extends TestCase {
    
    //default atributes values 
    const ID             = 1;
    const NAME           = "Dionise";
    const INTROIMAGELINK = "https://alphaconvites.com.br/wp-content/uploads/2023/01/festa-antes-formatura-scaled-1.jpg";
    const DESCRIPTION    = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed varius nulla malesuada sem consequat tristique.";

    private function generateTestObject($id = self::ID, $name = self::NAME, $introImage = self::INTROIMAGELINK, $description = self::DESCRIPTION) { 
        return new Establishment($id, $name, $introImage, $description); 
    }

    private function generateTestArray($rowCont = 12, $id = self::ID, $name = self::NAME, $introImage = self::INTROIMAGELINK, $description = self::DESCRIPTION) {   
        $baseArray = ["ID" => $id, "name" => $name, "introImage" => $introImage, "description" => $description];
        return array_map(
            function($item) use (&$sequency) { $item['ID'] = $sequency++; return $item; }, 
            array_fill(0, $rowCont, $baseArray)
        );
    }

    private function generateTestObjectArray($size = 12, $id = self::ID, $name = self::NAME, $introImage = self::INTROIMAGELINK, $description = self::DESCRIPTION) {   
        $baseObject = $this->generateTestObject($id, $name, $introImage, $description);
        return array_map(
            function($item) use (&$sequency) { $item->setId($sequency++); return $item; }, 
            array_fill(0, $size, $baseObject)
        );
    }

    public function tearDown(): void {
        Mockery::close();
    }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function testGetId()             { $this->assertTrue(condition: $this->generateTestObject()->getId()             == self::ID); }
    public function testGetName()           { $this->assertTrue(condition: $this->generateTestObject()->getName()           == self::NAME); }
    public function testGetIntroImageLink() { $this->assertTrue(condition: $this->generateTestObject()->getIntroImageLink() == self::INTROIMAGELINK); }
    public function testGetDescription()    { $this->assertTrue(condition: $this->generateTestObject()->getDescription()    == self::DESCRIPTION); }

    public function testSetId($testParam = 42) {
        $establishment = $this->generateTestObject();
        $establishment->setId($testParam);
        $this->assertTrue(condition: $establishment->getId() == $testParam);
    }

    public function testSetName($testParam = "Hércules") {
        $establishment = $this->generateTestObject();
        $establishment->setName($testParam);
        $this->assertTrue(condition: $establishment->getName() == $testParam);
    } 

    public function testSetIntroImageLink($testParam = "https://linktest.com.br/wp-content.jpg") {
        $establishment = $this->generateTestObject();
        $establishment->setIntroImageLink($testParam);
        $this->assertTrue(condition: $establishment->getIntroImageLink() == $testParam);
    }

    public function testSetDescription($testParam = "consectetur adipiscing elit.") {
        $establishment = $this->generateTestObject();
        $establishment->setDescription($testParam);
        $this->assertTrue(condition: $establishment->getDescription() == $testParam);
    }

//Read_________________________________________________________________________________________________________________________________________________________________

    public function testGetTodaysHighlights($testParam = 1) {
        $arraySize = 12;

        $stmtMock = Mockery::mock('PDOStatement');
        $stmtMock->shouldReceive('rowCount')->andReturn($arraySize);
        $stmtMock->shouldReceive('fetchAll')->andReturn($this->generateTestArray($arraySize));

        $databaseMock = Mockery::mock('overload:App\Model\DBConnection\Database');
        $databaseMock->shouldReceive('runQuery')->andReturn($stmtMock);
  
        $result = Establishment::getTodaysHighlights($testParam);

        $this->assertTrue(DataValidator::isValidObjectArray($result, Establishment::class));
        $this->assertEquals($arraySize, count($result));
    }

    public function testGetById($testParam = 1) {
        $arraySize = 1;

        $stmtMock = Mockery::mock('PDOStatement');
        $stmtMock->shouldReceive('rowCount')->andReturn($arraySize);
        $stmtMock->shouldReceive('fetchAll')->andReturn($this->generateTestArray($arraySize));

        $databaseMock = Mockery::mock('overload:App\Model\DBConnection\Database');
        $databaseMock->shouldReceive('runQuery')->andReturn($stmtMock);

        $result = Establishment::getById($testParam);
        
        $this->assertTrue(DataValidator::isValidObjectArray($result, Establishment::class));
        $this->assertEquals($arraySize, count($result));
    }

    public function testGetNumberOfEstablishments1() {
        //Cenario 1
        $establishmentsCount = 12;
        
        $stmtMock = Mockery::mock('PDOStatement');
        $stmtMock->shouldReceive('rowCount')->andReturn(1);
        $stmtMock->shouldReceive('fetchAll')->andReturn([['count' => $establishmentsCount]]);

        $databaseMock = Mockery::mock('overload:App\Model\DBConnection\Database');
        $databaseMock->shouldReceive('runQuery')->andReturn($stmtMock);

        $result = Establishment::getNumberOfEstablishments();

        $this->assertTrue($establishmentsCount == $result);
    }

    public function testGetNumberOfEstablishments2() {
        //Cenario 2
        $stmtMock = Mockery::mock('PDOStatement');
        $stmtMock->shouldReceive('rowCount')->andReturn(0); //RETURN != 1

        $databaseMock = Mockery::mock('overload:App\Model\DBConnection\Database');
        $databaseMock->shouldReceive('runQuery')->andReturn($stmtMock);

        $result = Establishment::getNumberOfEstablishments();

        $this->assertNull($result);
    }

    public function testStmtToEstablishments1() {
        //Cenario 1
        $stmtMock = Mockery::mock('PDOStatement');
        $stmtMock->shouldReceive('rowCount')->andReturn(0);
      
        $result = Establishment::stmtToEstablishments( $stmtMock);

        $this->assertEquals([], $result);
    }

    public function testStmtToEstablishments2() {
        //Cenario 2
        $arraySize = 12;

        $stmtMock = Mockery::mock('PDOStatement');
        $stmtMock->shouldReceive('rowCount')->andReturn($arraySize);
        $stmtMock->shouldReceive('fetchAll')->andReturn($this->generateTestArray($arraySize));
      
        $result = Establishment::stmtToEstablishments($stmtMock);

        $this->assertTrue(DataValidator::isValidObjectArray($result, Establishment::class));
        $this->assertEquals($arraySize, count($result));
    }

}