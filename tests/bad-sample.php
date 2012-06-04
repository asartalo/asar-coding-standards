<?php

namespace Asar\Samples;

use This\One;
use AndThis\OtherOne;

define('some_constant', 'some_value');

CLASS BadSample
{

  private $agenda;

  public $foo;

  function BadSample($foo) {
    $this->foo = $foo;
  }

  public function sayHello($name, $louder=FALSE)
  {
      // BAD: Use only 2 tabs
      $this->internalizeHiddenAgenda();
    // BAD: Using tabs for indentation
		$greeting = "Hello $name!";

    if ($louder)
    {
      $greeting = strtoupper($greeting);
    }
    $this->isAVeryLongLineThatShouldntBeHereButThisIsABadSampleAnyWay = "So dont think too much about it."
    return $greeting;
  }

  /** Bad block comment
   */
  protected function multiLineFunction(
    $var1 = '1',
    $var2,
    $var3 = 'three'
  ) {
    /**
      *
     */
    $arr = array(
      'foo' => 'Foo',
      'bar' => 'Bar'
    );
    $arr[ 'foo' ] = 'what?';
    global $bee;
    self ::internalizeHiddenAgenda();
    for ($i=0; $i < count($arr); $i++) {
      echo("Oh dear");
    }
    throw new Exception('message');
    return true;
  }

  PRIVATE function internalizeHiddenAgenda() {
    // Statements must be on a line by itself
    $this->agenda = "I am here to lose.";$hero = "someone" ;

    // There must be a space after a cast
    (string)$boo;

    // No Call-time pass-by-reference
    strtolower ( &$hero );

    // BAD: Using deprecated functions
    $just_words = split('/ /', 'The quick brown fox');

    if ($fool == true and
        $jhonny == 'Bravo')
    {
      return 'It is okay.';
    }
  }


}

?>