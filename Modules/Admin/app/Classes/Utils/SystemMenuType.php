<?php

namespace Modules\Admin\Classes\Utils;

class SystemMenuType
{
    /** 菜单组 */
    const GROUP = 'G';

    /** 菜单 */
    const MENU = 'M';

    /** 操作 */
    const ACTION = 'A';

    /** 链接，新标签打开 */
    const LINK = 'L';

    /** iframe，在内部打开 */
    const IFRAME = 'I';

    public function __construct() {}
}
