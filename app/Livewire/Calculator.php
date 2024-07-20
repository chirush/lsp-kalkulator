<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use NXP\MathExecutor;
use App\Models\Result;

class Calculator extends Component
{
    public $display;
    public $numberOne = 0;
    public $numberTwo = 0;
    public $numberOneBool = true;
    public $numberTwoBool = false;
    public $numberOneHasPercent = false;
    public $numberTwoHasPercent = false;
    public $numberOnePOM = true;
    public $numberTwoPOM = true;
    public $selectedOperator;
    public $history;

    // Function for replacing condition of boolean number
    public function numberBool()
    {
        if ($this->numberOneBool == true){
            $this->numberOneBool = false;
            $this->numberTwoBool = true;
        }else{
            $this->numberOneBool = true;
            $this->numberTwoBool = false;
        }
    }

    public function getNumber($number)
    {
        if ($number == "clear"){
            // Resetting the number boolean
            $this->numberOneBool = true;
            $this->numberTwoBool = false;

            // Resetting the number & selected operator value
            $this->numberOne = 0;
            $this->numberTwo = 0;
            $this->selectedOperator = 0;
            $this->display = 0;
        }else if ($number == "."){
            // Adding decimal to in front of number
            if ($this->numberOneBool == true){
                $this->numberOne = $this->numberOne . ".";
                $this->display = $this->numberOne;
            }else{
                $this->numberTwo = $this->numberTwo . ".";
                $this->display = $this->numberTwo;
            }
        }else if ($number == "%"){
            // Adding percent to infront of number and changing the has percent boolean
            if ($this->numberOneBool == true){
                $this->numberOneHasPercent = true;
                $this->display = $this->numberOne . "%";
            }else{
                $this->numberTwoHasPercent = true;
                $this->display = $this->numberTwo . "%";
            }
        }else if ($number == "pom"){
            if ($this->numberOneBool == true){
                if ($this->numberOnePOM == true){
                    // Adding minus to behind of number one and changing the plus or minus boolean
                    $this->numberOnePOM = false;
                    $this->numberOne = "-" . $this->numberOne;
                    $this->display = $this->numberOne;
                }else{
                    // Removing minus from behind of number one and changing the plus or minus boolean
                    $this->numberOnePOM = true;
                    $this->numberOne = substr($this->numberOne, 1);
                    $this->display = $this->numberOne;
                }
            }else{
                if ($this->numberTwoPOM == true){
                    // Adding minus to behind of number two and changing the plus or minus boolean
                    $this->numberTwoPOM = false;
                    $this->numberTwo = "-" . $this->numberTwo;
                    $this->display = $this->numberTwo;
                }else{
                    // Removing minus from behind of number two and changing the plus or minus boolean
                    $this->numberTwoPOM = true;
                    $this->numberTwo = substr($this->numberTwo, 1);
                    $this->display = $this->numberTwo;
                }
            }
        }else{
            if ($this->numberOneBool == true){
                // Changing the default number one which is 0 with the number that inputted with condition that the number must be 0 and the minus or plus boolean is true
                if ($this->numberOne == 0 && $this->numberOnePOM == true){
                    $this->numberOne = $number;
                    $this->display = $this->numberOne;
                // Adding number in front of the number one that has been existed
                }else{
                    $this->numberOne = $this->numberOne . $number;
                    $this->display = $this->numberOne;
                }
            }else{
                // Changing the default number two which is 0 with the number that inputted with condition that the number must be 0 and the minus or plus boolean is true
                if ($this->numberTwo == 0 && $this->numberTwoPOM == true){
                    $this->numberTwo = $number;
                    $this->display = $this->numberTwo;
                // Adding number in front of the number two that has been existed
                }else{
                    $this->numberTwo = $this->numberTwo . $number;
                    $this->display = $this->numberTwo;
                }
            }
        }
    }

    public function getOperator($operator)
    {
        // Choosing the selected operator and using numberBool function for replacing condition between numberOneBool and numberTwoBool with condition that the numberOneBool must be true
        if($this->numberOneBool == true){
            $this->numberBool();
            $this->selectedOperator = $operator;
        // Choosing the selected operator and calculating the current formula since the active one is number two
        }else{
            $this->calculation();
            $this->numberBool();
            $this->selectedOperator = $operator;
        }
    }

    public function calculation()
    {
        // For calculating the formula must be the number two is the active one
        if($this->numberTwoBool == true){
            // Using numberBool function to replace the condition between numberOneBool and numberTwoBool
            $this->numberBool();

            // Declaring MathExecutor library
            $executor = new MathExecutor();

            // Changing the number one and the number two into float
            $this->numberOne = floatval($this->numberOne);
            $this->numberTwo = floatval($this->numberTwo);

            // Checking if the number one or number two has percent in it. If so, it will adding "/100" replacing the % function
            if ($this->numberOneHasPercent){
                $this->numberOneHasPercent = false;
                $this->numberOne = $this->numberOne . "/" . 100;
            }

            if ($this->numberTwoHasPercent){
                $this->numberTwoHasPercent = false;
                $this->numberTwo = $this->numberTwo . "/" . 100;
            }

            // Printing the formula for inserting to database
            $formula = $this->numberOne . $this->selectedOperator . $this->numberTwo;

            // Calculating the formula and displaying the result as number one
            $this->numberOne = $executor->execute($this->numberOne . $this->selectedOperator . $this->numberTwo);
            $this->display = $this->numberOne;

            // Inserting the formula and the result into database
            $result = Result::create([
                'formula' => $formula,
                'result' => $this->numberOne,
            ]);

            // Resetting the value of number two and plus or minus
            $this->numberTwo = 0;
            $this->numberOnePOM = true;
            $this->numberTwoPOM = true;

            // Recalling the result database
            $this->history = Result::orderBy('id', 'desc')->get()->take(7);
        }
    }

    public function useHistory($result)
    {
        // Resetting the condition between numberOneBool and numberTwoBool
        $this->numberOneBool = true;
        $this->numberTwoBool = false;

        // Changing the number one value into the current result and resetting the number two and the selected operator
        $this->numberOne = $result;
        $this->numberTwo = 0;
        $this->selectedOperator = 0;
        $this->display = $this->numberOne;
    }

    public function mount()
    {
        // Default value of display
        $this->display = "0";

        // Taking the result from database
        $this->history = Result::orderBy('id', 'desc')->get()->take(7);
    }

    public function render()
    {
        return view('livewire.calculator', [
            'display' => $this->display,
            'history' => $this->history,
        ])->layout('livewire.layout');
    }
}
