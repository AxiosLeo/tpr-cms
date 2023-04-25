<?php

namespace Gregwar\Captcha;

/**
 * A Captcha builder.
 */
interface CaptchaBuilderInterface
{
    /**
     * Builds the code.
     *
     * @param mixed $width
     * @param mixed $height
     * @param mixed $font
     * @param mixed $fingerprint
     */
    public function build($width, $height, $font, $fingerprint);

    /**
     * Saves the code to a file.
     *
     * @param mixed $filename
     * @param mixed $quality
     */
    public function save($filename, $quality);

    /**
     * Gets the image contents.
     *
     * @param mixed $quality
     */
    public function get($quality);

    /**
     * Outputs the image.
     *
     * @param mixed $quality
     */
    public function output($quality);
}
