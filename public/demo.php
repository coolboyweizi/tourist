<?php
// 策略模式: 把一组算法移入一个独立的类中.动态组合重组对象

abstract class costStrategy {
    abstract function cost(lesson $lesson);
    abstract function chargeType();
}

abstract class lesson {
    private $duration ;
    private $costStrategy;

    public function __construct($duration, costStrategy $costStrategy)
    {
        $this->duration = $duration;
        $this->costStrategy = $costStrategy;
    }

    public function cost(){
        return $this->costStrategy->cost($this);
    }

    public function chargeType(){
        return $this->costStrategy->chargeType();
    }
}

class Lecture extends lesson {

}

class Seminar extends lesson {

}

?>