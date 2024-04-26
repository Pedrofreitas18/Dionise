<?php
namespace Test\Model\Entity\Establishment;

use \Exception;
use PHPUnit\Framework\TestCase;
use App\Model\Entity\Establishment\Establishment;

class EstablishmentTest extends TestCase {
    private $id = 1;
    private $name = "Dionise";
    private $introImageLink = "https://alphaconvites.com.br/wp-content/uploads/2023/01/festa-antes-formatura-scaled-1.jpg";
    private $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed varius nulla malesuada sem consequat tristique. Mauris malesuada finibus ligula, ac viverra nibh. Nam risus sapien, aliquet nec posuere ut, ultricies faucibus lorem.";

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________
    public function testGetId() { 
        $establishment = new Establishment($this->id, $this->name, $this->introImageLink, $this->description);
        $this->assertTrue(condition: $establishment->getId() == $this->id);
    }

    public function testGetName() { 
        $establishment = new Establishment($this->id, $this->name, $this->introImageLink, $this->description);
        $this->assertTrue(condition: $establishment->getName() == $this->name);
    }

    public function testGetIntroImageLink() { 
        $establishment = new Establishment($this->id, $this->name, $this->introImageLink, $this->description);
        $this->assertTrue(condition: $establishment->getIntroImageLink() == $this->introImageLink);
    }

    public function testGetDescription() { 
        $establishment = new Establishment($this->id, $this->name, $this->introImageLink, $this->description);
        $this->assertTrue(condition: $establishment->getDescription() == $this->description);
    }

    public function testSetId($testParam = 42) {
        $establishment = new Establishment($this->id, $this->name, $this->introImageLink, $this->description);
        $establishment->setId($testParam);
        $this->assertTrue(condition: $establishment->getId() == $testParam);
    }

    public function testSetName($testParam = "Hércules") {
        $establishment = new Establishment($this->id, $this->name, $this->introImageLink, $this->description);
        $establishment->setName($testParam);
        $this->assertTrue(condition: $establishment->getName() == $testParam);
    }

    public function testSetIntroImageLink($testParam = "https://blog.sympla.com.br/wp-content/uploads/2022/06/como-organizar-uma-festa-show-1024x630-1-1-1-1-1-2.jpg") {
        $establishment = new Establishment($this->id, $this->name, $this->introImageLink, $this->description);
        $establishment->setIntroImageLink($testParam);
        $this->assertTrue(condition: $establishment->getIntroImageLink() == $testParam);
    }

    public function testSetDescription($testParam = "consectetur adipiscing elit. Sed varius nulla malesuada sem consequat tristique. Mauris malesuada finibus ligula, ac viverra nibh. Nam risus sapien, aliquet nec posuere ut, ultricies faucibus lorem. Vivamus sed velit condimentu") {
        $establishment = new Establishment($this->id, $this->name, $this->introImageLink, $this->description);
        $establishment->setDescription($testParam);
        $this->assertTrue(condition: $establishment->getDescription() == $testParam);
    }

//Read_________________________________________________________________________________________________________________________________________________________________

}