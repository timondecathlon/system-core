<?php

interface UnitActions
{
    public function createLine($fields_array, $values_array);
    public function getLine();
    public function updateLine($fields_array, $values_array);
    public function deleteLine();
}
