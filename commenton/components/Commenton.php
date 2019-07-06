<?php

class Commenton
{
    public function run()
    {
        $cnView = new CnCommentController();
        $cnView->actionView();
    }
}