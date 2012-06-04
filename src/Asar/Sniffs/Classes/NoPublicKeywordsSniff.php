<?php

/**
 * Ensures there are no public keywords.
 */
class Asar_Sniffs_Classes_NoPublicKeywordsSniff
  extends Squiz_Sniffs_Functions_LowercaseFunctionKeywordsSniff {

  /**
   * Returns an array of tokens this test wants to listen for.
   *
   * @return array
   */
  public function register() {
    return array(T_PUBLIC);
  }


  /**
   * Processes this test, when one of its tokens is encountered.
   *
   * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
   * @param int                  $stackPtr  The position of the current token in
   *                                        the stack passed in $tokens.
   * @return void
   */
  function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();
    $error = "Do not use public visibility label. " .
             "Methods and parameters are public by default";
    $phpcsFile->addError($error, $stackPtr, 'FoundUppercase', $data);
  }


}

?>
