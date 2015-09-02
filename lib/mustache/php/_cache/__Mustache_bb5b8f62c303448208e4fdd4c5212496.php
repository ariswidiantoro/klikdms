<?php

class __Mustache_bb5b8f62c303448208e4fdd4c5212496 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!-- bootstrap & fontawesome -->
';
        $buffer .= $indent . '<link rel="stylesheet" href="';
        $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
        $buffer .= $value;
        $buffer .= '/css/bootstrap';
        $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
        $buffer .= $value;
        $buffer .= '.css" />';
        $buffer .= '
';
        if ($partial = $this->mustache->loadPartial('layout._template.fontawesome')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- page specific plugin styles -->
';
        // 'page.styles' section
        $value = $context->findDot('page.styles');
        $buffer .= $this->section3cad4c990aac8bfcc3a92efe0cd6be15($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- text fonts -->
';
        if ($partial = $this->mustache->loadPartial('layout._template.fonts')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- ace styles -->
';
        $buffer .= $indent . '<link rel="stylesheet" href="';
        $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
        $buffer .= $value;
        $buffer .= '/css/ace';
        $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
        $buffer .= $value;
        $buffer .= '.css" class="ace-main-stylesheet" id="main-ace-style" />
';
        $buffer .= $indent . '<!--[if lte IE 9]>
';
        $buffer .= $indent . '	<link rel="stylesheet" href="';
        $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
        $buffer .= $value;
        $buffer .= '/css/ace-part2';
        $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
        $buffer .= $value;
        $buffer .= '.css" class="ace-main-stylesheet" />
';
        $buffer .= $indent . '<![endif]-->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!--[if lte IE 9]>
';
        $buffer .= $indent . '  <link rel="stylesheet" href="';
        $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
        $buffer .= $value;
        $buffer .= '/css/ace-ie';
        $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
        $buffer .= $value;
        $buffer .= '.css" />
';
        $buffer .= $indent . '<![endif]-->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- inline styles related to this page -->
';
        // 'page.inline_styles' section
        $value = $context->findDot('page.inline_styles');
        $buffer .= $this->section34cf4e0468877d329d2157748eb3f995($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- ace settings handler -->
';
        $buffer .= $indent . '<script src="';
        $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
        $buffer .= $value;
        $buffer .= '/js/ace-extra';
        $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
        $buffer .= $value;
        $buffer .= '.js"></script>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
';
        $buffer .= $indent . '<!--[if lte IE 8]>
';
        $buffer .= $indent . '<script src="';
        $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
        $buffer .= $value;
        $buffer .= '/js/html5shiv';
        $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
        $buffer .= $value;
        $buffer .= '.js"></script>
';
        $buffer .= $indent . '<script src="';
        $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
        $buffer .= $value;
        $buffer .= '/js/respond';
        $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
        $buffer .= $value;
        $buffer .= '.js"></script>
';
        $buffer .= $indent . '<![endif]-->';

        return $buffer;
    }

    private function section3cad4c990aac8bfcc3a92efe0cd6be15(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<link rel="stylesheet" href="{{{path.assets}}}/css/{{{.}}}" />
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
                
                $buffer .= $indent . '<link rel="stylesheet" href="';
                $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/css/';
                $value = $this->resolveValue($context->last(), $context, $indent);
                $buffer .= $value;
                $buffer .= '" />
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section34cf4e0468877d329d2157748eb3f995(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<style>
{{{page.inline_styles}}}
</style>
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
                
                $buffer .= $indent . '<style>
';
                $value = $this->resolveValue($context->findDot('page.inline_styles'), $context, $indent);
                $buffer .= $indent . $value;
                $buffer .= '
';
                $buffer .= $indent . '</style>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
