<?php

namespace AppBundle\Share\Network;

use AppBundle\Share\ShareableInterface\Shareable;

class XingShareNetwork extends AbstractShareNetwork
{
    protected $name = 'XING';

    protected $icon = 'fa-xing';

    protected $backgroundColor = 'rgb(1, 101, 104)';

    protected $textColor = 'white';

    protected $openSharewindow = true;

    public function createUrlForShareable(Shareable $shareable): string
    {
        $xingShareUrl = 'https://www.xing.com/social_plugins/share?&url=%s';

        return sprintf($xingShareUrl, urlencode($this->getShareUrl($shareable)));
    }
}
