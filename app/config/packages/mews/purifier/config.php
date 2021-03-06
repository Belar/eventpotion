<?php

/*
 * This file is part of HTMLPurifier Bundle.
 * (c) 2012 Maxime Dizerens
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return array(
    "settings" => array(
        "default" => array(
            "HTML.SafeObject" => 'true',
            "HTML.SafeIframe" => 'true',
            "URI.SafeIframeRegexp" => "%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/|www.dailymotion.com/embed/video/|binarybeast.com|www.twitch.tv/)%",
        ),
        "titles" => array(
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.Linkify' => false,
        )
    ),
);