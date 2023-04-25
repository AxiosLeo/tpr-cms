<?php

namespace Gregwar\Captcha;

/**
 * Generates random phrase.
 *
 * @author Gregwar <g.passault@gmail.com>
 */
class PhraseBuilder implements PhraseBuilderInterface
{
    /**
     * @var int
     */
    public $length;

    /**
     * @var string
     */
    public $charset;

    /**
     * Constructs a PhraseBuilder with given parameters.
     *
     * @param mixed $length
     * @param mixed $charset
     */
    public function __construct($length = 5, $charset = 'abcdefghijklmnpqrstuvwxyz123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $this->length  = $length;
        $this->charset = $charset;
    }

    /**
     * Generates  random phrase of given length with given charset.
     *
     * @param null|mixed $length
     * @param null|mixed $charset
     */
    public function build($length = null, $charset = null)
    {
        if (null !== $length) {
            $this->length = $length;
        }
        if (null !== $charset) {
            $this->charset = $charset;
        }

        $phrase = '';
        $chars  = str_split($this->charset);

        for ($i = 0; $i < $this->length; ++$i) {
            $phrase .= $chars[array_rand($chars)];
        }

        return $phrase;
    }

    /**
     * "Niceize" a code.
     *
     * @param mixed $str
     */
    public function niceize($str)
    {
        return self::doNiceize($str);
    }

    /**
     * A static helper to niceize.
     *
     * @param mixed $str
     */
    public static function doNiceize($str)
    {
        return strtr(strtolower($str), '01', 'ol');
    }

    /**
     * A static helper to compare.
     *
     * @param mixed $str1
     * @param mixed $str2
     */
    public static function comparePhrases($str1, $str2)
    {
        return self::doNiceize($str1) === self::doNiceize($str2);
    }
}
