<?php
/**
 * Copyright (C) 2015 David Young
 * 
 * Tests the string tokenizer
 */
namespace RDev\Console\Requests\Tokenizers;

class StringTokenizerTest extends \PHPUnit_Framework_TestCase
{
    /** @var StringTokenizer The tokenizer to use in tests */
    private $tokenizer = null;

    /**
     * Sets up the tests
     */
    public function setUp()
    {
        $this->tokenizer = new StringTokenizer();
    }

    /**
     * Tests tokenizing an argument and option with space around it
     */
    public function testTokenizingArgumentAndOptionWithSpaceAroundIt()
    {
        $tokens = $this->tokenizer->tokenize("foo ' dave ' --last=' young '");
        $this->assertEquals([
            "foo",
            "' dave '",
            "--last=' young '"
        ], $tokens);
    }

    /**
     * Tests tokenizing a double quote inside single quotes
     */
    public function testTokenizingDoubleQuoteInsideSingleQuotes()
    {
        $tokens = $this->tokenizer->tokenize("foo '\"foo bar\"' --quote '\"Dave is cool\"'");
        $this->assertEquals([
            "foo",
            '\'"foo bar"\'',
            "--quote",
            '\'"Dave is cool"\'',
        ], $tokens);
    }

    /**
     * Tests tokenizing option value with space in it
     */
    public function testTokenizingOptionValueWithSpace()
    {
        $tokens = $this->tokenizer->tokenize("foo --name 'dave young'");
        $this->assertEquals([
            "foo",
            "--name",
            "'dave young'"
        ], $tokens);
    }

    /**
     * Tests tokenizing a single quote inside double quotes
     */
    public function testTokenizingSingleQuoteInsideDoubleQuotes()
    {
        $tokens = $this->tokenizer->tokenize("foo \"'foo bar'\" --quote \"'Dave is cool'\"");
        $this->assertEquals([
            "foo",
            "\"'foo bar'\"",
            "--quote",
            "\"'Dave is cool'\""
        ], $tokens);
    }

    /**
     * Tests tokenizing an unclosed double quote
     */
    public function testTokenizingUnclosedDoubleQuote()
    {
        $this->setExpectedException("\\RuntimeException");
        $this->tokenizer->tokenize('foo "blah');
    }

    /**
     * Tests tokenizing an unclosed single quote
     */
    public function testTokenizingUnclosedSingleQuote()
    {
        $this->setExpectedException("\\RuntimeException");
        $this->tokenizer->tokenize("foo 'blah");
    }

    /**
     * Tests tokenizing with extra spaces between tokens
     */
    public function testTokenizingWithExtraSpacesBetweenTokens()
    {
        $tokens = $this->tokenizer->tokenize(" foo   bar  --name='dave   young'  -r ");
        $this->assertEquals([
            "foo",
            "bar",
            "--name='dave   young'",
            "-r"
        ], $tokens);
    }
}