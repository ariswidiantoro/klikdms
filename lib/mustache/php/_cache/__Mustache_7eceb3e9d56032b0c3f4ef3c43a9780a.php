<?php

class __Mustache_7eceb3e9d56032b0c3f4ef3c43a9780a extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<li class="green">
';
        $buffer .= $indent . '	<a data-toggle="dropdown" class="dropdown-toggle" href="#">
';
        $buffer .= $indent . '		<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
';
        $buffer .= $indent . '		<span class="badge badge-success">';
        $value = $this->resolveValue($context->findDot('layout.navbar_messages.count'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '</span>
';
        $buffer .= $indent . '	</a>
';
        $buffer .= $indent . '	<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
';
        $buffer .= $indent . '		<li class="dropdown-header">
';
        $buffer .= $indent . '			<i class="ace-icon fa fa-envelope-o"></i> ';
        $value = $this->resolveValue($context->findDot('layout.navbar_messages.count'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= ' Messages
';
        $buffer .= $indent . '		</li>
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<li class="dropdown-content">
';
        $buffer .= $indent . '			<ul class="dropdown-menu dropdown-navbar">
';
        // 'layout.navbar_messages.latest' section
        $value = $context->findDot('layout.navbar_messages.latest');
        $buffer .= $this->sectionE1ef1814285d67451ecca6143e1bc768($context, $indent, $value);
        $buffer .= $indent . '			</ul>
';
        $buffer .= $indent . '		</li>
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<li class="dropdown-footer">
';
        $buffer .= $indent . '			<a href="';
        // 'site.ajax' inverted section
        $value = $context->findDot('site.ajax');
        if (empty($value)) {
            
            // 'createLinkFunction' section
            $value = $context->find('createLinkFunction');
            $buffer .= $this->sectionFc875a68f3095c7a553812dec53af0df($context, $indent, $value);
        }
        // 'site.ajax' section
        $value = $context->findDot('site.ajax');
        $buffer .= $this->section780ce1a6bdbe171b8a7e393cbdd2d227($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '				See all messages
';
        $buffer .= $indent . '				<i class="ace-icon fa fa-arrow-right"></i>
';
        $buffer .= $indent . '			</a>
';
        $buffer .= $indent . '		</li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	</ul>
';
        $buffer .= $indent . '</li>';

        return $buffer;
    }

    private function sectionE1ef1814285d67451ecca6143e1bc768(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				<li>
					<a href="#" class="clearfix">
						<img src="{{path.assets}}/avatars/{{img}}" class="msg-photo" alt="{{name}}\'s Avatar">
						<span class="msg-body">
							<span class="msg-title">
								<span class="blue">{{name}}:</span>
								{{summary}}
							</span>
							<span class="msg-time">
								<i class="ace-icon fa fa-clock-o"></i> <span>{{time}}</span>
							</span>
						</span>
					</a>
				</li>
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
                
                $buffer .= $indent . '				<li>
';
                $buffer .= $indent . '					<a href="#" class="clearfix">
';
                $buffer .= $indent . '						<img src="';
                $value = $this->resolveValue($context->findDot('path.assets'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '/avatars/';
                $value = $this->resolveValue($context->find('img'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '" class="msg-photo" alt="';
                $value = $this->resolveValue($context->find('name'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '\'s Avatar">
';
                $buffer .= $indent . '						<span class="msg-body">
';
                $buffer .= $indent . '							<span class="msg-title">
';
                $buffer .= $indent . '								<span class="blue">';
                $value = $this->resolveValue($context->find('name'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= ':</span>
';
                $buffer .= $indent . '								';
                $value = $this->resolveValue($context->find('summary'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '
';
                $buffer .= $indent . '							</span>
';
                $buffer .= $indent . '							<span class="msg-time">
';
                $buffer .= $indent . '								<i class="ace-icon fa fa-clock-o"></i> <span>';
                $value = $this->resolveValue($context->find('time'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</span>
';
                $buffer .= $indent . '							</span>
';
                $buffer .= $indent . '						</span>
';
                $buffer .= $indent . '					</a>
';
                $buffer .= $indent . '				</li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFc875a68f3095c7a553812dec53af0df(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = 'inbox';
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
                
                $buffer .= 'inbox';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section780ce1a6bdbe171b8a7e393cbdd2d227(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '{{#createAjaxLinkFunction}}inbox{{/createAjaxLinkFunction}}';
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
                
                // 'createAjaxLinkFunction' section
                $value = $context->find('createAjaxLinkFunction');
                $buffer .= $this->sectionFc875a68f3095c7a553812dec53af0df($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
