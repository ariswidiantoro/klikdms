<?php

class __Mustache_643d3568c31b4f599c2e0e32c15f5a60 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<div class="row">
';
        $buffer .= $indent . '	<div class="col-xs-12">
';
        $buffer .= $indent . '		<table id="simple-table" class="table table-striped table-bordered table-hover">
';
        $buffer .= $indent . '			<thead>
';
        $buffer .= $indent . '				<tr>
';
        $buffer .= $indent . '					<th class="center">
';
        $buffer .= $indent . '						<label class="pos-rel"><input type="checkbox" class="ace" /><span class="lbl"></span></label>
';
        $buffer .= $indent . '					</th>
';
        $buffer .= $indent . '					<th>Domain</th>
';
        $buffer .= $indent . '					<th>Price</th>
';
        $buffer .= $indent . '					<th class="hidden-480">Clicks</th>
';
        $buffer .= $indent . '					<th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Update</th>
';
        $buffer .= $indent . '					<th class="hidden-480">Status</th>
';
        $buffer .= $indent . '					<th></th>
';
        $buffer .= $indent . '				</tr>
';
        $buffer .= $indent . '			</thead>
';
        $buffer .= $indent . '									
';
        $buffer .= $indent . '			<tbody>
';
        // 'page.domains1' section
        $value = $context->findDot('page.domains1');
        $buffer .= $this->sectionBdbbb32cfed62b959a158fc66cf357de($context, $indent, $value);
        $buffer .= $indent . '			</tbody>
';
        $buffer .= $indent . '		</table>
';
        $buffer .= $indent . '	</div><!-- /.span -->
';
        $buffer .= $indent . '</div><!-- /.row -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="hr hr-18 dotted hr-double"></div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<h4 class="pink">
';
        $buffer .= $indent . '	<i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i>
';
        $buffer .= $indent . '	<a href="#modal-table" role="button" class="green" data-toggle="modal">
';
        $buffer .= $indent . '		Table Inside a Modal Box
';
        $buffer .= $indent . '	</a>
';
        $buffer .= $indent . '</h4>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="hr hr-18 dotted hr-double"></div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="row">
';
        $buffer .= $indent . ' <div class="col-xs-12">
';
        $buffer .= $indent . '	<h3 class="header smaller lighter blue">jQuery dataTables</h3>
';
        $buffer .= $indent . '	
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	<div class="clearfix">
';
        $buffer .= $indent . '		<div class="pull-right tableTools-container"></div>
';
        $buffer .= $indent . '	</div>
';
        $buffer .= $indent . '	
';
        $buffer .= $indent . '	<div class="table-header">
';
        $buffer .= $indent . '		Results for "Latest Registered Domains"
';
        $buffer .= $indent . '	</div>
';
        $buffer .= $indent . '	  <!-- div.table-responsive -->
';
        $buffer .= $indent . '	  <!-- div.dataTables_borderWrap -->
';
        $buffer .= $indent . '	  <div>	  
';
        $buffer .= $indent . '		<table id="dynamic-table" class="table table-striped table-bordered table-hover">
';
        $buffer .= $indent . '			<thead>
';
        $buffer .= $indent . '				<tr>
';
        $buffer .= $indent . '					<th class="center">
';
        $buffer .= $indent . '						<label class="pos-rel"><input type="checkbox" class="ace" /><span class="lbl"></span></label>
';
        $buffer .= $indent . '					</th>
';
        $buffer .= $indent . '					<th>Domain</th>
';
        $buffer .= $indent . '					<th>Price</th>
';
        $buffer .= $indent . '					<th class="hidden-480">Clicks</th>
';
        $buffer .= $indent . '					<th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Update</th>
';
        $buffer .= $indent . '					<th class="hidden-480">Status</th>
';
        $buffer .= $indent . '					<th></th>
';
        $buffer .= $indent . '				</tr>
';
        $buffer .= $indent . '			</thead>
';
        $buffer .= $indent . '									
';
        $buffer .= $indent . '			<tbody>
';
        $buffer .= $indent . '
';
        // 'page.domains2' section
        $value = $context->findDot('page.domains2');
        $buffer .= $this->section7b7ebef64d84fba28b1bec71bddeb566($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '			</tbody>
';
        $buffer .= $indent . '		</table>
';
        $buffer .= $indent . '	  </div>
';
        $buffer .= $indent . ' </div>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div id="modal-table" class="modal fade" tabindex="-1">
';
        $buffer .= $indent . ' <div class="modal-dialog">
';
        $buffer .= $indent . '  <div class="modal-content">
';
        $buffer .= $indent . '	<div class="modal-header no-padding">
';
        $buffer .= $indent . '		<div class="table-header">
';
        $buffer .= $indent . '			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="white">&times;</span></button>
';
        $buffer .= $indent . '			Results for "Latest Registered Domains
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '	</div>
';
        $buffer .= $indent . '	
';
        $buffer .= $indent . '	<div class="modal-body no-padding">
';
        $buffer .= $indent . '		<table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
';
        $buffer .= $indent . '			<thead>
';
        $buffer .= $indent . '				<tr>
';
        $buffer .= $indent . '					<th>Domain</th>
';
        $buffer .= $indent . '					<th>Price</th>
';
        $buffer .= $indent . '					<th>Clicks</th>
';
        $buffer .= $indent . '					<th><i class="ace-icon fa fa-clock-o bigger-110"></i> Update</th>
';
        $buffer .= $indent . '				</tr>
';
        $buffer .= $indent . '			</thead>
';
        $buffer .= $indent . '									
';
        $buffer .= $indent . '			<tbody>
';
        // 'page.domains1' section
        $value = $context->findDot('page.domains1');
        $buffer .= $this->sectionE570709c0700fd1fcb5f469fa503402f($context, $indent, $value);
        $buffer .= $indent . '			</tbody>
';
        $buffer .= $indent . '		</table>
';
        $buffer .= $indent . '	</div>
';
        $buffer .= $indent . '	
';
        $buffer .= $indent . '	<div class="modal-footer no-margin-top">
';
        $buffer .= $indent . '		<button class="btn btn-sm btn-danger pull-left" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Close</button>
';
        $buffer .= $indent . '		<ul class="pagination pull-right no-margin">
';
        $buffer .= $indent . '			<li class="prev disabled"><a href="#"><i class="ace-icon fa fa-angle-double-left"></i></a></li>
';
        $buffer .= $indent . '			<li class="active"><a href="#">1</a></li>
';
        $buffer .= $indent . '			<li><a href="#">2</a></li>
';
        $buffer .= $indent . '			<li><a href="#">3</a></li>
';
        $buffer .= $indent . '			<li class="next"><a href="#"><i class="ace-icon fa fa-angle-double-right"></i></a></li>
';
        $buffer .= $indent . '		</ul>
';
        $buffer .= $indent . '	</div>
';
        $buffer .= $indent . '  </div><!-- /.modal-content -->
';
        $buffer .= $indent . ' </div><!-- /.modal-dialog -->
';
        $buffer .= $indent . '</div>';

        return $buffer;
    }

    private function sectionBcd9ffd6bfca1ce387f98613922af6ff(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
						<span class=\'label label-sm label-warning\'>Expiring</span>
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
                
                $buffer .= $indent . '						<span class=\'label label-sm label-warning\'>Expiring</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section497ceee0cb27c145905cbc5c8ef8b716(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
						<span class=\'label label-sm label-success\'>Registered</span>
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
                
                $buffer .= $indent . '						<span class=\'label label-sm label-success\'>Registered</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6e9971237b53445b0b9a16ba0cf8e194(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
						<span class=\'label label-sm label-inverse arrowed-in\'>Flagged</span>
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
                
                $buffer .= $indent . '						<span class=\'label label-sm label-inverse arrowed-in\'>Flagged</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD46e0a839d17259d5a933b429634e49a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
						<span class=\'label label-sm label-info arrowed arrowed-righ\'>Sold</span>
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
                
                $buffer .= $indent . '						<span class=\'label label-sm label-info arrowed arrowed-righ\'>Sold</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBdbbb32cfed62b959a158fc66cf357de(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				<tr>
					<td class=\'center\'>
						<label class="pos-rel">
							<input type=\'checkbox\' class="ace" />
							<span class="lbl"></span>
						</label>
					</td>
					<td><a href=\'#\'>{{name}}</a></td>
					<td>{{price}}</td>
					<td class=\'hidden-480\'>{{clicks}}</td>
					<td>{{update}}</td>
					<td class=\'hidden-480\'>
						{{#expiring}}
						<span class=\'label label-sm label-warning\'>Expiring</span>
						{{/expiring}}
						{{#registered}}
						<span class=\'label label-sm label-success\'>Registered</span>
						{{/registered}}
						{{#flagged}}
						<span class=\'label label-sm label-inverse arrowed-in\'>Flagged</span>
						{{/flagged}}
						{{#sold}}
						<span class=\'label label-sm label-info arrowed arrowed-righ\'>Sold</span>
						{{/sold}}
					</td>
					<td>
						<div class=\'hidden-sm hidden-xs btn-group\'>
							<button class=\'btn btn-xs btn-success\'><i class=\'ace-icon fa fa-check bigger-120\'></i></button>
							<button class=\'btn btn-xs btn-info\'><i class=\'ace-icon fa fa-pencil bigger-120\'></i></button>
							<button class=\'btn btn-xs btn-danger\'><i class=\'ace-icon fa fa-trash-o bigger-120\'></i></button>
							<button class=\'btn btn-xs btn-warning\'><i class=\'ace-icon fa fa-flag bigger-120\'></i></button>
						</div>

						<div class=\'hidden-md hidden-lg\'>
							<div class="inline pos-rel">
								<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button>
								<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
									<li><a href="#" class="tooltip-info" data-rel="tooltip" title="View"><span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>
									<li><a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"><span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>
									<li><a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"><span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span> </a></li>
								</ul>
							</div>
						</div>
						
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
                
                $buffer .= $indent . '				<tr>
';
                $buffer .= $indent . '					<td class=\'center\'>
';
                $buffer .= $indent . '						<label class="pos-rel">
';
                $buffer .= $indent . '							<input type=\'checkbox\' class="ace" />
';
                $buffer .= $indent . '							<span class="lbl"></span>
';
                $buffer .= $indent . '						</label>
';
                $buffer .= $indent . '					</td>
';
                $buffer .= $indent . '					<td><a href=\'#\'>';
                $value = $this->resolveValue($context->find('name'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</a></td>
';
                $buffer .= $indent . '					<td>';
                $value = $this->resolveValue($context->find('price'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</td>
';
                $buffer .= $indent . '					<td class=\'hidden-480\'>';
                $value = $this->resolveValue($context->find('clicks'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</td>
';
                $buffer .= $indent . '					<td>';
                $value = $this->resolveValue($context->find('update'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</td>
';
                $buffer .= $indent . '					<td class=\'hidden-480\'>
';
                // 'expiring' section
                $value = $context->find('expiring');
                $buffer .= $this->sectionBcd9ffd6bfca1ce387f98613922af6ff($context, $indent, $value);
                // 'registered' section
                $value = $context->find('registered');
                $buffer .= $this->section497ceee0cb27c145905cbc5c8ef8b716($context, $indent, $value);
                // 'flagged' section
                $value = $context->find('flagged');
                $buffer .= $this->section6e9971237b53445b0b9a16ba0cf8e194($context, $indent, $value);
                // 'sold' section
                $value = $context->find('sold');
                $buffer .= $this->sectionD46e0a839d17259d5a933b429634e49a($context, $indent, $value);
                $buffer .= $indent . '					</td>
';
                $buffer .= $indent . '					<td>
';
                $buffer .= $indent . '						<div class=\'hidden-sm hidden-xs btn-group\'>
';
                $buffer .= $indent . '							<button class=\'btn btn-xs btn-success\'><i class=\'ace-icon fa fa-check bigger-120\'></i></button>
';
                $buffer .= $indent . '							<button class=\'btn btn-xs btn-info\'><i class=\'ace-icon fa fa-pencil bigger-120\'></i></button>
';
                $buffer .= $indent . '							<button class=\'btn btn-xs btn-danger\'><i class=\'ace-icon fa fa-trash-o bigger-120\'></i></button>
';
                $buffer .= $indent . '							<button class=\'btn btn-xs btn-warning\'><i class=\'ace-icon fa fa-flag bigger-120\'></i></button>
';
                $buffer .= $indent . '						</div>
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '						<div class=\'hidden-md hidden-lg\'>
';
                $buffer .= $indent . '							<div class="inline pos-rel">
';
                $buffer .= $indent . '								<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button>
';
                $buffer .= $indent . '								<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
';
                $buffer .= $indent . '									<li><a href="#" class="tooltip-info" data-rel="tooltip" title="View"><span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>
';
                $buffer .= $indent . '									<li><a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"><span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>
';
                $buffer .= $indent . '									<li><a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"><span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span> </a></li>
';
                $buffer .= $indent . '								</ul>
';
                $buffer .= $indent . '							</div>
';
                $buffer .= $indent . '						</div>
';
                $buffer .= $indent . '						
';
                $buffer .= $indent . '					</td>
';
                $buffer .= $indent . '				</tr>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7b7ebef64d84fba28b1bec71bddeb566(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				<tr>
					<td class=\'center\'>
						<label class="pos-rel"><input type=\'checkbox\' class="ace" /><span class="lbl"></span></label>
					</td>
					<td><a href=\'#\'>{{name}}</a></td>
					<td>{{price}}</td>
					<td class=\'hidden-480\'>{{clicks}}</td>
					<td>{{update}}</td>
					<td class=\'hidden-480\'>
						{{#expiring}}
						<span class=\'label label-sm label-warning\'>Expiring</span>
						{{/expiring}}
						{{#registered}}
						<span class=\'label label-sm label-success\'>Registered</span>
						{{/registered}}
						{{#flagged}}
						<span class=\'label label-sm label-inverse arrowed-in\'>Flagged</span>
						{{/flagged}}
						{{#sold}}
						<span class=\'label label-sm label-info arrowed arrowed-righ\'>Sold</span>
						{{/sold}}
					</td>
					<td>
						<div class=\'hidden-sm hidden-xs action-buttons\'>
							<a class="blue" href="#"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>
							<a class="green" href="#"><i class="ace-icon fa fa-pencil bigger-130"></i></a>
							<a class="red" href="#"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
						</div>
						
						
						<div class=\'hidden-md hidden-lg\'>
							<div class="inline pos-rel">
								<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"><i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>
								<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
									<li><a href="#" class="tooltip-info" data-rel="tooltip" title="View"><span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>
									<li><a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"><span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>
									<li><a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"><span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span> </a></li>
								</ul>
							</div>
						</div>
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
                
                $buffer .= $indent . '				<tr>
';
                $buffer .= $indent . '					<td class=\'center\'>
';
                $buffer .= $indent . '						<label class="pos-rel"><input type=\'checkbox\' class="ace" /><span class="lbl"></span></label>
';
                $buffer .= $indent . '					</td>
';
                $buffer .= $indent . '					<td><a href=\'#\'>';
                $value = $this->resolveValue($context->find('name'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</a></td>
';
                $buffer .= $indent . '					<td>';
                $value = $this->resolveValue($context->find('price'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</td>
';
                $buffer .= $indent . '					<td class=\'hidden-480\'>';
                $value = $this->resolveValue($context->find('clicks'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</td>
';
                $buffer .= $indent . '					<td>';
                $value = $this->resolveValue($context->find('update'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</td>
';
                $buffer .= $indent . '					<td class=\'hidden-480\'>
';
                // 'expiring' section
                $value = $context->find('expiring');
                $buffer .= $this->sectionBcd9ffd6bfca1ce387f98613922af6ff($context, $indent, $value);
                // 'registered' section
                $value = $context->find('registered');
                $buffer .= $this->section497ceee0cb27c145905cbc5c8ef8b716($context, $indent, $value);
                // 'flagged' section
                $value = $context->find('flagged');
                $buffer .= $this->section6e9971237b53445b0b9a16ba0cf8e194($context, $indent, $value);
                // 'sold' section
                $value = $context->find('sold');
                $buffer .= $this->sectionD46e0a839d17259d5a933b429634e49a($context, $indent, $value);
                $buffer .= $indent . '					</td>
';
                $buffer .= $indent . '					<td>
';
                $buffer .= $indent . '						<div class=\'hidden-sm hidden-xs action-buttons\'>
';
                $buffer .= $indent . '							<a class="blue" href="#"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>
';
                $buffer .= $indent . '							<a class="green" href="#"><i class="ace-icon fa fa-pencil bigger-130"></i></a>
';
                $buffer .= $indent . '							<a class="red" href="#"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
';
                $buffer .= $indent . '						</div>
';
                $buffer .= $indent . '						
';
                $buffer .= $indent . '						
';
                $buffer .= $indent . '						<div class=\'hidden-md hidden-lg\'>
';
                $buffer .= $indent . '							<div class="inline pos-rel">
';
                $buffer .= $indent . '								<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"><i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>
';
                $buffer .= $indent . '								<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
';
                $buffer .= $indent . '									<li><a href="#" class="tooltip-info" data-rel="tooltip" title="View"><span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>
';
                $buffer .= $indent . '									<li><a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"><span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>
';
                $buffer .= $indent . '									<li><a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"><span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span> </a></li>
';
                $buffer .= $indent . '								</ul>
';
                $buffer .= $indent . '							</div>
';
                $buffer .= $indent . '						</div>
';
                $buffer .= $indent . '					</td>
';
                $buffer .= $indent . '				</tr>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE570709c0700fd1fcb5f469fa503402f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
				<tr>
					<td><a href=\'#\'>{{name}}</a></td>
					<td>{{price}}</td>
					<td>{{clicks}}</td>
					<td>{{update}}</td>
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
                
                $buffer .= $indent . '				<tr>
';
                $buffer .= $indent . '					<td><a href=\'#\'>';
                $value = $this->resolveValue($context->find('name'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</a></td>
';
                $buffer .= $indent . '					<td>';
                $value = $this->resolveValue($context->find('price'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</td>
';
                $buffer .= $indent . '					<td>';
                $value = $this->resolveValue($context->find('clicks'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</td>
';
                $buffer .= $indent . '					<td>';
                $value = $this->resolveValue($context->find('update'), $context, $indent);
                $buffer .= htmlspecialchars($value, 2, 'UTF-8');
                $buffer .= '</td>
';
                $buffer .= $indent . '				</tr>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
