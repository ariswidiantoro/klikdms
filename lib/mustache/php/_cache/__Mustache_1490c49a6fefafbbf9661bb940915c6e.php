<?php

class __Mustache_1490c49a6fefafbbf9661bb940915c6e extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        // 'site.demo' section
        $value = $context->findDot('site.demo');
        $buffer .= $this->section4b1ff6b30923fed69ff0ce683d9089d3($context, $indent, $value);
        // 'site.demo' inverted section
        $value = $context->findDot('site.demo');
        if (empty($value)) {
            
            $buffer .= $indent . '<div class="well well-sm">
';
            $buffer .= $indent . '	You can have a custom jqGrid download here:
';
            $buffer .= $indent . '	<a href="http://www.trirand.com/blog/?page_id=6" target="_blank">		
';
            $buffer .= $indent . '		http://www.trirand.com/blog/?page_id=6
';
            $buffer .= $indent . '		<i class="fa fa-external-link bigger-110"></i>
';
            $buffer .= $indent . '	</a>
';
            $buffer .= $indent . '</div>
';
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<table id="grid-table"></table>
';
        $buffer .= $indent . '<div id="grid-pager"></div>
';
        $buffer .= $indent . '<script type="text/javascript">
';
        $buffer .= $indent . 'var $path_base = "';
        $value = $this->resolveValue($context->findDot('path.base'), $context, $indent);
        $buffer .= $value;
        $buffer .= '";//in Ace demo this will be used for editurl parameter
';
        $buffer .= $indent . '</script>';

        return $buffer;
    }

    private function section4b1ff6b30923fed69ff0ce683d9089d3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
 <div class="alert alert-info">
   <button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
   <i class="ace-icon fa fa-hand-o-right"></i> Please note that demo server is not configured to save the changes, therefore you may see an error message.
 </div>
';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . ' <div class="alert alert-info">
';
                $buffer .= $indent . '   <button class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
';
                $buffer .= $indent . '   <i class="ace-icon fa fa-hand-o-right"></i> Please note that demo server is not configured to save the changes, therefore you may see an error message.
';
                $buffer .= $indent . ' </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
