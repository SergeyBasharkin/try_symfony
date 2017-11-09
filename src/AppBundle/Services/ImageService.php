<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 09.11.17
 * Time: 18:46
 */

namespace AppBundle\Services;


class ImageService
{

    public function generateImage(string $text){
        $im = imagecreate(500, 500);
        $background_color = imagecolorallocate($im, 222,222,222 );
        $text_color = imagecolorallocate($im, 233, 14, 91);
        imagestring($im, 200, 200, 100, $text, $text_color);
        imagepng($im, 'img.png');
        return readfile('img.png');
    }
}