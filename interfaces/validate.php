<?php
interface Validate
{
    public function validteRequire($payload);
    public function validateUnique($payload);
    public function validteAlphabet($payload);
    public function validteLength($payload);
}
?>