<?php
function repeatNumber($n){

    class Challenge {
        function ret1(){ return 1; }
        function ret2(){ return 22; }
        function ret3(){ return 333; }
        function ret4(){ return 4444; }
        function ret5(){ return 55555; }
        function ret6(){ return 666666; }
        function ret7(){ return 7777777; }
        function ret8(){ return 88888888; }
        function ret9(){ return 999999999; }

        function executeGetnum($n){
            $fname = "ret" . $n;

            if (method_exists($this, $fname)) {
                return $this->$fname();
            }

        }

    }

    $chal = new Challenge();

    return $chal->executeGetnum($n);
}

echo repeatNumber(3);


// function repeatNumber($n){
// 	return str_repeat($n, $n);
// }
