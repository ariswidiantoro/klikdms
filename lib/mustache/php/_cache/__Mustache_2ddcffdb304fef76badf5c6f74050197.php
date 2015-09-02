<?php

class __Mustache_2ddcffdb304fef76badf5c6f74050197 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!-- #section:basics/content.breadcrumbs -->
';
        $buffer .= $indent . '<div class="breadcrumbs" id="breadcrumbs">
';
        $buffer .= $indent . '	<script type="text/javascript">
';
        $buffer .= $indent . '	try{ace.settings.check(\'breadcrumbs\' , \'fixed\')}catch(e){}
';
        $buffer .= $indent . '	</script>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	<ul class="breadcrumb">
';
        $buffer .= $indent . '		<li><i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a></li>
';
        // 'breadcrumbs.links' section
        $value = $context->findDot('breadcrumbs.links');
        $buffer .= $this->section7017aed8bdbb0eea7b883ffad94c2f7d($context, $indent, $value);
        $buffer .= $indent . '		<li class="active">';
        $value = $this->resolveValue($context->findDot('breadcrumbs.title'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '</li>
';
        $buffer .= $indent . '	</ul><!-- /.breadcrumb -->
';
        $buffer .= $indent . '
';
        if ($partial = $this->mustache->loadPartial('layout.searchbox')) {
            $buffer .= $partial->renderInternal($context, $indent . '	');
        }
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '<!-- /section:basics/content.breadcrumbs -->';

        return $buffer;
    }

    private function section7017aed8bdbb0eea7b883ffad94c2f7d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
		<li><a href="{{link}}">{{title}}</a></li>
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
                
                $buffer .= $indent . '		<li><a href="';
                $value = $this->resolveValue($context->find('link'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '">';
                $value = $this->resolveValue($context->find('title'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
