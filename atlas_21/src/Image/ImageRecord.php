<?php
declare(strict_types=1);

namespace Image;

use Atlas\Mapper\Record;

/**
 * @method ImageRow getRow()
 */
class ImageRecord extends Record
{
    use ImageFields;
}
