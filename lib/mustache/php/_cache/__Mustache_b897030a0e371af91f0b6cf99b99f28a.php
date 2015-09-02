<?php

class __Mustache_b897030a0e371af91f0b6cf99b99f28a extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!DOCTYPE html>
';
        $buffer .= $indent . '<html lang="en">
';
        $buffer .= $indent . '	<head>
';
        $buffer .= $indent . '		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
';
        $buffer .= $indent . '		<meta charset="utf-8" />
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<title>';
        $value = $this->resolveValue($context->findDot('page.title'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= ' - ';
        $value = $this->resolveValue($context->findDot('site.title'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '</title>	
';
        $buffer .= $indent . '		<meta name="description" content="';
        $value = $this->resolveValue($context->findDot('page.description'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '" />
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		';
        if ($partial = $this->mustache->loadPartial('layout._template.styles')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= '
';
        $buffer .= $indent . '	</head>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	<body class="no-skin">
';
        if ($partial = $this->mustache->loadPartial('layout.navbar')) {
            $buffer .= $partial->renderInternal($context, $indent . '	');
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '		<div class="main-container" id="main-container">
';
        $buffer .= $indent . '		 <script type="text/javascript">
';
        $buffer .= $indent . '		 try{ace.settings.check(\'main-container\' , \'fixed\')}catch(e){}
';
        $buffer .= $indent . '		 </script>
';
        $buffer .= $indent . '
';
        if ($partial = $this->mustache->loadPartial('layout.sidebar')) {
            $buffer .= $partial->renderInternal($context, $indent . '		 ');
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '			<div class="main-content"><div class="main-content-inner">
';
        $buffer .= $indent . '			  ';
        // 'page.no-breadcrumbs' inverted section
        $value = $context->findDot('page.no-breadcrumbs');
        if (empty($value)) {
            
            $buffer .= '
';
            if ($partial = $this->mustache->loadPartial('layout.breadcrumbs')) {
                $buffer .= $partial->renderInternal($context, $indent . '				');
            }
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '				<div class="page-content">
';
        if ($partial = $this->mustache->loadPartial('layout.settings')) {
            $buffer .= $partial->renderInternal($context, $indent . '					');
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '					';
        // 'page.no-header' inverted section
        $value = $context->findDot('page.no-header');
        if (empty($value)) {
            
            $buffer .= '
';
            $buffer .= $indent . '					<div class="page-header">
';
            $buffer .= $indent . '						<h1>';
            $value = $this->resolveValue($context->findDot('page.title'), $context, $indent);
            $buffer .= htmlspecialchars($value, 2, 'UTF-8');
            $buffer .= ' ';
            // 'page.description' section
            $value = $context->findDot('page.description');
            $buffer .= $this->sectionC4e15ab0893e4ee48db6644d970f6aa4($context, $indent, $value);
            $buffer .= '</h1>
';
            $buffer .= $indent . '					</div><!-- /.page-header -->
';
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '					<div class="row">
';
        $buffer .= $indent . '					 <div class="col-xs-12">
';
        $buffer .= $indent . '<!-- PAGE CONTENT BEGINS -->
';
        if ($partial = $this->mustache->loadPartial('page.content')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= $indent . '<!-- PAGE CONTENT ENDS -->
';
        $buffer .= $indent . '					 </div><!-- /.col -->
';
        $buffer .= $indent . '					</div><!-- /.row -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '				</div><!-- /.page-content -->
';
        $buffer .= $indent . '			</div></div><!-- /.main-content -->
';
        $buffer .= $indent . '			
';
        if ($partial = $this->mustache->loadPartial('layout.footer')) {
            $buffer .= $partial->renderInternal($context, $indent . '			');
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
';
        $buffer .= $indent . '				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
';
        $buffer .= $indent . '			</a>
';
        $buffer .= $indent . '		</div><!-- /.main-container -->
';
        $buffer .= $indent . '
';
        if ($partial = $this->mustache->loadPartial('layout._template.scripts')) {
            $buffer .= $partial->renderInternal($context, $indent . '		');
        }
        $buffer .= $indent . '	</body>
';
        $buffer .= $indent . '</html>
';

        return $buffer;
    }

    private function sectionC4e15ab0893e4ee48db6644d970f6aa4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '<small><i class="ace-icon fa fa-angle-double-right"></i> {{page.description}}</small>';
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
                
                $buffer .= '<small><i class="ace-icon fa fa-angle-double-right"></i> ';
                $value = $this->resolveValue($context->findDot('page.description'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</small>';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
