<?php

class PolishNotation{
    private $expression;
    private $solution;
    private $delimiter;

    function __construct() {
        $this->expression = '';
        $this->solution = 0;
        $this->delimiter = " ";
    }

    function __destruct() {
        $this->expression = '';
        $this->solution = 0;
        $this->delimiter = " ";
    }

    function executeOperation($num1, $num2, $operator){
        $num1 = (int)$num1;
        $num2 = (int)$num2;
        switch($operator){
            case "+": 
                $val = $num1 + $num2; 
                return (string)$val; 
                break;

            case "-": 
                $val = $num1 - $num2; 
                return (string)$val; 
                break;
            case "*":
            case "x": 
                $val = $num1 * $num2; 
                return (string)$val; 
                break;
            case "÷":
            case "/": 
                $val = $num1 / $num2; 
                return (string)$val; 
                break;
            default: 
                throw new Exception("Invalid operator"); 
                break;
        }
    }

    function setDelimiter($delm) {
        $this->delimiter = $delm;
    }

    function getExpresstion() {
        return $this->expression;
    }
    function setExpression($exp) {
        $this->expression = $exp;
    }

    function computeExpression(){
        $string = explode($this->delimiter,$this->expression);
        $operands = array();
        $operators = array();
        if(sizeof($string)<=2){
            throw new Exception("Invalid expression");
        }
        else{
            $value=0;
            $flag=0;
            for($i=0; $i<sizeof($string); $i++) {
                if (is_numeric($string[$i])) {
                    // insert operands into the array
                    array_push($operands, $string[$i]);
                    $x = $i + 1;
                    
                    // if consecutive operands encountered proceed to calculate 
                    if(($x != sizeof($string)&& (is_numeric($string[$x]))|| ($flag == 1))) {
                        if ($x < sizeof($string)) {
                            if(is_numeric($string[$x])) {
                                array_push($operands, $string[$x]);
                                $i++;
                            }
                        }
                        // left to right - operate over the stack of operators and operations until current operand stack is exhausted, update flag to 1 on successful evaluation   
                        while(sizeof($operands)>1) {
                            $num1 = end($operands);
                            array_pop($operands);
                            $num2 = end($operands);
                            array_pop($operands);
                            if(sizeof($operators) == 0){
                                throw new Exception("Invalid expression");
                            }
                            $value = $this->executeOperation($num2, $num1, end($operators));
                            array_pop($operators);
                            array_push($operands, $value);
                            $flag = 1;
                        }
                        //checks for an operator and corrects flag to 0
                        if ($i < (sizeof($string) - 1)){
                            if(!is_numeric($string[$i+1])) {
                                $flag = 0;
                            }
                        }
                    }
                }
                //insert operators into the array
                else{
                    array_push($operators, $string[$i]);
                }
            }
        }
        if((sizeof($operands)>1)||(sizeof($operators)!=0)) {
            throw new Exception("Invalid expression");
        }
        else{
            // echo "Answer:".end($operands)."<br/>";
            $this->solution = end($operands);
        }
    }
    function getSolution() {
        return $this->solution;
    }
}

$foo = new PolishNotation();

//valid 
try{
    $foo->setExpression("- x ÷ 15 - 7 + 1 1 3 + 2 + 1 1");
    $foo->computeExpression();
    echo $foo->getSolution()."<br/>";
} catch (Exception $e) {
    echo "Caught Exception : ",$e->getMessage(), "<br/>";
}

//invalid
try{
    $foo->setExpression("- x ÷ 15 - 7 + 1 1 3 + 2 + 1 1 1");
    $foo->computeExpression();
    echo $foo->getSolution()."<br/>";
} catch (Exception $e) {
    echo "Caught Exception : ",$e->getMessage(), "<br/>";
}

//invalid
try{
    $foo->setExpression("- x ÷ 15 - 7 + 1 1 3 + 2 + 1 1 + 1");
    $foo->computeExpression();
    echo $foo->getSolution()."<br/>";
} catch (Exception $e) {
    echo "Caught Exception : ",$e->getMessage(), "<br/>";
}

//valid
try{
    $foo->setExpression("- x ÷ 15 3 1 1");
    $foo->computeExpression();
    echo $foo->getSolution()."<br/>";
} catch (Exception $e) {
    echo "Caught Exception : ",$e->getMessage(), "<br/>";
}

//invalid
try{
    $foo->setExpression("4 5 3 3 - + 4 1");
    $foo->computeExpression();
    echo $foo->getSolution()."<br/>";
} catch (Exception $e) {
    echo "Caught Exception : ",$e->getMessage(), "<br/>";
}

//invalid
try{
    $foo->setExpression("- + 4 1");
    $foo->computeExpression();
    echo $foo->getSolution()."<br/>";
} catch (Exception $e) {
    echo "Caught Exception : ",$e->getMessage(), "<br/>";
}

//invalid
try{
    $foo->setExpression("3 - + 4 1 5 7 8 +");
    $foo->computeExpression();
    echo $foo->getSolution()."<br/>";
} catch (Exception $e) {
    echo "Caught Exception : ",$e->getMessage(), "<br/>";
}

//valid
try{
    $foo->setExpression("+ + -10 7 8");
    $foo->computeExpression();
    echo $foo->getSolution()."<br/>";
} catch (Exception $e) {
    echo "Caught Exception : ",$e->getMessage(), "<br/>";
}

?>