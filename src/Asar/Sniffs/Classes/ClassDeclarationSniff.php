<?php
/**
 * Class Declaration Test.
 *
 * Checks the declaration of the class is correct.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006-2011 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 1.3.3
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Asar_Sniffs_Classes_ClassDeclarationSniff implements PHP_CodeSniffer_Sniff {

    /**
     * The number of spaces code should be indented.
     *
     * @var int
     */
    public $indent = 2;


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    function register() {
        return array(
                T_CLASS,
                T_INTERFACE,
               );

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer              $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens    = $phpcsFile->getTokens();
        $errorData = array($tokens[$stackPtr]['content']);

        if (isset($tokens[$stackPtr]['scope_opener']) === false) {
            $error = 'Possible parse error: %s missing opening or closing brace';
            $phpcsFile->addWarning($error, $stackPtr, 'MissingBrace', $errorData);
            return;
        }

        $curlyBrace  = $tokens[$stackPtr]['scope_opener'];
        $lastContent = $phpcsFile->findPrevious(T_WHITESPACE, ($curlyBrace - 1), $stackPtr, true);
        $classLine   = $tokens[$lastContent]['line'];
        $braceLine   = $tokens[$curlyBrace]['line'];
        if ($braceLine !== $classLine) {
            $error = 'Opening brace of a %s must be on the same line as the definition';
            $phpcsFile->addError($error, $curlyBrace, 'OpenBraceWrongLine', $errorData);
            return;
        } else {
            // Checks that the name and the opening brace are
            // separated by a whitespace character.
            if ($tokens[$lastContent+1]['content'] !== ' '
                || $tokens[$lastContent+1]['type'] !== 'T_WHITESPACE')
            {
                $error = 'There must be a space between the class declaration and the opening brace.';
                $phpcsFile->addError($error, $openingBrace, 'SpaceBeforeBrace');
                return;
            }
        }

    }//end process()


}//end class

?>
