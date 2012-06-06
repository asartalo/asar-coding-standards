<?php

/**
 * Ensure multi-line IF conditions are defined correctly.
 */
class Asar_Sniffs_ControlStructures_MultiLineConditionSniff implements PHP_CodeSniffer_Sniff {

  /**
   * Returns an array of tokens this test wants to listen for.
   *
   * @return array
   */
  public function register() {
      return array(T_IF);
  }

  /**
   * Processes this test, when one of its tokens is encountered.
   *
   * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
   * @param int                  $stackPtr  The position of the current token
   *                                        in the stack passed in $tokens.
   *
   * @return void
   */
  public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();

    // We need to work out how far indented the if statement
    // itself is, so we can work out how far to indent conditions.
    $statementIndent = 0;
    for ($i = ($stackPtr - 1); $i >= 0; $i--) {
        if ($tokens[$i]['line'] !== $tokens[$stackPtr]['line']) {
            $i++;
            break;
        }
    }

    if ($i >= 0 && $tokens[$i]['code'] === T_WHITESPACE) {
        $statementIndent = strlen($tokens[$i]['content']);
    }

    // Each line between the parenthesis should be indented 2 spaces
    // and start with an operator, unless the line is inside a
    // function call, in which case it is ignored.
    $openParen  = $tokens[$stackPtr]['parenthesis_opener'];
    $closeParen = $tokens[$stackPtr]['parenthesis_closer'];
    $lastLine     = $tokens[$openParen]['line'];
    for ($i = ($openParen + 1); $i < $closeParen; $i++) {

      if ($tokens[$i]['line'] !== $lastLine) {
        if ($tokens[$i]['line'] === $tokens[$closeParen]['line']) {
          $next = $phpcsFile->findNext(T_WHITESPACE, $i, null, true);
          if ($next !== $closeParen) {
            // Closing bracket is on the same line as a condition.
            $error = 'Closing parenthesis of a multi-line IF statement must be on a new line';
            $phpcsFile->addError($error, $i, 'closeParenNewLine');
            $expectedIndent = ($statementIndent + 2);
          } else {
            // Closing brace needs to be indented to the same level
            // as the function.
            $expectedIndent = $statementIndent;
          }
        } else {
          $expectedIndent = ($statementIndent + 4);
        }

        // We changed lines, so this should be a whitespace indent token.
        if ($tokens[$i]['code'] !== T_WHITESPACE) {
          $foundIndent = 0;
        } else {
          $foundIndent = strlen($tokens[$i]['content']);
        }

        if ($expectedIndent !== $foundIndent) {
          $error = 'Multi-line IF statement not indented correctly; expected %s spaces but found %s';
          $data  = array($expectedIndent,
                         $foundIndent);
          $phpcsFile->addError($error, $i, 'Alignment', $data);
        }

        if ($tokens[$i]['line'] !== $tokens[$openParen]['line']
            && $tokens[$i]['line'] !== $tokens[$closeParen]['line'])
        {
          $next = $phpcsFile->findNext(T_WHITESPACE, $i, null, true);
          if (in_array($tokens[$next]['code'], PHP_CodeSniffer_Tokens::$booleanOperators) === false) {
            $error = 'Each line in a multi-line IF statement must begin with a boolean operator';
            $phpcsFile->addError($error, $i, 'StartWithBoolean');
          }
        }

        $lastLine = $tokens[$i]['line'];
      }

      if ($tokens[$i]['code'] === T_STRING) {
        $next = $phpcsFile->findNext(T_WHITESPACE, ($i + 1), null, true);
        if ($tokens[$next]['code'] === T_OPEN_PARENTHESIS) {
          // This is a function call, so skip to the end as they
          // have their own indentation rules.
          $i        = $tokens[$next]['parenthesis_closer'];
          $lastLine = $tokens[$i]['line'];
          continue;
        }
      }
    }

    // From here on, we are checking the spacing of the opening and closing
    // braces. If this IF statement does not use braces, we end here.
    if (isset($tokens[$stackPtr]['scope_opener']) === false) {
      return;
    }

    // The opening brace needs to be one space away from the closing parenthesis.
    if ($tokens[($closeParen + 1)]['code'] !== T_WHITESPACE) {
      $length = 0;
    } else if ($tokens[($closeParen + 1)]['content'] === $phpcsFile->eolChar) {
      $length = -1;
    } else {
      $length = strlen($tokens[($closeParen + 1)]['content']);
    }

    if ($length !== 1) {
      $data = array($length);
      $code = 'SpaceBeforeOpenBrace';

      $error = 'There must be a single space between the closing parenthesis and the opening brace of a multi-line IF statement; found ';
      if ($length === -1) {
        $error .= 'newline';
        $code   = 'NewlineBeforeOpenBrace';
      } else {
        $error .= '%s spaces';
      }

      $phpcsFile->addError($error, ($closeParen + 1), $code, $data);
    }

    // And just in case they do something funny before the brace...
    $next = $phpcsFile->findNext(T_WHITESPACE, ($closeParen + 1), null, true);
    if ($next !== false && $tokens[$next]['code'] !== T_OPEN_CURLY_BRACKET) {
      $error = 'There must be a single space between the closing parenthesis and the opening brace of a multi-line IF statement';
      $phpcsFile->addError($error, $next, 'NoSpaceBeforeOpenBrace');
    }

  }

}

?>
