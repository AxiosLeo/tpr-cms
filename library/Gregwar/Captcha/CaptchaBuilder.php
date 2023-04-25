<?php

namespace Gregwar\Captcha;

/**
 * Builds a new captcha image
 * Uses the fingerprint parameter, if one is passed, to generate the same image.
 *
 * @author Gregwar <g.passault@gmail.com>
 * @author Jeremy Livingston <jeremy.j.livingston@gmail.com>
 */
class CaptchaBuilder implements CaptchaBuilderInterface
{
    /**
     * Temporary dir, for OCR check.
     */
    public string $tempDir = 'temp/';

    protected array $fingerprint = [];

    protected bool $useFingerprint = false;

    protected array $textColor = [];

    protected ?array $lineColor = null;

    protected ?array $backgroundColor = null;

    protected array $backgroundImages = [];

    /**
     * @var resource
     */
    protected $contents;

    protected ?string $phrase = null;

    /**
     * @var PhraseBuilderInterface
     */
    protected $builder;

    protected bool $distortion = true;

    /**
     * The maximum number of lines to draw in front of
     * the image. null - use default algorithm.
     */
    protected ?int $maxFrontLines = null;

    /**
     * The maximum number of lines to draw behind
     * the image. null - use default algorithm.
     */
    protected ?int $maxBehindLines = null;

    /**
     * The maximum angle of char.
     */
    protected int $maxAngle = 8;

    /**
     * The maximum offset of char.
     */
    protected int $maxOffset = 5;

    /**
     * Is the interpolation enabled ?
     */
    protected bool $interpolation = true;

    /**
     * Ignore all effects.
     */
    protected bool $ignoreAllEffects = false;

    /**
     * Allowed image types for the background images.
     */
    protected array $allowedBackgroundImageTypes = ['image/png', 'image/jpeg', 'image/gif'];

    public function __construct($phrase = null, PhraseBuilderInterface $builder = null)
    {
        if (null === $builder) {
            $this->builder = new PhraseBuilder();
        } else {
            $this->builder = $builder;
        }

        $this->phrase = \is_string($phrase) ? $phrase : $this->builder->build($phrase);
    }

    /**
     * The image contents.
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Enable/Disables the interpolation.
     *
     * @param $interpolate bool  True to enable, false to disable
     */
    public function setInterpolation(bool $interpolate = true): self
    {
        $this->interpolation = $interpolate;

        return $this;
    }

    /**
     * Setting the phrase.
     *
     * @param mixed $phrase
     */
    public function setPhrase($phrase)
    {
        $this->phrase = (string) $phrase;
    }

    /**
     * Enables/disable distortion.
     *
     * @param mixed $distortion
     */
    public function setDistortion($distortion): self
    {
        $this->distortion = (bool) $distortion;

        return $this;
    }

    public function setMaxBehindLines($maxBehindLines): self
    {
        $this->maxBehindLines = $maxBehindLines;

        return $this;
    }

    public function setMaxFrontLines($maxFrontLines): self
    {
        $this->maxFrontLines = $maxFrontLines;

        return $this;
    }

    public function setMaxAngle($maxAngle): self
    {
        $this->maxAngle = $maxAngle;

        return $this;
    }

    public function setMaxOffset($maxOffset): self
    {
        $this->maxOffset = $maxOffset;

        return $this;
    }

    /**
     * Gets the captcha phrase.
     */
    public function getPhrase(): ?string
    {
        return $this->phrase;
    }

    /**
     * Returns true if the given phrase is good.
     *
     * @param mixed $phrase
     */
    public function testPhrase($phrase): bool
    {
        return $this->builder->niceize($phrase) == $this->builder->niceize($this->getPhrase());
    }

    /**
     * Instantiation.
     *
     * @param null|mixed $phrase
     */
    public static function create($phrase = null): self
    {
        return new self($phrase);
    }

    /**
     * Sets the text color to use.
     *
     * @param mixed $r
     * @param mixed $g
     * @param mixed $b
     */
    public function setTextColor($r, $g, $b): self
    {
        $this->textColor = [$r, $g, $b];

        return $this;
    }

    /**
     * Sets the background color to use.
     *
     * @param mixed $r
     * @param mixed $g
     * @param mixed $b
     */
    public function setBackgroundColor($r, $g, $b): self
    {
        $this->backgroundColor = [$r, $g, $b];

        return $this;
    }

    public function setLineColor($r, $g, $b): self
    {
        $this->lineColor = [$r, $g, $b];

        return $this;
    }

    /**
     * Sets the ignoreAllEffects value.
     */
    public function setIgnoreAllEffects(bool $ignoreAllEffects): self
    {
        $this->ignoreAllEffects = $ignoreAllEffects;

        return $this;
    }

    /**
     * Sets the list of background images to use (one image is randomly selected).
     */
    public function setBackgroundImages(array $backgroundImages): self
    {
        $this->backgroundImages = $backgroundImages;

        return $this;
    }

    /**
     * Try to read the code against an OCR.
     */
    public function isOCRReadable(): bool
    {
        if (!is_dir($this->tempDir)) {
            @mkdir($this->tempDir, 0755, true);
        }

        $tempj = $this->tempDir . uniqid('captcha', true) . '.jpg';
        $tempp = $this->tempDir . uniqid('captcha', true) . '.pgm';

        $this->save($tempj);
        shell_exec("convert {$tempj} {$tempp}");
        $value = trim(strtolower(shell_exec("ocrad {$tempp}")));

        @unlink($tempj);
        @unlink($tempp);

        return $this->testPhrase($value);
    }

    /**
     * Builds while the code is readable against an OCR.
     *
     * @param mixed      $width
     * @param mixed      $height
     * @param null|mixed $font
     * @param null|mixed $fingerprint
     */
    public function buildAgainstOCR($width = 150, $height = 40, $font = null, $fingerprint = null)
    {
        do {
            $this->build($width, $height, $font, $fingerprint);
        } while ($this->isOCRReadable());
    }

    /**
     * Generate the image.
     *
     * @param mixed      $width
     * @param mixed      $height
     * @param null|mixed $font
     * @param null|mixed $fingerprint
     */
    public function build($width = 150, $height = 40, $font = null, $fingerprint = null): self
    {
        if (null !== $fingerprint) {
            $this->fingerprint    = $fingerprint;
            $this->useFingerprint = true;
        } else {
            $this->fingerprint    = [];
            $this->useFingerprint = false;
        }

        if (null === $font) {
            $font = __DIR__ . '/Font/captcha' . $this->rand(0, 5) . '.ttf';
        }

        if (empty($this->backgroundImages)) {
            // if background images list is not set, use a color fill as a background
            $image = imagecreatetruecolor($width, $height);
            if (null == $this->backgroundColor) {
                $bg = imagecolorallocate($image, $this->rand(200, 255), $this->rand(200, 255), $this->rand(200, 255));
            } else {
                $color = $this->backgroundColor;
                $bg    = imagecolorallocate($image, $color[0], $color[1], $color[2]);
            }
            //            $this->background = $bg || 0;
            imagefill($image, 0, 0, $bg);
        } else {
            // use a random background image
            $randomBackgroundImage = $this->backgroundImages[rand(0, \count($this->backgroundImages) - 1)];

            $imageType = $this->validateBackgroundImage($randomBackgroundImage);

            $image = $this->createBackgroundImageFromType($randomBackgroundImage, $imageType);
        }

        // Apply effects
        if (!$this->ignoreAllEffects) {
            $square  = $width * $height;
            $effects = $this->rand($square / 3000, $square / 2000);

            // set the maximum number of lines to draw in front of the text
            if (null != $this->maxBehindLines && $this->maxBehindLines > 0) {
                $effects = min($this->maxBehindLines, $effects);
            }

            if (0 !== $this->maxBehindLines) {
                for ($e = 0; $e < $effects; ++$e) {
                    $this->drawLine($image, $width, $height);
                }
            }
        }

        // Write CAPTCHA text
        $color = $this->writePhrase($image, $this->phrase, $font, $width, $height);

        // Apply effects
        if (!$this->ignoreAllEffects) {
            $square  = $width * $height;
            $effects = $this->rand($square / 3000, $square / 2000);

            // set the maximum number of lines to draw in front of the text
            if (null != $this->maxFrontLines && $this->maxFrontLines > 0) {
                $effects = min($this->maxFrontLines, $effects);
            }

            if (0 !== $this->maxFrontLines) {
                for ($e = 0; $e < $effects; ++$e) {
                    $this->drawLine($image, $width, $height, $color);
                }
            }
        }

        // Distort the image
        if ($this->distortion && !$this->ignoreAllEffects) {
            $image = $this->distort($image, $width, $height, $bg);
        }

        // Post effects
        if (!$this->ignoreAllEffects) {
            $this->postEffect($image);
        }

        $this->contents = $image;

        return $this;
    }

    /**
     * Distorts the image.
     *
     * @param mixed $image
     * @param mixed $width
     * @param mixed $height
     * @param mixed $bg
     */
    public function distort($image, $width, $height, $bg)
    {
        $contents = imagecreatetruecolor($width, $height);
        $X        = $this->rand(0, $width);
        $Y        = $this->rand(0, $height);
        $phase    = $this->rand(0, 10);
        $scale    = 1.1 + $this->rand(0, 10000) / 30000;
        for ($x = 0; $x < $width; ++$x) {
            for ($y = 0; $y < $height; ++$y) {
                $Vx = $x - $X;
                $Vy = $y - $Y;
                $Vn = sqrt($Vx * $Vx + $Vy * $Vy);

                if (0 != $Vn) {
                    $Vn2 = $Vn + 4 * sin($Vn / 30);
                    $nX  = $X  + ($Vx * $Vn2 / $Vn);
                    $nY  = $Y  + ($Vy * $Vn2 / $Vn);
                } else {
                    $nX = $X;
                    $nY = $Y;
                }
                $nY = $nY + $scale * sin($phase + $nX * 0.2);

                if ($this->interpolation) {
                    $p = $this->interpolate(
                        $nX - floor($nX),
                        $nY - floor($nY),
                        $this->getCol($image, floor($nX), floor($nY), $bg),
                        $this->getCol($image, ceil($nX), floor($nY), $bg),
                        $this->getCol($image, floor($nX), ceil($nY), $bg),
                        $this->getCol($image, ceil($nX), ceil($nY), $bg)
                    );
                } else {
                    $p = $this->getCol($image, round($nX), round($nY), $bg);
                }

                if (0 == $p) {
                    $p = $bg;
                }

                imagesetpixel($contents, $x, $y, $p);
            }
        }

        return $contents;
    }

    /**
     * Saves the Captcha to a jpeg file.
     *
     * @param mixed $filename
     * @param mixed $quality
     */
    public function save($filename, $quality = 90)
    {
        imagejpeg($this->contents, $filename, $quality);
    }

    /**
     * Gets the image GD.
     */
    public function getGd()
    {
        return $this->contents;
    }

    /**
     * Gets the image contents.
     *
     * @param mixed $quality
     */
    public function get($quality = 90)
    {
        ob_start();
        $this->output($quality);

        return ob_get_clean();
    }

    /**
     * Gets the HTML inline base64.
     *
     * @param mixed $quality
     */
    public function inline($quality = 90): string
    {
        return 'data:image/jpeg;base64,' . base64_encode($this->get($quality));
    }

    /**
     * Outputs the image.
     *
     * @param mixed $quality
     */
    public function output($quality = 90)
    {
        imagejpeg($this->contents, null, $quality);
    }

    public function getFingerprint(): array
    {
        return $this->fingerprint;
    }

    /**
     * Draw lines over the image.
     *
     * @param mixed      $image
     * @param mixed      $width
     * @param mixed      $height
     * @param null|mixed $tcol
     */
    protected function drawLine($image, $width, $height, $tcol = null)
    {
        if (null === $this->lineColor) {
            $red   = $this->rand(100, 255);
            $green = $this->rand(100, 255);
            $blue  = $this->rand(100, 255);
        } else {
            $red   = $this->lineColor[0];
            $green = $this->lineColor[1];
            $blue  = $this->lineColor[2];
        }

        if (null === $tcol) {
            $tcol = imagecolorallocate($image, $red, $green, $blue);
        }

        if ($this->rand(0, 1)) { // Horizontal
            $Xa = $this->rand(0, $width / 2);
            $Ya = $this->rand(0, $height);
            $Xb = $this->rand($width / 2, $width);
            $Yb = $this->rand(0, $height);
        } else { // Vertical
            $Xa = $this->rand(0, $width);
            $Ya = $this->rand(0, $height / 2);
            $Xb = $this->rand(0, $width);
            $Yb = $this->rand($height / 2, $height);
        }
        imagesetthickness($image, $this->rand(1, 3));
        imageline($image, $Xa, $Ya, $Xb, $Yb, $tcol);
    }

    /**
     * Apply some post effects.
     *
     * @param mixed $image
     */
    protected function postEffect($image)
    {
        if (!\function_exists('imagefilter')) {
            return;
        }

        if (null != $this->backgroundColor || null != $this->textColor) {
            return;
        }

        // Negate ?
        if (0 == $this->rand(0, 1)) {
            imagefilter($image, \IMG_FILTER_NEGATE);
        }

        // Edge ?
        if (0 == $this->rand(0, 10)) {
            imagefilter($image, \IMG_FILTER_EDGEDETECT);
        }

        // Contrast
        imagefilter($image, \IMG_FILTER_CONTRAST, $this->rand(-50, 10));

        // Colorize
        if (0 == $this->rand(0, 5)) {
            imagefilter($image, \IMG_FILTER_COLORIZE, $this->rand(-80, 50), $this->rand(-80, 50), $this->rand(-80, 50));
        }
    }

    /**
     * Writes the phrase on the image.
     *
     * @param mixed $image
     * @param mixed $phrase
     * @param mixed $font
     * @param mixed $width
     * @param mixed $height
     */
    protected function writePhrase($image, $phrase, $font, $width, $height)
    {
        $length = mb_strlen($phrase);
        if (0 === $length) {
            return imagecolorallocate($image, 0, 0, 0);
        }

        // Gets the text size and start position
        $size       = $width / $length - $this->rand(0, 3) - 1;
        $box        = imagettfbbox($size, 0, $font, $phrase);
        $textWidth  = $box[2] - $box[0];
        $textHeight = $box[1] - $box[7];
        $x          = ($width - $textWidth)   / 2;
        $y          = ($height - $textHeight) / 2 + $size;

        if (!$this->textColor) {
            $textColor = [$this->rand(0, 150), $this->rand(0, 150), $this->rand(0, 150)];
        } else {
            $textColor = $this->textColor;
        }
        $col = imagecolorallocate($image, $textColor[0], $textColor[1], $textColor[2]);

        // Write the letters one by one, with random angle
        for ($i = 0; $i < $length; ++$i) {
            $symbol = mb_substr($phrase, $i, 1);
            $box    = imagettfbbox($size, 0, $font, $symbol);
            $w      = $box[2] - $box[0];
            $angle  = $this->rand(-$this->maxAngle, $this->maxAngle);
            $offset = $this->rand(-$this->maxOffset, $this->maxOffset);
            // halt($image, $size, $angle, $x, $y + $offset, $col, $font, $symbol);
            imagettftext($image, $size, $angle, (int) $x, (int) ($y + $offset), $col, $font, $symbol);
            $x += $w;
        }

        return $col;
    }

    /**
     * Returns a random number or the next number in the
     * fingerprint.
     *
     * @param mixed $min
     * @param mixed $max
     */
    protected function rand($min, $max)
    {
        if (!\is_array($this->fingerprint)) {
            $this->fingerprint = [];
        }

        if ($this->useFingerprint) {
            $value = current($this->fingerprint);
            next($this->fingerprint);
        } else {
            $value               = mt_rand($min, $max);
            $this->fingerprint[] = $value;
        }

        return $value;
    }

    /**
     * @return int
     */
    protected function interpolate($x, $y, $nw, $ne, $sw, $se)
    {
        list($r0, $g0, $b0) = $this->getRGB($nw);
        list($r1, $g1, $b1) = $this->getRGB($ne);
        list($r2, $g2, $b2) = $this->getRGB($sw);
        list($r3, $g3, $b3) = $this->getRGB($se);

        $cx = 1.0 - $x;
        $cy = 1.0 - $y;

        $m0 = $cx * $r0 + $x * $r1;
        $m1 = $cx * $r2 + $x * $r3;
        $r  = (int) ($cy * $m0 + $y * $m1);

        $m0 = $cx * $g0 + $x * $g1;
        $m1 = $cx * $g2 + $x * $g3;
        $g  = (int) ($cy * $m0 + $y * $m1);

        $m0 = $cx * $b0 + $x * $b1;
        $m1 = $cx * $b2 + $x * $b3;
        $b  = (int) ($cy * $m0 + $y * $m1);

        return ($r << 16) | ($g << 8) | $b;
    }

    /**
     * @param mixed $background
     *
     * @return int
     */
    protected function getCol($image, $x, $y, $background)
    {
        $L = imagesx($image);
        $H = imagesy($image);
        if ($x < 0 || $x >= $L || $y < 0 || $y >= $H) {
            return $background;
        }

        return imagecolorat($image, $x, $y);
    }

    /**
     * @return array
     */
    protected function getRGB($col)
    {
        return [
            (int) ($col >> 16) & 0xFF,
            (int) ($col >> 8)  & 0xFF,
            (int) ($col)       & 0xFF,
        ];
    }

    /**
     * Validate the background image path. Return the image type if valid.
     *
     * @param string $backgroundImage
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function validateBackgroundImage($backgroundImage)
    {
        // check if file exists
        if (!file_exists($backgroundImage)) {
            $backgroundImageExploded = explode('/', $backgroundImage);
            $imageFileName           = \count($backgroundImageExploded) > 1 ? $backgroundImageExploded[\count($backgroundImageExploded) - 1] : $backgroundImage;

            throw new \Exception('Invalid background image: ' . $imageFileName);
        }

        // check image type
        $finfo     = finfo_open(\FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $imageType = finfo_file($finfo, $backgroundImage);
        finfo_close($finfo);

        if (!\in_array($imageType, $this->allowedBackgroundImageTypes)) {
            throw new \Exception('Invalid background image type! Allowed types are: ' . implode(', ', $this->allowedBackgroundImageTypes));
        }

        return $imageType;
    }

    /**
     * Create background image from type.
     *
     * @return resource
     *
     * @throws \Exception
     */
    protected function createBackgroundImageFromType(string $backgroundImage, string $imageType)
    {
        switch ($imageType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($backgroundImage);

                break;

            case 'image/png':
                $image = imagecreatefrompng($backgroundImage);

                break;

            case 'image/gif':
                $image = imagecreatefromgif($backgroundImage);

                break;

            default:
                throw new \Exception('Not supported file type for background image!');

                break;
        }

        return $image;
    }
}
