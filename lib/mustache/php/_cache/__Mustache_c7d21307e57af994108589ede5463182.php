<?php

class __Mustache_c7d21307e57af994108589ede5463182 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!-- #section:basics/content.searchbox -->
';
        $buffer .= $indent . '<div class="nav-search" id="nav-search">
';
        $buffer .= $indent . '	<form class="form-search">
';
        $buffer .= $indent . '		<span class="input-icon">
';
        $buffer .= $indent . '			<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
';
        $buffer .= $indent . '			<i class="ace-icon fa fa-search nav-search-icon"></i>
';
        $buffer .= $indent . '		</span>
';
        $buffer .= $indent . '	</form>
';
        $buffer .= $indent . '</div><!-- /.nav-search -->
';
        $buffer .= $indent . '<!-- /section:basics/content.searchbox -->';

        return $buffer;
    }
}
