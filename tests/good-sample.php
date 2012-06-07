<?php

namespace Asar\Samples;

use This\One,
    AndThis\OtherOne;

define('SOME_CONSTANT', 'some_value');

/**
 * A Good Sample Class
 *
 * A conforming class file must have a class-level documentation at least and a
 * brief description of what it is about and what it does. The lines should at
 * most be 80 characters wide.
 *
 * The opening bracket at the start of the class should be at the same line as
 * the class name.
 */
class GoodSample {

  /**
   * Attributes must have a description
   */
  private $agenda;

  /**
   * @param string $foo Some variable.
   */
  function __construct($foo) {
    $this->foo = $foo;
  }

  /**
   * This method is documented
   *
   * As all other methods must be. This also includes all parameters and its
   * return type if any.
   *
   * If a method is public, no need to add visibility label. Methods are public
   * by default. No need to say it.
   *
   * @param string $name The name to greet
   * @param boolean $louder Wether to greet in more emphasis
   * @return string The greeting
   */
  function sayHello($name, $louder=false) {
    $this->internalizeHiddenAgenda();
    $greeting = "Hello $name!";

    // control clauses have their opening brackets on the same line
    if ($louder) {
      $greeting = strtoupper($greeting);
    }
    return $greeting;
  }

  /**
   * This is another method
   *
   * @param integer $var1 Some parameter
   * @param string $var2 Another parameter
   * @param string $var3 Another parameter
   * @throws Exception An exception message
   * @return boolean Always true
   */
  protected function multiLineFunction(
    $var1,
    $var2='2',
    $var3='three'
  ) {
    // One-line comment
    $arr = array(
      'foo' => 'Foo',
      'bar' => 'Bar'
    );
    $arr['foo'] = 'what?';
    self::internalizeHiddenAgenda();
    $arrCount = count($arr);
    for ($i=0; $i < $arrCount; $i++) {
      echo "Oh dear";
    }
    throw new Exception('message');
    return true;
  }

  /**
   * This is a private method
   *
   * We must add a visibility label here of course
   *
   * @return string some greeting
   */
  private function internalizeHiddenAgenda() {
    $this->agenda = "I am here to win.";
    $hero = "someone";
    // There must be a space after a cast
    (string) $boo;

    strtolower($hero);

    $justWords = preg_split('/ /', 'The quick brown fox');

    if ($fool == true
        && $jhonny == 'Bravo'
    ) {
      return 'It is okay.';
    }
  }


}