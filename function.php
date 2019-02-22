<?php
class check{
    public $arr;
    public $return=array();
    public $count;

    public $firstLine = array();
    public $secondLine = array();
    public $thirdLine = array();

    public $style;

    public $info = array();

    public function __construct($array)
    {
        $this->arr=$array;
        $this->firstCheck();
    }

    public function firstCheck(){
        $this->count=count($this->arr);

        $a=true;
        for($i=0; $i<=$this->count-1; $i++){
            $cells = $this->arr[$i]['cells'];
            $nums = explode(',',$cells);
            $z=count($nums);
            if($z==5 || $z==7 || $z==8){
                $a=false;
            }else{
                array_push($this->return,$this->arr[$i]['cells']);
            }
        }
        if($a){
            $this->secondCheck();
        }else{
            echo '<div class="alert"><h2>Введите корректрное количество ячеек для объединения<br> и обновите страницу</h2></div>';
        }
    }

    public function secondCheck(){
        $cell = explode(',',implode(',',$this->return));
        $check=array_count_values($cell);

        $a=true;
        foreach($check as $key=>$val){
            if($key!=''){
                if($val>1){
                    $a=false;
                }
            }
        }
        if($a){
            $this->thirdCheck();
        }else{
            echo '<div class="alert"><h2>Введите иное знаение в поле Cells - обнаружены повторяющиеся ячейки<br> и обновите страницу</h2></div>';
        }
    }

    public function thirdCheck(){
        $firstRow = array(1,2,3);
        $secondRow = array(4,5,6);
        $thirdRow = array(7,8,9);


//        foreach($this->return as $val){
//            $newarr = explode(',', $val);
//            sort($newarr, SORT_ASC);
//            array_push($this->firstLine,array_intersect($firstRow, $newarr));
//            array_push($this->secondLine,array_intersect($secondRow, $newarr));
//            array_push($this->thirdLine,array_intersect($thirdRow, $newarr));
//        }

        foreach($this->return as $val){
            $newarr = explode(',', $val);
            sort($newarr, SORT_ASC);
            $this->firstLine=array_intersect($firstRow, $newarr);
            $this->secondLine=array_intersect($secondRow, $newarr);
            $this->thirdLine=array_intersect($thirdRow, $newarr);
        }


        for($i=0; $i<=$this->count-1; $i++) {
            $array = $this->arr[$i]['cells'];
            $cells = explode(',', $array);
            sort($cells, SORT_ASC);
            $z = count($cells);

            $text = $this->arr[$i]['text'];
            $number = $this->arr[$i]['cells'];
            $align = $this->arr[$i]['align'];
            $valign = $this->arr[$i]['valign'];
            $color = $this->arr[$i]['color'];
            $bgcolor = $this->arr[$i]['bgcolor'];

            $infoarr = array($cells[0], $text);

            $this->style .= ".cell$cells[0] span{
                text-align: $align !important;
                        vertical-align: $valign !important;
                        color: $color;
                        background: $bgcolor;
                        }";
            switch ($z){
                case 1:

                    array_push ($this->info, $infoarr);
                    break;



                case 2:

                    if($cells[0]==$cells[1]-1){
                        if($cells[0]<=3){
                            $f = $cells[0];
                            $l = $cells[1] + 1;
                            $r = 1;
                        }else if($cells[0]>3 && $cells[0]<=6){
                            $f = $cells[0]-3;
                            $l = $cells[1]-2;
                            $r = 2;
                        }else if($cells[0]>6 && $cells[0]<=9){
                            $f = $cells[0]-6;
                            $l = $cells[1]-5;
                            $r = 3;
                        }
                        $type = ".cell$cells[0]{
                                grid-column: $f / $l;
                                grid-row: $r;
                                }";
                    }else if($cells[0]==$cells[1]-3){
                        if($cells[0]<=3){
                            $c = $cells[0];
                        }else if($cells[0]>3 && $cells[0]<=6){
                            $c = $cells[0]-3;
                        }else if($cells[0]>6 && $cells[0]<=9){
                            $c = $cells[0]-6;
                        }
                        $f = ceil($cells[0]/3);
                        $l = ceil($cells[1]/3 + 1);
                        $type = ".cell$cells[0]{
                            grid-column: $c;
                            grid-row: $f / $l;
                            }";
                    }else{
                        echo '<div class="alert"><h2>В массиве, в котором передано 2 значения Cells укажите два соседних по вертикали или по горизонтали значения<br> и обновите страницу</h2></div>';
                    }

                    $this->style .= "
                        $type
                        .cell$cells[1]{
                        display: none !important;
                        }";

                    array_push ($this->info,$infoarr);
                    break;



                case 3:
                    if($cells[0]==$cells[1]-1 && $cells[0]==$cells[2]-2){
                        if($cells[0]<=3){
                            $f = $cells[0];
                            $l = $cells[2] + 1;
                            $r = 1;
                        }else if($cells[0]>3 && $cells[0]<=6){
                            $f = $cells[0]-3;
                            $l = $cells[2]-2;
                            $r = 2;
                        }else if($cells[0]>6 && $cells[0]<=9){
                            $f = $cells[0]-6;
                            $l = $cells[2]-5;
                            $r = 3;
                        }
                        $type = ".cell$cells[0]{
                                grid-column: $f / $l;
                                grid-row: $r;
                                }";
                    }else if($cells[0]==$cells[1]-3 && $cells[0]==$cells[2]-6){
                        if($cells[0]<=3){
                            $c = $cells[0];
                        }else if($cells[0]>3 && $cells[0]<=6){
                            $c = $cells[0]-3;
                        }else if($cells[0]>6 && $cells[0]<=9){
                            $c = $cells[0]-6;
                        }
                        $f = ceil($cells[0]/3);
                        $l = ceil($cells[2]/3 + 1);
                        $type = ".cell$cells[0]{
                            grid-column: $c;
                            grid-row: $f / $l;
                            }";
                    }else {
                        echo '<div class="alert"><h2>В массиве, в котором передано 3 значения Cells укажите три соседних по вертикали или по горизонтали значения<br> и обновите страницу</h2></div>';
                    }

                    $this->style .= "
                        $type
                        .cell$cells[1], .cell$cells[2]{
                        display: none !important;
                        }";

                    array_push ($this->info,$infoarr);
                    break;



                case 4:
                    if($cells[0]==$cells[1]-1 && $cells[0]==$cells[2]-3 && $cells[2]==$cells[3]-1){
                        if($cells[0]<=3){
                            $fc = $cells[0];
                            $lc = $cells[1] + 1;
                        }else if($cells[0]>3 && $cells[0]<=6){
                            $fc = $cells[0]-3;
                            $lc = $cells[1]-2;
                        }else if($cells[0]>6 && $cells[0]<=9){
                            $fc = $cells[0]-6;
                            $lc = $cells[1]-5;
                        }
                        $fr = ceil($cells[0]/3);
                        $lr = ceil($cells[2]/3 + 1);

                        $type = ".cell$cells[0]{
                                grid-column: $fc / $lc;
                                grid-row: $fr / $lr;
                                }";
                    }else{
                        echo '<div class="alert"><h2>В массиве, в котором передано 4 значения Cells, укажите четыре значения по форме квадрата <br> и обновите страницу</h2></div>';
                    }

                    $this->style .= "
                        $type
                        .cell$cells[1], .cell$cells[2], .cell$cells[3]{
                        display: none !important;
                        }";

                    array_push ($this->info,$infoarr);
                    break;



                case 6:
                    if($cells[0]==$cells[1]-1 && $cells[0]==$cells[2]-2 && $cells[0]==$cells[3]-3 &&
                    $cells[0]==$cells[4]-4 && $cells[0]==$cells[5]-5){
                        if($cells[0]<=3){
                            $fc = $cells[0];
                            $lc = $cells[2] + 1;
                        }else if($cells[0]>3 && $cells[0]<=6){
                            $fc = $cells[0]-3;
                            $lc = $cells[2]-2;
                        }
                        $fr = ceil($cells[0]/3);
                        $lr = ceil($cells[5]/3 + 1);

                        $type = ".cell$cells[0]{
                                grid-column: $fc / $lc;
                                grid-row: $fr / $lr;
                                }";
                    }else if($cells[0]==$cells[1]-1 && $cells[0]==$cells[2]-3 && $cells[0]==$cells[3]-4 &&
                        $cells[0]==$cells[4]-6 && $cells[0]==$cells[5]-7){
                            $fc = $cells[0];
                            $lc = $cells[1]+1;
                            $fr = ceil($cells[0]/3);
                            $lr = ceil($cells[5]/3 + 1);
                            $type = ".cell$cells[0]{
                                grid-column: $fc / $lc;
                                grid-row: $fr / $lr;
                                }";
                    }else{
                        echo '<div class="alert"><h2>В массиве, в котором передано 6 значений Cells, укажите шесть значений по форме прямоугольника <br> и обновите страницу</h2></div>';
                    }

                    $this->style .= "
                        $type
                        .cell$cells[1], .cell$cells[2], .cell$cells[3], .cell$cells[4], .cell$cells[5]{
                        display: none !important;
                        }";

                    array_push ($this->info,$infoarr);
                    break;

                case 9:
                    $type = ".cell$cells[0]{
                                grid-column: 1 / 4;
                                grid-row: 1 / 4;
                                }";
                    $this->style .= "
                        $type
                        .cell$cells[1], .cell$cells[2], .cell$cells[3], .cell$cells[4], .cell$cells[5], .cell$cells[6],
                        .cell$cells[7], .cell$cells[8]{
                        display: none !important;
                        }";

                    array_push ($this->info,$infoarr);
                    break;

            }
        }

    }
}