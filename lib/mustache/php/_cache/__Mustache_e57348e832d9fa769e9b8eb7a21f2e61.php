<?php

class __Mustache_e57348e832d9fa769e9b8eb7a21f2e61 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!-- #section:pages/dashboard.comments -->
';
        $buffer .= $indent . '<div class="comments">
';
        // 'page.comments' section
        $value = $context->findDot('page.comments');
        $buffer .= $this->section1091c2594b4e8dc80178e539333cfd20($context, $indent, $value);
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="hr hr8"></div>
';
        $buffer .= $indent . '<div class="center">
';
        $buffer .= $indent . '	<i class="ace-icon fa fa-comments-o fa-2x green middle"></i>
';
        $buffer .= $indent . '	&nbsp;
';
        $buffer .= $indent . '	<a href="#" class="btn btn-sm btn-white btn-info">See all comments &nbsp; <i class="ace-icon fa fa-arrow-right"></i></a>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '<div class="hr hr-double hr8"></div>
';
        $buffer .= $indent . '<!-- /section:pages/dashboard.comments -->';

        return $buffer;
    }

    private function section42dabc6bc762b4c2bf7807d1ab6f914f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
			<div class="inline position-relative">
				<button class="btn btn-minier bigger btn-yellow dropdown-toggle" data-toggle="dropdown"><i class="ace-icon fa fa-angle-down icon-only bigger-120"></i></button>
				<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
					<li><a href="#" class="tooltip-success" data-rel="tooltip" title="Approve"><span class="green"><i class="ace-icon fa fa-check bigger-110"></i></span></a></li>
					<li><a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject"><span class="orange"><i class="ace-icon fa fa-times bigger-110"></i></span> </a></li>
					<li><a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"><span class="red"><i class="ace-icon fa fa-trash-o bigger-110"></i></span> </a></li>
				</ul>
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
                
                $buffer .= $indent . '			<div class="inline position-relative">
';
                $buffer .= $indent . '				<button class="btn btn-minier bigger btn-yellow dropdown-toggle" data-toggle="dropdown"><i class="ace-icon fa fa-angle-down icon-only bigger-120"></i></button>
';
                $buffer .= $indent . '				<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
';
                $buffer .= $indent . '					<li><a href="#" class="tooltip-success" data-rel="tooltip" title="Approve"><span class="green"><i class="ace-icon fa fa-check bigger-110"></i></span></a></li>
';
                $buffer .= $indent . '					<li><a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject"><span class="orange"><i class="ace-icon fa fa-times bigger-110"></i></span> </a></li>
';
                $buffer .= $indent . '					<li><a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"><span class="red"><i class="ace-icon fa fa-trash-o bigger-110"></i></span> </a></li>
';
                $buffer .= $indent . '				</ul>
';
                $buffer .= $indent . '			</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1091c2594b4e8dc80178e539333cfd20(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
	<div class="itemdiv commentdiv">
		<div class="user">
			<img alt="{{name}}\'s Avatar" src="{{path.assets}}/avatars/{{avatar}}" />
		</div>
		
		<div class="body">
			<div class="name"><a href="#">{{name}}</a></div>
			<div class="time"><i class="ace-icon fa fa-clock-o"></i> <span class="{{time-color}}">{{time}}</span></div>
			<div class="text">
				<i class="ace-icon fa fa-quote-left"></i> {{comment}} &hellip;
			</div>
		</div>
		
		<div class="tools">
			{{#menu}}
			<div class="inline position-relative">
				<button class="btn btn-minier bigger btn-yellow dropdown-toggle" data-toggle="dropdown"><i class="ace-icon fa fa-angle-down icon-only bigger-120"></i></button>
				<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
					<li><a href="#" class="tooltip-success" data-rel="tooltip" title="Approve"><span class="green"><i class="ace-icon fa fa-check bigger-110"></i></span></a></li>
					<li><a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject"><span class="orange"><i class="ace-icon fa fa-times bigger-110"></i></span> </a></li>
					<li><a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"><span class="red"><i class="ace-icon fa fa-trash-o bigger-110"></i></span> </a></li>
				</ul>
			</div>
			{{/menu}}
			{{^menu}}
			<div class="action-buttons bigger-125">
				<a href="#"><i class="ace-icon fa fa-pencil blue"></i></a>
				<a href="#"><i class="ace-icon fa fa-trash-o red"></i></a>
			</div>
			{{/menu}}
		</div>
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
                
                $buffer .= $indent . '	<div class="itemdiv commentdiv">
';
                $buffer .= $indent . '		<div class="user">
';
                $buffer .= $indent . '			<img alt="';
                $value = $this->resolveValue($context->find('name'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '\'s Avatar" src="';
                $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '/avatars/';
                $value = $this->resolveValue($context->find('avatar'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '" />
';
                $buffer .= $indent . '		</div>
';
                $buffer .= $indent . '		
';
                $buffer .= $indent . '		<div class="body">
';
                $buffer .= $indent . '			<div class="name"><a href="#">';
                $value = $this->resolveValue($context->find('name'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</a></div>
';
                $buffer .= $indent . '			<div class="time"><i class="ace-icon fa fa-clock-o"></i> <span class="';
                $value = $this->resolveValue($context->find('time-color'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '">';
                $value = $this->resolveValue($context->find('time'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</span></div>
';
                $buffer .= $indent . '			<div class="text">
';
                $buffer .= $indent . '				<i class="ace-icon fa fa-quote-left"></i> ';
                $value = $this->resolveValue($context->find('comment'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= ' &hellip;
';
                $buffer .= $indent . '			</div>
';
                $buffer .= $indent . '		</div>
';
                $buffer .= $indent . '		
';
                $buffer .= $indent . '		<div class="tools">
';
                // 'menu' section
                $value = $context->find('menu');
                $buffer .= $this->section42dabc6bc762b4c2bf7807d1ab6f914f($context, $indent, $value);
                // 'menu' inverted section
                $value = $context->find('menu');
                if (empty($value)) {
                    
                    $buffer .= $indent . '			<div class="action-buttons bigger-125">
';
                    $buffer .= $indent . '				<a href="#"><i class="ace-icon fa fa-pencil blue"></i></a>
';
                    $buffer .= $indent . '				<a href="#"><i class="ace-icon fa fa-trash-o red"></i></a>
';
                    $buffer .= $indent . '			</div>
';
                }
                $buffer .= $indent . '		</div>
';
                $buffer .= $indent . '	</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
