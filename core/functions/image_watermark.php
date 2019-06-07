<?php
	/*******************************************************************\
	* Snippet Name	: image_watermark									*
	* Purpose		: watermark											*
	* Access		: 													*
	\*******************************************************************/

$log->LogInfo('Got this file');


class image_watermark{

    function create_watermark( $dst_img, $watermark_img, $alpha = 100 ) {
        $alpha    /= 100;    # convert 0-100% user-friendly alpha to decimal

        # calculate our images dimensions
        $dst_img_w    = imagesx( $dst_img );
        $dst_img_h    = imagesy( $dst_img );
        $watermark_img_w    = imagesx( $watermark_img );
        $watermark_img_h    = imagesy( $watermark_img );

        # create new image to hold merged changes
        $return_img    = imagecreatetruecolor( $dst_img_w, $dst_img_h );
#        $return_img    = imagecreate( $dst_img_w, $dst_img_h );

        # determine center position coordinates
        $dst_img_min_x    = floor( ( $dst_img_w / 2 ) - ( $watermark_img_w / 2 ) );
        $dst_img_max_x    = ceil( ( $dst_img_w / 2 ) + ( $watermark_img_w / 2 ) );
        $dst_img_min_y    = floor( ( $dst_img_h / 2 ) - ( $watermark_img_h / 2 ) );
        $dst_img_max_y    = ceil( ( $dst_img_h / 2 ) + ( $watermark_img_h / 2 ) );

        # walk through main image
        for( $y = 0; $y < $dst_img_h; $y++ ) {
            for( $x = 0; $x < $dst_img_w; $x++ ) {
                $return_color    = NULL;

                # determine the correct pixel location within our watermark
                $watermark_x    = $x - $dst_img_min_x;
                $watermark_y    = $y - $dst_img_min_y;

                # fetch color information for both of our images
                $dst_rgb = imagecolorsforindex( $dst_img, imagecolorat( $dst_img, $x, $y ) );

                # if our watermark has a non-transparent value at this pixel intersection
                # and we're still within the bounds of the watermark image
                if (    $watermark_x >= 0 && $watermark_x < $watermark_img_w &&
                            $watermark_y >= 0 && $watermark_y < $watermark_img_h ) {
                    $watermark_rbg = imagecolorsforindex( $watermark_img, imagecolorat( $watermark_img, $watermark_x, $watermark_y ) );

                    # using image alpha, and user specified alpha, calculate average
                    $watermark_alpha    = round( ( ( 127 - $watermark_rbg['alpha'] ) / 127 ), 2 );
                    $watermark_alpha    = $watermark_alpha * $alpha;

                    # calculate the color 'average' between the two - taking into account the specified alpha level
                    $avg_red        = $this->get_ave_color( $dst_rgb['red'],        $watermark_rbg['red'],        $watermark_alpha );
                    $avg_green    = $this->get_ave_color( $dst_rgb['green'],    $watermark_rbg['green'],    $watermark_alpha );
                    $avg_blue        = $this->get_ave_color( $dst_rgb['blue'],    $watermark_rbg['blue'],        $watermark_alpha );

                    # calculate a color index value using the average RGB values we've determined
                    $return_color    = $this->imagegetcolor( $return_img, $avg_red, $avg_green, $avg_blue );

                # if we're not dealing with an average color here, then let's just copy over the main color
                } else {
                    $return_color    = imagecolorat( $dst_img, $x, $y );

                } # END if watermark

                # draw the appropriate color onto the return image
                imagesetpixel( $return_img, $x, $y, $return_color );

            } # END for each X pixel
        } # END for each Y pixel

        # return the resulting, watermarked image for display
        return $return_img;

    } # END create_watermark()

    # average two colors given an alpha
    function get_ave_color( $color_a, $color_b, $alpha ) {
        return round( ( ( $color_a * ( 1 - $alpha ) ) + ( $color_b    * $alpha ) ) );
    } # END get_ave_color()

    # return closest pallette-color match for RGB values
    function imagegetcolor($im, $r, $g, $b) {
        $c=imagecolorexact($im, $r, $g, $b);
        if ($c!=-1) return $c;
        $c=imagecolorallocate($im, $r, $g, $b);
        if ($c!=-1) return $c;
        return imagecolorclosest($im, $r, $g, $b);
    } # EBD imagegetcolor()

} # END watermark API
?>