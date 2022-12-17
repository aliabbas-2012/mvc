<?php
interface Crud
{
    public  function create($payload);
    public  function update($payload);
    public function delete();
}
?>