<?php

class __Mustache_9a5ad0581ddd40102afa815b244b66e4 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        // 'site.remote_fontawesome' section
        $value = $context->findDot('site.remote_fontawesome');
        $buffer .= $this->section87f20230f5778f1a37c5b029d1fe024e($context, $indent, $value);
        $buffer .= $indent . '
';
        // 'site.remote_fontawesome' inverted section
        $value = $context->findDot('site.remote_fontawesome');
        if (empty($value)) {
            
            $buffer .= $indent . '<link rel="stylesheet" href="';
            $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
            $buffer .= $value;
            $buffer .= '/css/font-awesome';
            $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
            $buffer .= $value;
            $buffer .= '.css" />
';
        }

        return $buffer;
    }

    private function section87f20230f5778f1a37c5b029d1fe024e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<link rel="stylesheet" href="{{{site.protocol}}}//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome{{{path.minified}}}.css" />
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
                $value = $this->resolveValue($context->findDot('site.protocol'), $context, $indent);
                $buffer .= $value;
                $buffer .= '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome';
                $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
                $buffer .= $value;
                $buffer .= '.css" />
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
