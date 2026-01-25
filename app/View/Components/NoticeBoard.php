<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NoticeBoard extends Component{
    
    public $title;
    public $notices;

    public function __construct($title, $notices){
        $this->title = $title;
        $this->notices=$notices;

    }

    
    public function render(){

        return view('components.notice-board');
    }
}
