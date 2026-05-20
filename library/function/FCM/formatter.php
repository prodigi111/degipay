<?php

function formatter($datas)
{
    if (isset($datas) && is_array($datas)) {
        $print = [];
        // $print = ["0"];
        foreach ($datas as $item) {
            if ($item['type'] == "text") {
                $data = (new FormatData($item))->text();
                if ($data) {
                    array_push($print, $data);
                }
            } else if ($item['type'] == "image") {
                $data = (new FormatData($item))->image();
                if ($data) {
                    array_push($print, $data);
                }
            } else if ($item['type'] == "barcode") {
                $data = (new FormatData($item))->barcode();
                if ($data) {
                    array_push($print, $data);
                }
            } else if ($item['type'] == "qr") {
                $data = (new FormatData($item))->qr();
                if ($data) {
                    array_push($print, $data);
                }
            } else if ($item['type'] == "emptyline") {
                $data = (new FormatData())->emptyline();
                if ($data) {
                    array_push($print, $data);
                }
            } else if ($item['type'] == "multiline") {
                $data = (new FormatData($item))->multiline();
                if ($data) {
                    array_push($print, $data);
                }
            }
        }

        return json_encode($print, JSON_FORCE_OBJECT);
    }
}
class FormatData
{
    private $datas;
    public function text()
    {
        if (isset($this->datas['content'])) {
            $text = new \stdClass();
            $text->type = 0; //text
            $text->content = $this->datas['content']; //any string	
            $text->bold = $this->datas['option']['bold'] ?? 0; //0 if no, 1 if yes
            $text->align = $this->datas['option']['align'] ?? 0; //0 if left, 1 if center, 2 if right
            $text->format = $this->datas['option']['format'] ?? 0; //0 if normal, 1 if double Height, 2 if double Height + Width, 3 if double Width, 4 if small

            return $text;
        }

        return false;
    }
    public function image()
    {
        if (isset($this->datas['path'])) {
            $image = new \stdClass();
            $image->type = 1; //image
            $image->path = $this->datas['path']; //complete filepath on your web server; make sure that it is not big size
            $image->align = $this->datas['option']['align'] ?? 0; //0 if left, 1 if center, 2 if right; set left align for big size images
            return $image;
        }

        return false;
    }
    public function barcode()
    {
        if (isset($this->datas['value']) && isset($this->datas['option']['width']) && isset($this->datas['option']['height'])) {
            $barcode = new \stdClass();
            $barcode->type = 2; //barcode
            $barcode->value = $this->datas['value']; //valid barcode value
            $barcode->width = $this->datas['option']['width']; //valid barcode width
            $barcode->height = $this->datas['option']['height']; //valid barcode height
            $barcode->align = $this->datas['option']['align'] ?? 0; //0 if left, 1 if center, 2 if right
            return $barcode;
        }

        return false;
    }
    public function qr()
    {
        if (isset($this->datas['value']) && isset($this->datas['option']['size'])) {
            $qr = new \stdClass();
            $qr->type = 3; //QR code
            $qr->value = $this->datas['value']; //valid QR code value
            $qr->size = $this->datas['option']['size']; //valid QR code size in mm
            $qr->align = $this->datas['option']['align'] ?? 0; //0 if left, 1 if center, 2 if right
            return $qr;
        }

        return false;
    }
    public function emptyline()
    {
        $emptyline = new \stdClass();
        $emptyline->type = 0; //text
        $emptyline->content = ' '; //empty line
        $emptyline->bold = 0;
        $emptyline->align = 0;
        return $emptyline;
    }

    public function multiline()
    {
        if (isset($this->datas['content'])) {
            $multiline = new \stdClass();
            $multiline->type = 0; //text
            $multiline->content = str_replace('\n', '<br />', str_replace('\n\r', '<br />', str_replace('<br>', '<br />', $this->datas['content']))); //any string	
            $multiline->bold = $this->datas['option']['bold'] ?? 0; //0 if no, 1 if yes
            $multiline->align = $this->datas['option']['align'] ?? 0; //0 if left, 1 if center, 2 if right
            return $multiline;
        }

        return false;
    }
    function __construct($data = [])
    {
        $this->datas = $data;
    }
}
