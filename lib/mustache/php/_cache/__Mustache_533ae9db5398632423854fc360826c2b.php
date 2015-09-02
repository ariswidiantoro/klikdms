<?php

class __Mustache_533ae9db5398632423854fc360826c2b extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<div class="sidebar-shortcuts" id="sidebar-shortcuts">
';
        $buffer .= $indent . '	<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
';
        $buffer .= $indent . '		<button class="btn btn-success"><i class="ace-icon fa fa-signal"></i></button>
';
        $buffer .= $indent . '		<button class="btn btn-info"><i class="ace-icon fa fa-pencil"></i></button>
';
        $buffer .= $indent . '		<!-- #section:basics/sidebar.layout.shortcuts -->
';
        $buffer .= $indent . '		<button class="btn btn-warning"><i class="ace-icon fa fa-users"></i></button>
';
        $buffer .= $indent . '		<button class="btn btn-danger"><i class="ace-icon fa fa-cogs"></i></button>
';
        $buffer .= $indent . '		<!-- /section:basics/sidebar.layout.shortcuts -->
';
        $buffer .= $indent . '	</div>
';
        $buffer .= $indent . '	<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
';
        $buffer .= $indent . '		<span class="btn btn-success"></span>
';
        $buffer .= $indent . '		<span class="btn btn-info"></span>
';
        $buffer .= $indent . '		<span class="btn btn-warning"></span>
';
        $buffer .= $indent . '		<span class="btn btn-danger"></span>
';
        $buffer .= $indent . '	</div>
';
        $buffer .= $indent . '</div><!-- /.sidebar-shortcuts -->
';

        return $buffer;
    }
}
