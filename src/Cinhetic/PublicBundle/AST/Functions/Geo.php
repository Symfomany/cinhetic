<?php

namespace Cinhetic\PublicBundle\AST\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Lexer;


/**
 * Class Geo
 * @package Cinhetic\PublicBundle\AST\Functions
 */
class Geo extends FunctionNode
{
    /**
     * @var \Doctrine\ORM\Query\AST\ComparisonExpression
     */
    private $latitude;
    /**
     * @var \Doctrine\ORM\Query\AST\ComparisonExpression
     */    
    private $longitude;
    
    /**
     * Parse DQL Function
     * 
     * @param Parser $parser 
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->latitude = $parser->ComparisonExpression();
        $parser->match(Lexer::T_COMMA);
        $this->longitude = $parser->ComparisonExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * Get SQL
     * @param SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf('((ACOS(SIN(%s * PI() / 180) * SIN(%s * PI() / 180) + COS(%s * PI() / 180) * COS(%s * PI() / 180) * COS((%s - %s) * PI() / 180)) * 180 / PI()) * 60 * %s)',
            $this->latitude->rightExpression->dispatch($sqlWalker), 
            $this->latitude->leftExpression->dispatch($sqlWalker), 
            $this->latitude->rightExpression->dispatch($sqlWalker), 
            $this->latitude->leftExpression->dispatch($sqlWalker), 
            $this->longitude->rightExpression->dispatch($sqlWalker), 
            $this->longitude->leftExpression->dispatch($sqlWalker),
            '1.1515 * 1.609344');
    }
}

