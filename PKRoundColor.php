<?php
/**
 * Projekod Interactive
 * http://projekod.com
 */


class PKRoundColor {

    protected $baseColors = array(
        "964b00",   //Brown
        "000000",   //Black
        "403d3f",   //smoked (Turkish : Füme )
        "808080",   //Gray
        "f5f5dc",   //Beige (Turkish : Bej )
        "ffffff",   //White
        "ffcbdb",   //Pink
        "ff00ff",   //Fuchsia (Turkish : Fuşya )
        "9370db",   //Purple
        "b03060",   //Claret Red (Turkish : Bize her yer trabzon! )
        "0000ff",   //Blue
        "40e0d0",   //Turquoise
        "00ff00",   //Green
        "ffff00",   //Yellow
        "ff7f00",   //Orange
        "ff0000"   //Red
    );

    public function getBaseColors(){
        return $this->baseColors;
    }

    public function addBaseColor($color){
        if($this->checkHexColor($color)){
            $this->baseColors[] = $color;
            array_unique($this->baseColors);
        }
    }

    public function setBaseColors($baseColors){
        $this->baseColors = array();
        foreach($baseColors as $baseColor) {
            $this->addBaseColor($baseColor);
        }
    }

    public function getRoundedColor($color){
        if($this->checkHexColor($color)){
            $rgbColor = $this->hex2rgb($color,true);
            $part = explode(",",$rgbColor);
            $redColor = $part[0];
            $greenColor = $part[1];
            $blueColor = $part[2];

            $distinction = array();

            $index = 0;
            foreach($this->baseColors as $baseColor){
                $baseColor = strtoupper($baseColor);
                $baseRgbColor = $this->hex2rgb($baseColor,true);
                $basePart = explode(",",$baseRgbColor);


                $baseRedColor = $basePart[0];
                $baseGreenColor = $basePart[1];
                $baseBlueColor = $basePart[2];

                $sqrt =sqrt(($redColor-$baseRedColor)*($redColor-$baseRedColor) +
                    ($greenColor-$baseGreenColor) * ($greenColor - $baseGreenColor) +
                    ($blueColor-$baseBlueColor) * ($blueColor - $baseBlueColor));

                $distinction["$sqrt"] = $index;
                $index++;

            }
            $minValue = min(array_keys($distinction));
            $index = $distinction[$minValue];
            return '#'.$this->baseColors[$index];
        }
    }

    public function checkHexColor($color){
        return preg_match('/^#[a-f0-9]{6}$/i', $color);
    }

    public function hex2rgb($hexVal,$implode=false) {
        $hexVal = str_replace("#", "", $hexVal);

        if(strlen($hexVal) == 3) {  //Like #000
            $red = hexdec(substr($hexVal,0,1).substr($hexVal,0,1));
            $green = hexdec(substr($hexVal,1,1).substr($hexVal,1,1));
            $blue = hexdec(substr($hexVal,2,1).substr($hexVal,2,1));
        } else {
            $red = hexdec(substr($hexVal,0,2));
            $green = hexdec(substr($hexVal,2,2));
            $blue = hexdec(substr($hexVal,4,2));
        }
        $rgb = array($red, $green, $blue);
        if($implode){
            return implode(",", $rgb);
        }
        return $rgb;
    }
}
