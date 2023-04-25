<?php

namespace Gregwar\Captcha;

/**
 * Interface for the PhraseBuilder.
 *
 * @author Gregwar <g.passault@gmail.com>
 */
interface PhraseBuilderInterface
{
    /**
     * Generates  random phrase of given length with given charset.
     */
    public function build();

    /**
     * "Niceize" a code.
     *
     * @param mixed $str
     */
    public function niceize($str);
}
