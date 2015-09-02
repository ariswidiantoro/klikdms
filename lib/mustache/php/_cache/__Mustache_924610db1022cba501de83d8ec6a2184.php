<?php

class __Mustache_924610db1022cba501de83d8ec6a2184 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<table class="table table-bordered table-striped">
';
        $buffer .= $indent . '	<thead class="thin-border-bottom">
';
        $buffer .= $indent . '		<tr>
';
        $buffer .= $indent . '			<th><i class="ace-icon fa fa-caret-right blue"></i>name</th>
';
        $buffer .= $indent . '			<th><i class="ace-icon fa fa-caret-right blue"></i>price</th>
';
        $buffer .= $indent . '			<th class="hidden-480"><i class="ace-icon fa fa-caret-right blue"></i>status</th>
';
        $buffer .= $indent . '		</tr>
';
        $buffer .= $indent . '	</thead>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	<tbody>
';
        // 'page.domains' section
        $value = $context->findDot('page.domains');
        $buffer .= $this->section8ba393ea74fb7228f0af98502f88e230($context, $indent, $value);
        $buffer .= $indent . '	</tbody>
';
        $buffer .= $indent . '</table>
';

        return $buffer;
    }

    private function section398929e34b3284539d1f12997d5206e8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				 <small><s class="red">{{old_price}}</s></small>
				 <b class="green">{{price}}</b>
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
                
                $buffer .= $indent . '				 <small><s class="red">';
                $value = $this->resolveValue($context->find('old_price'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</s></small>
';
                $buffer .= $indent . '				 <b class="green">';
                $value = $this->resolveValue($context->find('price'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</b>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section68aa1dd6b5d82b07a489170692cda565(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				 <span class="label label-info arrowed-right arrowed-in">on sale</span>
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
                
                $buffer .= $indent . '				 <span class="label label-info arrowed-right arrowed-in">on sale</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3d7f0ee1811e33ab5821a797407b7aa0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				 <span class="label label-success arrowed-in arrowed-in-right">approved</span>
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
                
                $buffer .= $indent . '				 <span class="label label-success arrowed-in arrowed-in-right">approved</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCb452d8de99abafcfdc93c86a80e8656(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				 <span class="label label-danger arrowed">pending</span>
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
                
                $buffer .= $indent . '				 <span class="label label-danger arrowed">pending</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4c9c5cd5ac154e5ed1d5f33fc43fbc2b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				 <span class="label arrowed"><s>out of stock</s></span>
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
                
                $buffer .= $indent . '				 <span class="label arrowed"><s>out of stock</s></span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section39769594668ddd1aab05c401a8ed1700(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				<span class="label label-warning arrowed arrowed-right">SOLD</span>
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
                
                $buffer .= $indent . '				<span class="label label-warning arrowed arrowed-right">SOLD</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8ba393ea74fb7228f0af98502f88e230(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
		<tr>
			<td>{{name}}</td>
			<td>
				{{#old_price}}
				 <small><s class="red">{{old_price}}</s></small>
				 <b class="green">{{price}}</b>
				{{/old_price}}
				{{^old_price}}
				 <b class="blue">{{price}}</b>
				{{/old_price}}
			</td>
			<td class="hidden-480">
				{{#on_sale}}
				 <span class="label label-info arrowed-right arrowed-in">on sale</span>
				{{/on_sale}}
				{{#approved}}
				 <span class="label label-success arrowed-in arrowed-in-right">approved</span>
				{{/approved}}
				{{#pending}}
				 <span class="label label-danger arrowed">pending</span>
				{{/pending}}
				{{#out_of_stock}}
				 <span class="label arrowed"><s>out of stock</s></span>
				{{/out_of_stock}}
				 {{#sold}}
				<span class="label label-warning arrowed arrowed-right">SOLD</span>
				{{/sold}}
			</td>
		</tr>
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
                
                $buffer .= $indent . '		<tr>
';
                $buffer .= $indent . '			<td>';
                $value = $this->resolveValue($context->find('name'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</td>
';
                $buffer .= $indent . '			<td>
';
                // 'old_price' section
                $value = $context->find('old_price');
                $buffer .= $this->section398929e34b3284539d1f12997d5206e8($context, $indent, $value);
                // 'old_price' inverted section
                $value = $context->find('old_price');
                if (empty($value)) {
                    
                    $buffer .= $indent . '				 <b class="blue">';
                    $value = $this->resolveValue($context->find('price'), $context, $indent);
                    $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                    $buffer .= '</b>
';
                }
                $buffer .= $indent . '			</td>
';
                $buffer .= $indent . '			<td class="hidden-480">
';
                // 'on_sale' section
                $value = $context->find('on_sale');
                $buffer .= $this->section68aa1dd6b5d82b07a489170692cda565($context, $indent, $value);
                // 'approved' section
                $value = $context->find('approved');
                $buffer .= $this->section3d7f0ee1811e33ab5821a797407b7aa0($context, $indent, $value);
                // 'pending' section
                $value = $context->find('pending');
                $buffer .= $this->sectionCb452d8de99abafcfdc93c86a80e8656($context, $indent, $value);
                // 'out_of_stock' section
                $value = $context->find('out_of_stock');
                $buffer .= $this->section4c9c5cd5ac154e5ed1d5f33fc43fbc2b($context, $indent, $value);
                // 'sold' section
                $value = $context->find('sold');
                $buffer .= $this->section39769594668ddd1aab05c401a8ed1700($context, $indent, $value);
                $buffer .= $indent . '			</td>
';
                $buffer .= $indent . '		</tr>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
