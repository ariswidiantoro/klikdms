<?php

class __Mustache_777bbbe8fa78792cba0627f127c5d478 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!-- basic scripts -->
';
        if ($partial = $this->mustache->loadPartial('layout._template.jquery')) {
            $buffer .= $partial->renderInternal($context);
        }
        if ($partial = $this->mustache->loadPartial('layout._template.bootstrap')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- page specific plugin scripts -->
';
        // 'page.ie_scripts' section
        $value = $context->findDot('page.ie_scripts');
        $buffer .= $this->sectionD1bea1300a91f8955474d723b0ca3fa9($context, $indent, $value);
        $buffer .= $indent . '
';
        // 'page.scripts' section
        $value = $context->findDot('page.scripts');
        $buffer .= $this->sectionF3807ae2748cd4c0767304a59de4fc36($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- ace scripts -->
';
        // 'site.development' inverted section
        $value = $context->findDot('site.development');
        if (empty($value)) {
            
            $buffer .= $indent . ' <script src="';
            $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
            $buffer .= $value;
            $buffer .= '/js/ace-elements';
            $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
            $buffer .= $value;
            $buffer .= '.js"></script>
';
            $buffer .= $indent . ' <script src="';
            $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
            $buffer .= $value;
            $buffer .= '/js/ace';
            $value = $this->resolveValue($context->findDot('path.minified'), $context, $indent);
            $buffer .= $value;
            $buffer .= '.js"></script>
';
        }
        $buffer .= $indent . '
';
        // 'site.development' section
        $value = $context->findDot('site.development');
        $buffer .= $this->section9975b6577d734404d1c8312b254e5be3($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- inline scripts related to this page -->
';
        // 'page.inline_scripts' section
        $value = $context->findDot('page.inline_scripts');
        $buffer .= $this->section458013a5eeea0061124ccd780977da71($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        // 'site.onpage_help' section
        $value = $context->findDot('site.onpage_help');
        $buffer .= $this->sectionD9cc846c57c2ebffa69f1bf22bfa0897($context, $indent, $value);

        return $buffer;
    }

    private function sectionD1bea1300a91f8955474d723b0ca3fa9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<!--[if lte IE {{version}}]>
  <script src="{{{path.assets}}}/js/{{{file_name}}}"></script>
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
                
                $buffer .= $indent . '<!--[if lte IE ';
                $value = $this->resolveValue($context->find('version'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= ']>
';
                $buffer .= $indent . '  <script src="';
                $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/js/';
                $value = $this->resolveValue($context->find('file_name'), $context, $indent);
                $buffer .= $value;
                $buffer .= '"></script>
';
                $buffer .= $indent . '<![endif]-->
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF3807ae2748cd4c0767304a59de4fc36(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<script src="{{{path.assets}}}/js/{{{.}}}"></script>
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
                
                $buffer .= $indent . '<script src="';
                $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/js/';
                $value = $this->resolveValue($context->last(), $context, $indent);
                $buffer .= $value;
                $buffer .= '"></script>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section46dd3d57a7f3164f290e469a7c2ce846(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <script src="{{{path.assets}}}/js/ace/{{{.}}}"></script>
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
                
                $buffer .= $indent . '  <script src="';
                $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/js/ace/';
                $value = $this->resolveValue($context->last(), $context, $indent);
                $buffer .= $value;
                $buffer .= '"></script>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9975b6577d734404d1c8312b254e5be3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '{{! in development mode use separate script files }}
 {{#site.ace_scripts}}
  <script src="{{{path.assets}}}/js/ace/{{{.}}}"></script>
 {{/site.ace_scripts}}
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
                
                // 'site.ace_scripts' section
                $value = $context->findDot('site.ace_scripts');
                $buffer .= $this->section46dd3d57a7f3164f290e469a7c2ce846($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section458013a5eeea0061124ccd780977da71(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<script type="text/javascript">
{{{page.inline_scripts}}}
</script>
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
                
                $buffer .= $indent . '<script type="text/javascript">
';
                $value = $this->resolveValue($context->findDot('page.inline_scripts'), $context, $indent);
                $buffer .= $indent . $value;
                $buffer .= '
';
                $buffer .= $indent . '</script>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD9cc846c57c2ebffa69f1bf22bfa0897(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '{{! enable on page help }}
  <!-- the following scripts are used in demo only for onpage help and you don\'t need them -->
  <link rel="stylesheet" href="{{{path.assets}}}/css/ace.onpage-help.css" />
  <link rel="stylesheet" href="{{{path.base}}}/docs/assets/js/themes/sunburst.css" />

  <script type="text/javascript">ace.vars[\'base\'] = \'{{{path.base}}}\';</script>
  <script src="{{{path.assets}}}/js/ace/elements.onpage-help.js"></script>
  <script src="{{{path.assets}}}/js/ace/ace.onpage-help.js"></script>
  <script src="{{{path.base}}}/docs/assets/js/rainbow.js"></script>
  <script src="{{{path.base}}}/docs/assets/js/language/generic.js"></script>
  <script src="{{{path.base}}}/docs/assets/js/language/html.js"></script>
  <script src="{{{path.base}}}/docs/assets/js/language/css.js"></script>  
  <script src="{{{path.base}}}/docs/assets/js/language/javascript.js"></script>
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
                
                $buffer .= $indent . '  <!-- the following scripts are used in demo only for onpage help and you don\'t need them -->
';
                $buffer .= $indent . '  <link rel="stylesheet" href="';
                $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/css/ace.onpage-help.css" />
';
                $buffer .= $indent . '  <link rel="stylesheet" href="';
                $value = $this->resolveValue($context->findDot('path.base'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/docs/assets/js/themes/sunburst.css" />
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '  <script type="text/javascript">ace.vars[\'base\'] = \'';
                $value = $this->resolveValue($context->findDot('path.base'), $context, $indent);
                $buffer .= $value;
                $buffer .= '\';</script>
';
                $buffer .= $indent . '  <script src="';
                $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/js/ace/elements.onpage-help.js"></script>
';
                $buffer .= $indent . '  <script src="';
                $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/js/ace/ace.onpage-help.js"></script>
';
                $buffer .= $indent . '  <script src="';
                $value = $this->resolveValue($context->findDot('path.base'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/docs/assets/js/rainbow.js"></script>
';
                $buffer .= $indent . '  <script src="';
                $value = $this->resolveValue($context->findDot('path.base'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/docs/assets/js/language/generic.js"></script>
';
                $buffer .= $indent . '  <script src="';
                $value = $this->resolveValue($context->findDot('path.base'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/docs/assets/js/language/html.js"></script>
';
                $buffer .= $indent . '  <script src="';
                $value = $this->resolveValue($context->findDot('path.base'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/docs/assets/js/language/css.js"></script>  
';
                $buffer .= $indent . '  <script src="';
                $value = $this->resolveValue($context->findDot('path.base'), $context, $indent);
                $buffer .= $value;
                $buffer .= '/docs/assets/js/language/javascript.js"></script>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
