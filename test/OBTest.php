<?php
declare(strict_types=1);

namespace Plaisio\Helper\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\Helper\OB;

/**
 * Test cases for class Password.
 */
class OBTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test destructor restores the level of output buffering.
   */
  public function testDestructor1(): void
  {
    ob_start();
    $level = ob_get_level();

    $this->usage1();

    self::assertSame($level, ob_get_level());

    echo ob_get_clean();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test destructor restores the level of output buffering.
   */
  public function testDestructor2(): void
  {
    ob_start();
    $level = ob_get_level();

    try
    {
      $this->usage2();
    }
    catch (\Exception $exception)
    {
      // Nothing to do.
    }

    self::assertSame($level, ob_get_level());

    echo ob_get_clean();
  }

  //--------------------------------------------------------------------------------------------------------------------
  public function testAll(): void
  {
    $ob = new OB();

    echo 'Hello, World!';

    self::assertSame('Hello, World!', $ob->getContents());
    self::assertSame('Hello, World!', $ob->getContents());
    self::assertSame(13, $ob->getLength());

    self::assertSame('Hello, World!', $ob->getClean());

    echo 'Bye, bye';

    self::assertSame('', $ob->getContents());
    self::assertSame('', $ob->getClean());
    self::assertSame(0, $ob->getLength());

    self::assertSame('Bye, bye', $this->getActualOutput());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Usage 1.
   */
  private function usage1(): void
  {
    $ob = new OB();
    echo 'Hello, World!';
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Usage 2.
   */
  private function usage2(): void
  {
    $ob = new OB();
    echo 'Hello, World!';

    throw new \Exception();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
