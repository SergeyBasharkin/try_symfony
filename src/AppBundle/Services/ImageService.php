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
        $im = imagecreate(900, 500);
        imagecolorallocate($im, 222,222,222 );
        $text_color = imagecolorallocate($im, 233, 14, 91);
        imagestring($im, 200, 15, 15, $text, $text_color);
        imagepng($im, 'img.png');
        return readfile('img.png');
    }
}