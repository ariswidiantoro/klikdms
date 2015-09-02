<?php

class __Mustache_9caef9844023242c734a085b2246914b extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!-- #section:pages/dashboard.conversations -->
';
        $buffer .= $indent . '<div class="dialogs">
';
        // 'page.conversations' section
        $value = $context->findDot('page.conversations');
        $buffer .= $this->section6975055ba90a8c4de1cc57efda2bfad1($context, $indent, $value);
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '<!-- /section:pages/dashboard.conversations -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<form>
';
        $buffer .= $indent . ' <div class="form-actions">
';
        $buffer .= $indent . '	<div class="input-group">
';
        $buffer .= $indent . '		<input placeholder="Type your message here ..." type="text" class="form-control" name="message" />
';
        $buffer .= $indent . '		<span class="input-group-btn">
';
        $buffer .= $indent . '			<button class="btn btn-sm btn-info no-radius" type="button"><i class="ace-icon fa fa-share"></i> Send</button>
';
        $buffer .= $indent . '		</span>
';
        $buffer .= $indent . '	</div>
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</form>';

        return $buffer;
    }

    private function section5f79292e3bb1a72ce8745dc9033c2622(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				<span class="label label-info arrowed arrowed-in-right">admin</span>
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
                
                $buffer .= $indent . '				<span class="label label-info arrowed arrowed-in-right">admin</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6975055ba90a8c4de1cc57efda2bfad1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
	<div class="itemdiv dialogdiv">
		<div class="user">
			<img alt="{{name}}\'s Avatar" src="{{path.assets}}/avatars/{{avatar}}" />
		</div>

		<div class="body">
			<div class="time"><i class="ace-icon fa fa-clock-o"></i> <span class="{{time-color}}">{{time}}</span></div>
			<div class="name">
				<a href="#">{{name}}</a>
				{{#admin}}
				<span class="label label-info arrowed arrowed-in-right">admin</span>
				{{/admin}}
			</div>
			<div class="text">{{message}}</div>
			
			<div class="tools">
				<a href="#" class="btn btn-minier btn-info"><i class="icon-only ace-icon fa fa-share"></i></a>
			</div>
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
                
                $buffer .= $indent . '	<div class="itemdiv dialogdiv">
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
                $buffer .= $indent . '			<div class="time"><i class="ace-icon fa fa-clock-o"></i> <span class="';
                $value = $this->resolveValue($context->find('time-color'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '">';
                $value = $this->resolveValue($context->find('time'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</span></div>
';
                $buffer .= $indent . '			<div class="name">
';
                $buffer .= $indent . '				<a href="#">';
                $value = $this->resolveValue($context->find('name'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</a>
';
                // 'admin' section
                $value = $context->find('admin');
                $buffer .= $this->section5f79292e3bb1a72ce8745dc9033c2622($context, $indent, $value);
                $buffer .= $indent . '			</div>
';
                $buffer .= $indent . '			<div class="text">';
                $value = $this->resolveValue($context->find('message'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</div>
';
                $buffer .= $indent . '			
';
                $buffer .= $indent . '			<div class="tools">
';
                $buffer .= $indent . '				<a href="#" class="btn btn-minier btn-info"><i class="icon-only ace-icon fa fa-share"></i></a>
';
                $buffer .= $indent . '			</div>
';
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
