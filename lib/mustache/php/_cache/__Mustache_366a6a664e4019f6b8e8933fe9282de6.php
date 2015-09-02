<?php

class __Mustache_366a6a664e4019f6b8e8933fe9282de6 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        // 'site.remote_jquery' section
        $value = $context->findDot('site.remote_jquery');
        $buffer .= $this->section6f65f5ee1017e60cf836b43e944a3ebd($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!--[if !IE]> -->
';
        $buffer .= $indent . '<script type="text/javascript">
';
        $buffer .= $indent . ' window.jQuery || document.write("<script src=\'';
        $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
        $buffer .= $value;
        $buffer .= '/js/jquery';
        $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
        $buffer .= $value;
        $buffer .= '.js\'>"+"<"+"/script>");
';
        $buffer .= $indent . '</script>
';
        $buffer .= $indent . '<!-- <![endif]-->
';
        $buffer .= $indent . '<!--[if IE]>
';
        $buffer .= $indent . '<script type="text/javascript">
';
        $buffer .= $indent . ' window.jQuery || document.write("<script src=\'';
        $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
        $buffer .= $value;
        $buffer .= '/js/jquery1x';
        $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
        $buffer .= $value;
        $buffer .= '.js\'>"+"<"+"/script>");
';
        $buffer .= $indent . '</script>
';
        $buffer .= $indent . '<![endif]-->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<script type="text/javascript">
';
        $buffer .= $indent . '	if(\'ontouchstart\' in document.documentElement) document.write("<script src=\'';
        $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
        $buffer .= $value;
        $buffer .= '/js/jquery.mobile.custom';
        $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
        $buffer .= $value;
        $buffer .= '.js\'>"+"<"+"/script>");
';
        $buffer .= $indent . '</script>
';

        return $buffer;
    }

    private function section6f65f5ee1017e60cf836b43e944a3ebd(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<!--[if !IE]> -->
<script src="{{{site.protocol}}}//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery{{{path.minified}}}.js"></script>
<!-- <![endif]-->
<!--[if IE]>
<script src="{{{site.protocol}}}//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery{{{path.minified}}}.js"></script>
<![endif]-->
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
                
                $buffer .= $indent . '<!--[if !IE]> -->
';
                $buffer .= $indent . '<script src="';
                $value = $this->resolveValue($context->findDot('site.protocol'), $context, $indent);
                $buffer .= $value;
                $buffer .= '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery';
                $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
                $buffer .= $value;
                $buffer .= '.js"></script>
';
                $buffer .= $indent . '<!-- <![endif]-->
';
                $buffer .= $indent . '<!--[if IE]>
';
                $buffer .= $indent . '<script src="';
                $value = $this->resolveValue($context->findDot('site.protocol'), $context, $indent);
                $buffer .= $value;
                $buffer .= '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery';
                $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
                $buffer .= $value;
                $buffer .= '.js"></script>
';
                $buffer .= $indent . '<![endif]-->
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
