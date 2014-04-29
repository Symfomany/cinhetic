<?php

namespace Cinhetic\PublicBundle\AST\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Lexer;


/**
 * Class DateFormat
 * @package Cinhetic\PublicBundle\AST\Functions
 */
class DateFormat extends FunctionNode {

    /*
     * holds the timestamp of the DATE_FORMAT DQL statement
     * @var mixed
     */

    protected $dateExpression;

    /**
     * holds the '%format' parameter of the DATE_FORMAT DQL statement
     * @var string
     */
    protected $formatChar;

    /**
     * getSql - allows ORM to inject a DATE_FORMAT() statement into an SQL string being constructed
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @return void
     */
    public function getSql(SqlWalker $sqlWalker) {
        return sprintf('DATE_FORMAT(%s, %s)',
                $this->dateExpression->dispatch($sqlWalker),
                $this->formatChar->dispatch($sqlWalker));
    }

    /**
     * parse - allows DQL to breakdown the DQL string into a processable structure
     * @param \Doctrine\ORM\Query\Parser $parser
     */
    public function parse(Parser $parser) {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->dateExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->formatChar = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

}