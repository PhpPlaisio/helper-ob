<?php
declare(strict_types=1);

namespace Plaisio\Helper;

/**
 * Output buffer
 */
final class OB
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The initial nesting level of the output buffering mechanism.
   *
   * @var int|null
   */
  private $level;

  //--------------------------------------------------------------------------------------------------------------------

  /**
   * Object constructor.
   *
   * This constructor start output buffering (i.e., calls
   * [ob_start()](https://www.php.net/manual/function.ob-start.php)).
   */
  public function __construct()
  {
    $this->level = ob_get_level();
    ob_start();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Ends output buffering to a desired level.
   *
   * @param int $level The desired level.
   */
  public static function endCleanBuffers(int $level = 0): void
  {
    while (ob_get_level()>$level)
    {
      if (!@ob_end_clean())
      {
        ob_clean();
      }
    }

    if ($level===0 and php_sapi_name()!=='cli')
    {
      ob_start();
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object destructor.
   */
  public function __destruct()
  {
    $this->end();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Ends the output buffering.
   */
  public function end(): void
  {
    if ($this->level!==null)
    {
      self::endCleanBuffers($this->level);
      $this->level = null;
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Wrapper around [ob_get_clean()](https://www.php.net/manual/en/function.ob-a-clean.php).
   *
   * Returns the current buffer contents and deletes current output buffer. Essentially executes both getContents() and
   * endClean().
   *
   * @return string
   */
  public function getClean(): string
  {
    if ($this->level!==null)
    {
      $buffer      = ob_get_clean();
      $this->level = null;
    }
    else
    {
      $buffer = '';
    }

    return $buffer;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Wrapper around [ob_get_contents()](https://www.php.net/manual/en/function.ob_get_contents.php).
   *
   * Returns the contents of the output buffer.
   *
   * @return string
   */
  public function getContents(): string
  {
    if ($this->level!==null)
    {
      $buffer = ob_get_contents();
    }
    else
    {
      $buffer = '';
    }

    return $buffer;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Wrapper around [ob_get_length()](https://www.php.net/manual/en/function.ob_get_length.php).
   *
   * Returns the length of the output buffer.
   *
   * @return int
   */
  public function getLength(): int
  {
    if ($this->level!==null)
    {
      $length = ob_get_length();
    }
    else
    {
      $length = 0;
    }

    return $length;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
