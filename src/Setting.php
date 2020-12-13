<?php

namespace Dcat\Admin\Satan\Env;

use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function form()
    {
        $this->display('title')
        ->value('Quick Edit env file');
        $this->submitButton(false);
        $this->resetButton(false);
    }
}
