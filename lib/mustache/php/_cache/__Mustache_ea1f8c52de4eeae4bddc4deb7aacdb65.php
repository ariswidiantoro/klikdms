<?php

class __Mustache_ea1f8c52de4eeae4bddc4deb7aacdb65 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        // 'page.user_menu_collapsible' section
        $value = $context->findDot('page.user_menu_collapsible');
        $buffer .= $this->section0a1e340d4177db157af8a33c22a687ae($context, $indent, $value);
        // 'page.or_use_an_icon_instead' section
        $value = $context->findDot('page.or_use_an_icon_instead');
        $buffer .= $this->section4647dbc33e5975a4ce19684c2475673d($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        // 'page.side_menu_collapsible' section
        $value = $context->findDot('page.side_menu_collapsible');
        $buffer .= $this->sectionA451196aae0a454b46eb107e40fedaad($context, $indent, $value);
        $buffer .= $indent . '
';
        // 'page.user_menu_collapsible' inverted section
        $value = $context->findDot('page.user_menu_collapsible');
        if (empty($value)) {
            
            // 'page.top_menu' section
            $value = $context->findDot('page.top_menu');
            $buffer .= $this->section7f3cb6ff37df0886b6d1699805db1773($context, $indent, $value);
        }

        return $buffer;
    }

    private function section95c91aa128669ca4023d583ca1eb8cc0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = ',.navbar-menu';
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
                
                $buffer .= ',.navbar-menu';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0a1e340d4177db157af8a33c22a687ae(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse"
 data-target=".navbar-buttons{{#page.top_menu}},.navbar-menu{{/page.top_menu}}">
	<span class="sr-only">Toggle user menu</span>
	<img src="{{path.assets}}/avatars/user.jpg" alt="Jason\'s Photo" />
</button>
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
                
                $buffer .= $indent . '<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse"
';
                $buffer .= $indent . ' data-target=".navbar-buttons';
                // 'page.top_menu' section
                $value = $context->findDot('page.top_menu');
                $buffer .= $this->section95c91aa128669ca4023d583ca1eb8cc0($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '	<span class="sr-only">Toggle user menu</span>
';
                $buffer .= $indent . '	<img src="';
                $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '/avatars/user.jpg" alt="Jason\'s Photo" />
';
                $buffer .= $indent . '</button>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4647dbc33e5975a4ce19684c2475673d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="anytarget">
	<span class="sr-only">Toggle user menu</span>
	<i class="ace-icon fa fa-user fa-2x white"></i>
</button>
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
                
                $buffer .= $indent . '<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="anytarget">
';
                $buffer .= $indent . '	<span class="sr-only">Toggle user menu</span>
';
                $buffer .= $indent . '	<i class="ace-icon fa fa-user fa-2x white"></i>
';
                $buffer .= $indent . '</button>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA451196aae0a454b46eb107e40fedaad(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
	<span class="sr-only">Toggle sidebar</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</button>
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
                
                $buffer .= $indent . '<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
';
                $buffer .= $indent . '	<span class="sr-only">Toggle sidebar</span>
';
                $buffer .= $indent . '	<span class="icon-bar"></span>
';
                $buffer .= $indent . '	<span class="icon-bar"></span>
';
                $buffer .= $indent . '	<span class="icon-bar"></span>
';
                $buffer .= $indent . '</button>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7f3cb6ff37df0886b6d1699805db1773(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-menu">
	<span class="sr-only">Toggle top menu</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</button>
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
                
                $buffer .= $indent . '<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-menu">
';
                $buffer .= $indent . '	<span class="sr-only">Toggle top menu</span>
';
                $buffer .= $indent . '	<span class="icon-bar"></span>
';
                $buffer .= $indent . '	<span class="icon-bar"></span>
';
                $buffer .= $indent . '	<span class="icon-bar"></span>
';
                $buffer .= $indent . '</button>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
